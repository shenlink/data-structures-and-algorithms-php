<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 单向链表节点类
 */
class SingleLinkedListNode
{
    /**
     * 节点存储的元素
     */
    public int $element;

    /**
     * 指向下一个节点的指针
     */
    public ?SingleLinkedListNode $next;

    /**
     * 创建一个新的节点
     *
     * @param int $element 节点存储的元素
     * @param ?SingleLinkedListNode $next 指向下一个节点的指针
     */
    public function __construct(int $element, ?SingleLinkedListNode $next)
    {
        $this->element = $element;
        $this->next = $next;
    }

    /**
     * 返回表示当前节点的字符串
     * @return string 表示当前节点的字符串，格式为"(element, next.element)"
     */
    public function toString(): string
    {
        // 创建StringBuilder构建返回结果
        $stringBuilder = "";

        // 添加当前节点元素和分隔符
        $stringBuilder .= "(" . $this->element . ", ";

        // 处理下一个节点的情况
        if ($this->next === null) {
            // 下一个节点为空时的特殊处理
            $stringBuilder .= "null)";
        } else {
            // 下一个节点非空时的正常处理
            $stringBuilder .= $this->next->element . ")";
        }

        // 返回构建完成的字符串
        return $stringBuilder;
    }
}
