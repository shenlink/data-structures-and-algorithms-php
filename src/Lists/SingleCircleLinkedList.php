<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 单向循环链表实现
 */
class SingleCircleLinkedList extends AbstractSingleLinkedList
{
    /**
     * 在指定位置插入元素
     *
     * @param int $index 插入位置，必须在 [0, size()] 范围内
     * @param int $element 要插入的元素
     */
    public function addAt(int $index, int $element): void
    {
        // 验证索引，防止索引越界
        $this->checkIndexForAdd($index);

        // 在头节点添加元素
        if ($index === 0) {
            // 创建新的头节点，next指针指向旧的头节点
            $newHead = new SingleLinkedListNode($element, $this->head);
            // 如果此时的元素总数是0，尾节点也指向这个新的头节点，否则，指向链表的最后一个节点
            // 注意：不能统一使用node(size - 1)，因为size == 0时，链表还没有节点，此时调用
            // node(size - 1)，返回的是错误的结果
            $tail = $this->size === 0 ? $newHead : $this->node($this->size - 1);
            // 尾节点的next指针指向新的头节点
            $tail->next = $newHead;
            // 更新头节点
            $this->head = $newHead;
        } else {
            // 添加的不是头节点
            // 获取到要添加的索引的前一个节点prev
            $prev = $this->node($index - 1);
            // prev的next指针指向新的节点node，node的next指针指向prev.next，
            // 也就是next节点，这样，node节点就与prev和next连接上了
            $prev->next = new SingleLinkedListNode($element, $prev->next);
        }

        $this->size++;
    }

    /**
     * 删除指定位置的节点
     *
     * @param int $index 要删除的位置，必须在 [0, size()) 范围内
     * @return int 被删除的元素
     */
    public function remove(int $index): int
    {
        // 验证索引，防止索引越界
        $this->checkIndex($index);

        // 保存要删除的节点，用于返回
        $node = $this->head;

        // 删除的是头节点
        if ($index === 0) {
            // 链表的元素总是是1，直接置空head节点
            if ($this->size === 1) {
                $this->head = null;
            } else {
                // 获取到尾节点
                $tail = $this->node($this->size - 1);
                // 头节点指向旧的头节点的next节点，断掉与旧的头节点的联系
                $this->head = $this->head->next;
                // 尾节点的next指针指向新的头节点
                $tail->next = $this->head;
            }
        } else {
            // 删除的不是头节点
            // 获取到要删除的索引的前一个节点prev
            $prev = $this->node($index - 1);
            // 获取到要删除的节点node，用于返回
            $node = $prev->next;
            // prev的next指向要删除的节点node的next节点，断掉与node的联系
            $prev->next = $node->next;
            // 注意：此时，可以将node.next设置为null，但这不是必须的，为了可读性，可以加上
        }

        $this->size--;
        return $node->element;
    }
}
