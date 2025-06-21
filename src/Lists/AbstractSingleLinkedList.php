<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 抽象的单向链表实现
 * 提供了单向链表的基本操作
 */
abstract class AbstractSingleLinkedList extends AbstractList
{
    /**
     * 链表的头节点
     */
    protected ?SingleLinkedListNode $head = null;

    /**
     * 清空链表所有元素
     */
    public function clear(): void
    {
        $this->head = null;
        $this->size = 0;
    }

    /**
     * 获取指定索引的元素
     *
     * @param int $index 要获取的元素位置，必须在 [0, size()) 范围内
     * @return int 位于指定索引处的元素
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
     * @return int 元素首次出现的索引位置，如果未找到则返回 -1
     */
    public function indexOf(int $element): int
    {
        // node = head，不能修改head的值
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
     * 根据索引获取对应的链表节点
     *
     * @param int $index 要获取的索引位置
     * @return SingleLinkedListNode 对应索引位置的链表节点
     */
    protected function node(int $index): SingleLinkedListNode
    {
        // node = head，不能修改head的值
        $node = $this->head;

        // 这里的判断条件是 i < index，不能是 i <= index，因为当i = index - 1时，
        // 会再执行一次循环体里面的代码，此时node = node.next，这时候的node就是index位置的节点了
        for ($i = 0; $i < $index; $i++) {
            $node = $node->next;
        }

        return $node;
    }

    /**
     * 返回链表的字符串表示
     *
     * @return string 链表的字符串表示
     */
    public function toString(): string
    {
        $stringBuilder = "";

        // 构建头部信息、大小信息和元素列表的起始部分
        $stringBuilder .= "head: ";
        $stringBuilder .= $this->head === null ? "null" : $this->head->toString();
        $stringBuilder .= ", size: " . $this->size . ", elements: [";

        // 遍历链表节点，构建元素列表部分
        $node = $this->head;

        for ($i = 0; $i < $this->size; $i++) {
            if ($i !== 0) {
                $stringBuilder .= ", ";
            }

            $stringBuilder .= $node->toString();
            $node = $node->next;
        }

        // 添加元素列表的结束部分
        $stringBuilder .= "]";

        return $stringBuilder;
    }
}
