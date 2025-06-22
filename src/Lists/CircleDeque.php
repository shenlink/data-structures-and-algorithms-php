<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 循环双端队列实现
 * 使用循环数组实现高效的双端队列操作
 */
class CircleDeque extends AbstractCircleQueue
{
    /**
     * 默认构造函数，使用默认容量创建循环双端队列
     */
    public function __construct(?int $capacity = null)
    {
        $capacity = max($capacity, self::DEFAULT_CAPACITY);
        $this->elements = array_fill(0, $capacity, null);
        $this->front = 0;
        $this->size = 0;
    }

    /**
     * 从队列尾部入队
     * @param int $element 要入队的元素
     */
    public function enQueueRear(int $element): void
    {
        $this->expansion($this->size + 1);
        // 索引必须使用index(index)的方式，因为此时队列的front头部的真实索引可能不是0了
        $this->elements[$this->index($this->size)] = $element;
        $this->size++;
    }

    /**
     * 从队列的头部出队
     * @return int 队头元素
     */
    public function deQueueFront(): int
    {
        $oldElement = $this->elements[$this->front];
        $this->elements[$this->front] = null;
        // 队头的索引更新到原先的队头的索引的下一个位置，原先的队头的索引时index(0)，
        // 所以此时的新的队头的索引是index(0 + 1)，也就是index(1)
        $this->front = $this->index(1);
        $this->size--;
        // 缩容
        $this->shrinking();
        return $oldElement;
    }

    /**
     * 从队列头部入队
     * @param int $element 要入队的元素
     */
    public function enQueueFront(int $element): void
    {
        $this->expansion($this->size + 1);
        // 此时的队头的索引是index(0)，所以队头的前一个索引就是index(-1)
        $newFront = $this->index(-1);
        $this->elements[$newFront] = $element;
        // 更新队头的索引
        $this->front = $newFront;
        $this->size++;
    }

    /**
     * 从队列尾部出队
     * @return int 队尾元素
     */
    public function deQueueRear(): int
    {
        // 计算出真实的队尾的索引
        $rearIndex = $this->index($this->size - 1);
        $oldElement = $this->elements[$rearIndex];
        $this->elements[$rearIndex] = null;
        $this->size--;
        // 缩容
        $this->shrinking();
        return $oldElement;
    }

    /**
     * 获取队尾元素
     * @return int 队尾元素
     */
    public function rear(): int
    {
        return $this->elements[$this->index($this->size - 1)];
    }

    /**
     * 计算循环数组中的真实索引值
     * @param int $index 相对索引
     * @return int 循环数组中的实际索引
     */
    protected function index(int $index): int
    {
        $index += $this->front;
        if ($index < 0) {
            return $index + count($this->elements);
        }
        return $index >= count($this->elements) ? $index - count($this->elements) : $index;
    }
}
