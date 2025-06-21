<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 双向链表实现
 */
class DoubleLinkedList extends AbstractDoubleLinkedList
{
    /**
     * 在指定位置插入一个元素
     *
     * @param int $index 插入位置，必须在 [0, size()] 范围内
     * @param int $element 要插入的元素
     */
    public function addAt(int $index, int $element): void
    {
        // 验证索引，防止索引越界
        $this->checkIndexForAdd($index);
        // 添加到链表的头节点
        if ($index === 0) {
            // 更新头节点，并将新的头节点指向旧的头节点
            $this->head = new DoubleLinkedListNode(null, $element, $this->head);
            // 注意：如果此时的链表是空的，那么头节点和尾节点指向的是同一个链表节点
            if ($this->size === 0) {
                $this->tail = $this->head;
            }
        } else if ($index === $this->size) { // 添加到链表的尾部
            // 创建出新的尾节点，并且将这个新的尾节点的prev指针指向旧的尾节点
            $newTail = new DoubleLinkedListNode($this->tail, $element, null);
            // 旧的尾节点的next指针指向新的尾节点
            $this->tail->next = $newTail;
            // 更新尾节点
            $this->tail = $newTail;
        } else { // 不是在头部或尾部添加
            // 找到要插入的位置的前一个节点
            $prev = $this->node($index - 1);
            // 创建要插入链表的节点，并将这个节点的prev指针指向前一个节点，next指针指向后一个节点
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
        $node = $this->head;
        // 删除的是头节点
        if ($index === 0) {
            // 更新头节点，指向旧的头节点的下一个节点
            $this->head = $this->head->next;
            // 注意：如果链表中只有一个节点，那么此时head == null
            if ($this->head !== null) {
                // 更新head的prev指针，断掉与旧的头节点的联系
                $this->head->prev = null;
            }
        } else if ($index === $this->size - 1) { // 删除的是尾节点
            // 保存尾节点，用于返回
            $node = $this->tail;
            // 更新尾节点，指向旧的尾节点节点的前一个节点
            $this->tail = $this->tail->prev;
            // 此时的tail不可能是null，但是为了保持对称，保留这个判断
            if ($this->tail !== null) {
                // 更新tail的next指针，断掉与旧的尾节点的联系
                $this->tail->next = null;
            }
        } else { // 删除的不是头节点和尾节点
            // 找到要删除的节点的前一个节点
            $prev = $this->node($index - 1);
            // 获取到要删除的节点，用于返回
            $node = $prev->next;
            // prev的next指针指向要node的下一个节点，断掉与要删除节点的联系
            $prev->next = $prev->next->next;
            // 注意：此时的prev.next已经指向next
            // next指向prev，断掉与node的联系
            $prev->next->prev = $prev;
            // 注意：node.prev = null 和 node.next = null 不是必须的
            // 但是，如果是为了可读性，也是可以加上的
        }
        $this->size--;
        return $node->element;
    }
}
