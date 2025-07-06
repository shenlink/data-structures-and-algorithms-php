<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Map;

/**
 * LinkedHashMap 实现，基于 HashMap 并维护插入顺序。
 * 通过双向链表记录键值对的插入顺序，在遍历时可以按照插入顺序输出。
 */
class LinkedHashMap extends HashMap
{
    /**
     * 双向链表的头节点，指向第一个插入的节点。
     */
    private ?LinkedNode $head = null;

    /**
     * 双向链表的尾节点，指向最后一个插入的节点。
     */
    private ?LinkedNode $tail = null;

    /**
     * 清空哈希表中的所有键值对，并重置双向链表的头节点和尾节点。
     */
    public function clear(): void
    {
        parent::clear();
        $this->head = null;
        $this->tail = null;
    }

    /**
     * 判断哈希表是否包含指定的值。
     * 遍历双向链表查找是否存在该值。
     *
     * @param ?string $value 要检查的值
     * @return bool 如果哈希表包含该值则返回 true
     */
    public function containsValue(?string $value): bool
    {
        $node = $this->head;
        while ($node !== null) {
            if ($value === $node->value) {
                return true;
            }
            $node = $node->next;
        }
        return false;
    }

    /**
     * 遍历哈希表中的所有键值对。
     * 使用双向链表按插入顺序输出每个节点的信息。
     *
     * @param Visitor $visitor 访问者对象
     */
    public function traversal(Visitor $visitor): void
    {
        if ($visitor === null) {
            return;
        }
        $node = $this->head;
        while ($node !== null) {
            if ($visitor->visit($node->key, $node->value) || $visitor->stop) {
                return;
            }
            $node = $node->next;
        }
    }

    /**
     * 创建一个新的 LinkedHashMap 节点，并将其加入双向链表的末尾。
     *
     * @param int $key 要存储的键
     * @param ?string $value 要存储的值
     * @param ?HashNode $parent 父节点
     * @return HashNode 新创建的节点
     */
    protected function createNode(int $key, ?string $value, ?HashNode $parent): HashNode
    {
        $node = new LinkedNode($key, $value, $parent);
        if ($this->head === null) {
            $this->head = $this->tail = $node;
        } else {
            $this->tail->next = $node;
            $node->prev = $this->tail;
            $this->tail = $node;
        }
        return $node;
    }

    /**
     * 移除节点后的调整操作。
     * 主要用于维护双向链表的完整性。
     *
     * @param ?HashNode $replacedNode 原先被删除的节点，因为度为2，使用后继节点来替代
     * @param ?HashNode $removedNode 实际被删除的节点
     */
    protected function afterRemove(?HashNode $replacedNode, ?HashNode $removedNode): void
    {
        // 将传入的节点转换为 LinkedNode 类型，以便进行后续操作
        /** @var LinkedNode|null $node1 */
        $node1 = $replacedNode;
        /** @var LinkedNode|null $node2 */
        $node2 = $removedNode;
        // 当 node1 和 node2 不同时，表示删除的是一个度为2的节点，
        // 此时实际删除的节点是 node2，
        // 如果没有交换 node1 和 node2 的位置，那遍历顺序
        // 就会与预期的遍历顺序不符
        // 如果交换 node1 与 node2 的位置，那链表就变成了
        // A <=> 1 <=> B <=> 2 <=> C，
        // 此时，node1 和 node2 的位置已经交换了，在之后删除 node2 之后，链表的遍历顺序就变成了
        // A <=> 2 <=> B <=> C，与预期的遍历顺序一致
        if ($node1 !== $node2) {
            // 交换 node1 和node2 在链表中的位置
            // 首先处理前驱指针(prev)，交换 node1 和 node2 的 prev 指向
            $tmp = $node1->prev;
            $node1->prev = $node2->prev;
            $node2->prev = $tmp;

            // 更新 node1 的前驱节点的后继(next)指向 node1
            if ($node1->prev === null) {
                $this->head = $node1; // node1 成为新的头节点
            } else {
                $node1->prev->next = $node1; // node1 的前驱节点指向它自身
            }

            // 更新 node2 的前驱节点的后继(next)指向 node2
            if ($node2->prev === null) {
                $this->tail = $node2;
            } else {
                $node2->prev->next = $node2;
            }

            // 接着处理后继指针(next)，交换 node1 和 node2 的 next 指向
            $tmp = $node1->next;
            $node1->next = $node2->next;
            $node2->next = $tmp;

            // 更新 node1 的后继节点的前驱(prev)指向 node1
            if ($node1->next === null) {
                $this->tail = $node1;
            } else {
                $node1->next->prev = $node1;
            }

            // 更新 node2 的后继节点的前驱(prev)指向 node2
            if ($node2->next === null) {
                $this->tail = $node2;
            } else {
                $node2->next->prev = $node2;
            }
        }

        // 删除实际的节点 node2，更新其前后节点的连接关系
        $prev = $node2?->prev;
        $next = $node2?->next;

        // 如果 prev 为空，说明 node2 是头节点，因此更新 head 指向 next
        if ($prev === null) {
            $this->head = $next;
        } else {
            $prev->next = $next;
        }

        // 如果 next 为空，说明 node2 是尾节点，因此更新 tail 指向 prev
        if ($next === null) {
            $this->tail = $prev;
        } else {
            $next->prev = $prev;
        }
    }
}
