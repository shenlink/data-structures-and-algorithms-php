<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 双向链表节点类
 */
class DoubleLinkedListNode
{
    /**
     * 指向前一个节点的指针
     */
    public ?DoubleLinkedListNode $prev;

    /**
     * 节点存储的值
     * @var int
     */
    public int $element;

    /**
     * 指向后一个节点的指针
     */
    public ?DoubleLinkedListNode $next;

    /**
     * 创建一个新的链表节点
     *
     * @param ?DoubleLinkedListNode $prev 指向前一个节点的指针
     * @param int $element 节点存储的值
     * @param ?DoubleLinkedListNode $next 指向后一个节点的指针
     */
    public function __construct(?DoubleLinkedListNode $prev, int $element, ?DoubleLinkedListNode $next)
    {
        $this->element = $element;
        $this->prev = $prev;
        $this->next = $next;
    }

    /**
     * 返回表示当前节点的字符串
     * 此方法查看当前对象的前驱（prev）、当前元素（element）和后继（next），并将它们的字符串表示拼接起来
     * 如果前驱或后继节点为空，则在相应位置以 null 表示
     *
     * @return string 包含前驱、当前元素和后继链表节点信息的字符串
     */
    public function toString(): string
    {
        $stringBuilder = '';
        if ($this->prev === null) {
            $stringBuilder .= "(null, ";
        } else {
            $stringBuilder .= "(" . $this->prev->element . ", ";
        }
        $stringBuilder .= $this->element . ", ";
        if ($this->next === null) {
            $stringBuilder .= "null)";
        } else {
            $stringBuilder .= $this->next->element . ")";
        }
        return $stringBuilder;
    }
}
