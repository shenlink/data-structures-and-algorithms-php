<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 双向循环链表实现
 */
class DoubleCircleLinkedList extends AbstractDoubleLinkedList
{

    /**
     * 在指定位置插入一个元素
     *
     * @param int $index 插入位置，必须在 [0, size()] 范围内
     * @param int $element 要插入的元素
     */
    public function addAt(int $index, $element): void
    {
        // 验证索引，防止索引越界
        $this->checkIndexForAdd($index);
        // 添加到链表头部
        if ($index == 0) {
            // 创建出新的链表头，prev指针先指向null，next指针指向旧的头节点
            $newHead = new DoubleLinkedListNode(null, $element, $this->head);
            // 此时链表的元素总数是0
            if ($this->size == 0) {
                // 新的头节点的prev和next指针都指向自己
                $newHead->prev = $newHead;
                $newHead->next = $newHead;
                // 尾节点也指向新的头节点
                $this->tail = $newHead;
            } else {
                // 获取到尾节点
                $tail = $this->node($this->size - 1);
                // 更新尾节点的next指针，指向新的头节点
                $tail->next = $newHead;
                // 更新头节点的prev指针，指向尾节点
                $newHead->prev = $tail;
            }
            // 更新头节点
            $this->head = $newHead;
        } elseif ($index == $this->size) { // 添加到链表的尾部
            // 创建出新的尾节点，尾节点的prev指针指向旧的尾节点，next指向头节点
            $newTail = new DoubleLinkedListNode($this->tail, $element, $this->head);
            // 更新尾节点的next指针，指向新的尾节点
            $this->tail->next = $newTail;
            // 更新头节点的prev指针，指向新的尾节点
            $this->head->prev = $newTail;
            // 更新尾节点，指向新的尾节点
            $this->tail = $newTail;
        } else { // 添加的不是头节点和尾节点
            // 获取到添加位置的前一个节点
            $prev = $this->node($index - 1);
            // 创建要插入链表的节点，prev指针指向前一个节点，next指针指向后一个节点
            // 新节点node的prev指向前一个节点prev，next指向prev的下一个节点next
            $node = new DoubleLinkedListNode($prev, $element, $prev->next);
            // next节点的prev指针指向新节点
            $prev->next->prev = $node;
            // prev节点的next指针指向新节点
            $prev->next = $node;
        }
        $this->size++;
    }

    /**
     * 删除指定位置的元素
     *
     * @param int $index 要删除的位置，必须在 [0, size()) 范围内
     * @return int 被删除的元素
     */
    public function remove(int $index): int
    {
        // 验证索引，防止索引越界
        $this->checkIndex($index);
        // 保存要删除的节点，默认是head节点，用于返回
        $node = $this->head;
        // 删除的是头节点
        if ($index == 0) {
            // 只有一个节点，直接置空head和tail节点
            if ($this->size == 1) {
                $this->head = null;
                $this->tail = null;
            } else {
                // 更新头节点，头节点指向旧的头的下一个节点
                $this->head = $this->head->next;
                // 尾节点指向新的头节点
                $this->tail->next = $this->head;
                // 新的头节点的prev指针指向尾节点
                $this->head->prev = $this->tail;
            }
        } elseif ($index == $this->size - 1) { // 删除的是尾节点
            // 获取到尾节点的前一个节点prev
            $prev = $this->node($index - 1);
            // 获取到尾节点，用于返回
            $node = $prev->next;
            // prev的next指针指向头节点，断掉与尾节点的联系
            $prev->next = $this->head;
            // 头节点的prev指针指向新的尾节点
            $this->head->prev = $prev;
            // tail指向新的尾节点
            $this->tail = $prev;
        } else { // 删除的是中间的节点
            // 获取到要删除的节点的前一个节点prev
            $prev = $this->node($index - 1);
            // 获取到要删除的节点，用于返回
            $node = $prev->next;
            // prev的next指针指向要删除节点的下一个节点next，断掉与要删除节点的联系
            $prev->next = $prev->next->next;
            // next节点的prev指针指向prev，断掉与要删除节点的联系
            $node->next->prev = $prev;
            // 注意：$node->prev = null 和 $node->next = null 不是必须的
            // 但是，如果是为了可读性，也是可以加上的
        }
        $this->size--;
        return $node->element;
    }
}
