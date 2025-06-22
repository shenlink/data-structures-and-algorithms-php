<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 抽象的循环队列实现
 * 提供了循环队列的基本操作和通用功能
 */
abstract class AbstractCircleQueue
{
    /**
     * 队列头部的索引
     */
    protected int $front;

    /**
     * 队列中元素的数量
     */
    protected int $size;

    /**
     * 存储队列元素的数组
     * @var array<int|null>
     */
    protected array $elements;

    /**
     * 默认容量
     */
    protected const DEFAULT_CAPACITY = 10;

    /**
     * 清空队列所有元素
     */
    public function clear(): void
    {
        for ($i = 0; $i < $this->size; $i++) {
            $this->elements[$this->index($i)] = null;
        }
        $this->front = 0;
        $this->size = 0;
    }

    /**
     * 获取队列中的元素数量
     * @return int 元素个数
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * 检查队列是否为空
     * @return bool 如果队列没有元素则返回 true
     */
    public function isEmpty(): bool
    {
        return $this->size === 0;
    }

    /**
     * 获取队头元素
     * @return int 队头元素
     */
    public function front(): int
    {
        return $this->elements[$this->front];
    }

    /**
     * 计算元素在底层数组中的实际索引
     * @param int $index 要计算的相对索引值
     * @return int 实际索引值
     */
    abstract protected function index(int $index): int;

    /**
     * 扩容队列底层数组
     * 当元素数量大于底层数组长度时，扩容到原来的1.5倍
     * @param int $capacity 需要达到的最小容量
     */
    protected function expansion(int $capacity): void
    {
        // 验证容量，如果此时的容量还没有大于队列底层数组的长度，不需要进行扩容
        if ($this->checkCapacity($capacity)) {
            return;
        }
        $oldCapacity = count($this->elements);
        // 新容量是旧容量的1.5倍
        $newCapacity = $oldCapacity + ($oldCapacity >> 1);
        $newElements = array_fill(0, $newCapacity, null);
        // 计算旧的底层数组的索引时，必须使用index(index)的方式，因为此时队列的front头部的真实索引可能不是0了
        for ($i = 0; $i < $this->size; $i++) {
            $newElements[$i] = $this->elements[$this->index($i)];
        }
        $this->elements = $newElements;
        // 重置front的索引为0，之前的front的真实索引时根据旧的底层数组的length计算出来的，
        // 现在底层数组的length已经发生改变了，所以需要重新计算新的底层数组的索引
        // 但是为了方便，直接改成0
        $this->front = 0;
    }

    /**
     * 检查是否需要扩容
     * @param int $capacity 需要检查的容量
     * @return bool 如果当前容量足够则返回true
     */
    protected function checkCapacity(int $capacity): bool
    {
        return count($this->elements) >= $capacity;
    }

    /**
     * 缩容队列底层数组
     * 当元素数量小于等于数组容量的一半时，缩容到一半
     */
    protected function shrinking(): void
    {
        $oldCapacity = count($this->elements);
        // 位运算，新容量为之前旧容量的一半
        $newCapacity = $oldCapacity >> 1;
        // 如果当前的元素数量大于新容量或者新容量小于默认容量，不需要缩容
        if ($this->size > $newCapacity || $newCapacity < self::DEFAULT_CAPACITY) {
            return;
        }
        $newElements = array_fill(0, $newCapacity, null);
        // 计算旧的底层数组的索引时，必须使用index(index)的方式，因为此时队列的front头部的真实索引可能不是0了
        for ($i = 0; $i < $this->size; $i++) {
            $newElements[$i] = $this->elements[$this->index($i)];
        }
        $this->elements = $newElements;
        // 重置front的索引为0，之前的front的真实索引时根据旧的底层数组的length计算出来的，
        // 现在底层数组的length已经发生改变了，所以需要重新计算新的底层数组的索引
        // 但是为了方便，直接改成0
        $this->front = 0;
    }

    /**
     * 返回循环队列的字符串表示
     * @return string 循环队列的详细信息，包括头部信息、大小信息和元素列表
     */
    public function toString(): string
    {
        // 创建StringBuilder以构建字符串
        $stringBuilder = "size: {$this->size}, elements: [";
        // 遍历elements数组中的有效元素并添加到字符串中
        for ($i = 0; $i < $this->size; $i++) {
            if ($i !== 0) {
                $stringBuilder .= ", ";
            }
            $stringBuilder .= (string)$this->elements[$this->index($i)];
        }
        // 添加elements内容后的"]"和capacity信息
        $stringBuilder .= "]"
            . ", capacity: " . count($this->elements)
            . ", origin: [";
        // 遍历整个elements数组，包括null值，并添加到字符串中
        for ($i = 0; $i < count($this->elements); $i++) {
            if ($i !== 0) {
                $stringBuilder .= ", ";
            }
            $stringBuilder .= is_null($this->elements[$i]) ? "null" : (string)$this->elements[$i];
        }
        // 添加origin数组后的"]"
        $stringBuilder .= "]";
        // 返回构建好的字符串
        return $stringBuilder;
    }
}
