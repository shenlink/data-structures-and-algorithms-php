<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 抽象的双向链表实现
 * 提供了双向链表的基本操作
 */
abstract class AbstractDoubleLinkedList extends AbstractList
{
    /**
     * 链表的头节点
     */
    protected ?DoubleLinkedListNode $head = null;

    /**
     * 链表的尾节点
     * @var ?DoubleLinkedListNode
     */
    protected ?DoubleLinkedListNode $tail = null;

    /**
     * 链表的元素数量
     */
    protected int $size = 0;

    /**
     * 清空链表所有元素
     */
    public function clear(): void
    {
        $this->head = null;
        $this->tail = null;
        $this->size = 0;
    }

    /**
     * 获取指定位置的元素
     *
     * @param int $index 要获取的元素位置，必须在 [0, size()) 范围内
     * @return int 位于指定位置处的元素
     * @throws \OutOfRangeException 如果索引越界，则抛出 OutOfRangeException 异常
     */
    public function get(int $index): int
    {
        $this->checkIndex($index);
        return $this->node($index)->element;
    }

    /**
     * 替换指定位置的元素
     *
     * @param int $index 要替换的位置，必须在 [0, size()) 范围内
     * @param int $element 新元素
     * @return int 被替换的旧元素
     * @throws \OutOfRangeException 如果索引越界，则抛出 OutOfRangeException 异常
     */
    public function set(int $index, int $element): int
    {
        $this->checkIndex($index);
        $node = $this->node($index);
        $oldElement = $node->element;
        $node->element = $element;
        return $oldElement;
    }

    /**
     * 查找指定元素第一次出现的位置
     *
     * @param int $element 要查找的元素
     * @return int 元素首次出现的位置位置，如果未找到则返回 -1
     */
    public function indexOf(int $element): int
    {
        $node = $this->head;
        for ($i = 0; $i < $this->size; $i++) {
            if ($node->element === $element) {
                return $i;
            }
            $node = $node->next;
        }
        return self::ELEMENT_NOT_FOUND;
    }

    /**
     * 根据位置获取对应的链表节点
     *
     * @param int $index 要获取的位置位置
     * @return DoubleLinkedListNode 对应位置位置的链表节点
     */
    protected function node(int $index): DoubleLinkedListNode
    {
        if ($index < ($this->size >> 1)) {
            $node = $this->head;
            for ($i = 0; $i < $index; $i++) {
                $node = $node->next;
            }
            return $node;
        }
        $node = $this->tail;
        for ($i = $this->size - 1; $i > $index; $i--) {
            $node = $node->prev;
        }
        return $node;
    }

    /**
     * 返回链表的字符串表示
     *
     * @return string 链表的详细信息，包括头节点、尾节点、大小和所有元素
     */
    public function toString(): string
    {
        $stringBuilder = '';
        $stringBuilder .= "head: " . ($this->head === null ? "null" : $this->head->toString()) . ", ";
        $stringBuilder .= "tail: " . ($this->tail === null ? "null" : $this->tail->toString()) . ", ";
        $stringBuilder .= "size: " . $this->size() . ", elements: [";

        $node = $this->head;
        for ($i = 0; $i < $this->size(); $i++) {
            if ($i !== 0) {
                $stringBuilder .= ", ";
            }
            $stringBuilder .= $node->toString();
            $node = $node->next;
        }

        $stringBuilder .= "]";
        return $stringBuilder;
    }
}
