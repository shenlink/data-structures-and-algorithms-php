<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Heap;

use InvalidArgumentException;
use OutOfBoundsException;
use Shenlink\Algorithms\Utils\Comparator;

/**
 * 二叉堆
 */
class BinaryHeap extends AbstractHeap
{
    /**
     * 堆底层的数组
     *
     * @var array<int>
     */
    private array $elements = [];

    /**
     * 堆底层的数组的默认容量
     *
     * @var int
     */
    private const DEFAULT_CAPACITY = 10;

    /**
     * 使用指定元素数组和比较器构造一个二叉堆。
     *
     * @param array<int> $elements 要使用的元素数组
     * @param ?Comparator $comparator 用于比较元素的比较器
     */
    public function __construct(array $elements = [], ?Comparator $comparator = null)
    {
        parent::__construct($comparator);

        if (empty($elements)) {
            $this->elements = array_fill(0, self::DEFAULT_CAPACITY, null);
        } else {
            $this->size = count($elements);
            $capacity = max(self::DEFAULT_CAPACITY, $this->size);
            $this->elements = array_fill(0, $capacity, null);
            for ($i = 0; $i < $this->size; $i++) {
                $this->elements[$i] = $elements[$i];
            }
            $this->heapify();
        }
    }

    /**
     * 清除堆中的所有元素。
     */
    public function clear(): void
    {
        $count = count($this->elements);
        for ($i = 0; $i < $count; $i++) {
            $this->elements[$i] = null;
        }
        $this->size = 0;
    }

    /**
     * 向堆中添加一个元素。
     *
     * @param int $element 要添加的元素
     */
    public function add(int $element): void
    {
        $this->expansion($this->size + 1);
        $this->elements[$this->size] = $element;
        $this->size++;
        $this->siftUp($this->size - 1);
    }

    /**
     * 获取堆顶元素，但不移除它。
     *
     * @return int|null 堆顶元素，如果堆为空返回 null
     * @throws OutOfBoundsException 如果堆为空，抛出 OutOfBoundsException 异常
     */
    public function get(): ?int
    {
        if ($this->size === 0) {
            throw new OutOfBoundsException("Heap is empty");
        }
        return $this->elements[0];
    }

    /**
     * 移除并返回堆顶元素。
     * 用堆底元素覆盖堆顶元素，删除堆底元素，然后对堆顶元素进行下滤。
     *
     * @return ?int 被移除的堆顶元素，如果堆为空返回 null
     * @throws OutOfBoundsException 如果堆为空，抛出 OutOfBoundsException 异常
     */
    public function remove(): ?int
    {
        if ($this->size === 0) {
            throw new OutOfBoundsException("Heap is empty");
        }
        $lastIndex = $this->size - 1;
        $root = $this->elements[0];
        $this->elements[0] = $this->elements[$lastIndex];
        $this->elements[$lastIndex] = null;
        $this->size--;
        $this->siftDown(0);
        return $root;
    }

    /**
     * 替换堆顶元素，并返回旧的堆顶元素。
     * 如果此时堆内没有元素，则添加该元素，并返回null。
     *
     * @param int $element 新的堆顶元素
     * @return ?int 原来的堆顶元素，如果堆为空返回 null
     */
    public function replace(int $element): ?int
    {
        if ($this->size === 0) {
            $this->elements[0] = $element;
            $this->size++;
            return null;
        }
        $oldElement = $this->elements[0];
        $this->elements[0] = $element;
        $this->siftDown(0);
        return $oldElement;
    }

    /**
     * 批量建堆操作，使用自下而上的下滤方式。
     */
    private function heapify(): void
    {
        for ($i = ($this->size >> 1) - 1; $i >= 0; $i--) {
            $this->siftDown($i);
        }
    }

    /**
     * 根据需要扩展堆的容量。
     * 扩容加大容量到原始容量的1.5倍
     *
     * @param int $capacity 需要的最小容量
     */
    private function expansion(int $capacity): void
    {
        $oldCapacity = count($this->elements);
        if ($oldCapacity >= $capacity) {
            return;
        }
        $newCapacity = $oldCapacity + ($oldCapacity >> 1);
        $newElements = array_fill(0, $newCapacity, null);
        for ($i = 0; $i < $this->size; $i++) {
            $newElements[$i] = $this->elements[$i];
        }
        $this->elements = $newElements;
    }

    /**
     * 对索引处的元素执行上滤操作以维护堆性质。
     *
     * @param int $index 需要上滤的元素索引
     */
    private function siftUp(int $index): void
    {
        $element = $this->elements[$index];
        while ($index > 0) {
            $parentIndex = ($index - 1) >> 1;
            $parent = $this->elements[$parentIndex];
            if ($this->compare($element, $parent) <= 0) {
                break;
            }
            $this->elements[$index] = $parent;
            $index = $parentIndex;
        }
        $this->elements[$index] = $element;
    }

    /**
     * 对索引处的元素执行下滤操作以维护堆性质。
     *
     * @param int $index 需要下滤的元素索引
     */
    private function siftDown(int $index): void
    {
        $element = $this->elements[$index];
        $half = $this->size >> 1;
        while ($index < $half) {
            $childIndex = ($index << 1) + 1;
            $child = $this->elements[$childIndex];
            $rightIndex = $childIndex + 1;
            if ($rightIndex < $this->size) {
                $right = $this->elements[$rightIndex];
                if ($this->compare($right, $child) > 0) {
                    $child = $right;
                    $childIndex = $rightIndex;
                }
            }
            if ($this->compare($element, $child) >= 0) {
                break;
            }
            $this->elements[$index] = $child;
            $index = $childIndex;
        }
        $this->elements[$index] = $element;
    }
}
