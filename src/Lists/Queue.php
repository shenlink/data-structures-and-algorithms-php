<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 普通队列实现，使用双向链表作为底层存储结构
 */
class Queue
{
    /**
     * 使用双向链表实现队列
     */
    private IList $list;

    public function __construct()
    {
        $this->list = new DoubleLinkedList();
    }

    /**
     * 入队操作
     * @param int $element 要入队的元素
     */
    public function enQueue(int $element): void
    {
        $this->list->add($element);
    }

    /**
     * 出队操作
     * @return int 队头元素
     */
    public function deQueue(): int
    {
        return $this->list->remove(0);
    }

    /**
     * 获取队头元素
     * @return int 队头元素
     */
    public function front(): int
    {
        return $this->list->get(0);
    }

    /**
     * 清空队列
     */
    public function clear(): void
    {
        $this->list->clear();
    }

    /**
     * 获取队列中的元素数量
     * @return int 元素数量
     */
    public function size(): int
    {
        return $this->list->size();
    }

    /**
     * 检查队列是否为空
     * @return bool 如果队列为空则返回 true，否则返回 false
     */
    public function isEmpty(): bool
    {
        return $this->list->isEmpty();
    }
}
