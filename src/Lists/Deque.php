<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 双端队列实现类，使用双向链表作为底层实现
 */
class Deque
{
    /**
     * 使用双向链表实现
     */
    private IList $list;

    public function __construct()
    {
        $this->list = new DoubleLinkedList();
    }

    /**
     * 将元素添加到队尾
     * @param int $element 要添加的元素
     */
    public function enQueueRear(int $element): void
    {
        $this->list->add($element);
    }

    /**
     * 移除并返回队头元素
     * @return int 队头元素
     */
    public function deQueueFront(): int
    {
        return $this->list->remove(0);
    }

    /**
     * 将元素添加到队头
     * @param int $element 要添加的元素
     */
    public function enQueueFront(int $element): void
    {
        $this->list->addAt(0, $element);
    }

    /**
     * 移除并返回队尾元素
     * @return int 队尾元素
     */
    public function deQueueRear(): int
    {
        return $this->list->remove($this->list->size() - 1);
    }

    /**
     * 获取但不移除队头元素
     * @return int 队头元素
     */
    public function front(): int
    {
        return $this->list->get(0);
    }

    /**
     * 获取但不移除队尾元素
     * @return int 队尾元素
     */
    public function rear(): int
    {
        return $this->list->get($this->list->size() - 1);
    }

    /**
     * 清空队列中的所有元素
     */
    public function clear(): void
    {
        $this->list->clear();
    }

    /**
     * 返回队列中的元素数量
     * @return int 队列中的元素数量
     */
    public function size(): int
    {
        return $this->list->size();
    }

    /**
     * 判断队列是否为空
     * @return bool 如果队列为空则返回 true，否则返回 false
     */
    public function isEmpty(): bool
    {
        return $this->list->isEmpty();
    }
}
