<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 循环队列实现
 * 使用循环数组实现高效的队列操作
 */
class CircleQueue extends AbstractCircleQueue
{
    /**
     * 默认构造函数，使用默认容量创建循环队列
     */
    public function __construct(?int $capacity = null)
    {
        $capacity = max($capacity, self::DEFAULT_CAPACITY);
        $this->elements = array_fill(0, $capacity, null);
        $this->front = 0;
        $this->size = 0;
    }

    /**
     * 入队操作
     * @param int $element 要入队的元素
     */
    public function enQueue(int $element): void
    {
        $this->expansion($this->size + 1);
        $this->elements[$this->index($this->size)] = $element;
        $this->size++;
    }

    /**
     * 出队操作
     * @return int 队头元素
     */
    public function deQueue(): int
    {
        $oldElement = $this->elements[$this->front];
        $this->elements[$this->front] = null;
        // 之前的队头的真实索引是index(0)，出队后，队头的索引变成index(1)
        $this->front = $this->index(1);
        $this->size--;
        // 缩容
        $this->shrinking();
        return $oldElement;
    }

    /**
     * 计算循环数组中的真实索引值
     * @param int $index 相对索引
     * @return int 循环数组中的实际索引
     */
    protected function index(int $index): int
    {
        $index += $this->front;
        return $index - ($index >= count($this->elements) ? count($this->elements) : 0);
    }
}
