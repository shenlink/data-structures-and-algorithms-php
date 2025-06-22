<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

use InvalidArgumentException;
use OutOfBoundsException;
use RuntimeException;
use Shenlink\Algorithms\Utils\Comparator;

/**
 * 优先队列实现
 * 底层使用二叉堆实现，默认为最小堆
 */
class PriorityQueue
{
    /**
     * 存储元素的数组
     * @var array<int>
     */
    private array $elements = [];

    /**
     * 队列中实际元素个数
     */
    private int $size = 0;

    /**
     * 元素比较器，默认为null，此时使用元素的自然顺序进行比较
     */
    private Comparator $comparator;

    /**
     * 堆底层的数组的默认初始容量
     * @var int
     */
    private const DEFAULT_CAPACITY = 10;

    /**
     * 创建一个优先队列
     * @param ?Comparator $comparator 用于比较元素优先级的比较器
     */
    public function __construct(?Comparator $comparator = null)
    {
        $this->comparator = $comparator;
        $this->elements = array_fill(0, self::DEFAULT_CAPACITY, null);
    }

    /**
     * 入队操作
     * @param int $element 要入队的元素
     */
    public function enQueue(int $element): void
    {
        // 元素不能为null
        $this->checkElement($element);
        // 扩容判断：当插入新元素后超出当前容量时进行扩容
        $this->expansion($this->size + 1);
        // 将元素添加到数组末尾（堆底）
        $this->elements[$this->size] = $element;
        $this->size++;
        // 新元素上滤操作：从最后一个位置开始向上调整堆，恢复堆特性
        $this->siftUp($this->size - 1);
    }

    /**
     * 出队操作
     * @return int 优先级最高的元素
     */
    public function deQueue(): int
    {
        if ($this->size == 0) {
            throw new RuntimeException("Queue is empty");
        }
        // 取出堆顶元素作为返回值
        $root = $this->elements[0];
        // 将最后一个元素移到堆顶位置
        $this->elements[0] = $this->elements[--$this->size];
        $this->elements[$this->size] = null; // 清空最后一个位置的引用
        // 如果堆中还有元素，则从堆顶开始下滤操作
        if ($this->size > 0) {
            $this->siftDown(0);
        }
        return $root;
    }

    /**
     * 获取队首元素（优先级最高的元素）
     * @return int 队首元素
     */
    public function front(): int
    {
        if ($this->size == 0) {
            throw new OutOfBoundsException("Heap is empty");
        }
        return $this->elements[0];
    }

    /**
     * 清空队列
     */
    public function clear(): void
    {
        for ($i = 0; $i < $this->size; $i++) {
            $this->elements[$i] = null;
        }
        $this->size = 0;
    }

    /**
     * 获取队列中的元素数量
     * @return int 元素数量
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * 检查队列是否为空
     * @return bool 如果队列为空则返回 true
     */
    public function isEmpty(): bool
    {
        return $this->size === 0;
    }

    /**
     * 上滤操作：将指定索引位置的元素向上调整到合适的位置，以维持堆特性。
     * @param int $index 需要上滤的元素索引
     */
    private function siftUp(int $index): void
    {
        // 备份新添加的元素
        $element = $this->elements[$index];
        // index > 0的时候才有上滤的必要
        while ($index > 0) {
            // 计算父节点索引
            $parentIndex = ($index - 1) >> 1;
            // 获取父节点
            $parent = $this->elements[$parentIndex];
            // 如果要添加的元素小于等于这个父节点，则说明上滤到了合适的位置
            if ($this->compare($element, $parent) <= 0) {
                break;
            }
            // 父节点更大，需要将父节点下移至当前位置
            $this->elements[$index] = $parent;
            // 继续向上检查，更新索引为父节点位置
            $index = $parentIndex;
        }
        // 在合适位置放置原始元素
        $this->elements[$index] = $element;
    }

    /**
     * 下滤操作：将指定索引位置的元素向下调整到合适的位置，以维持堆特性。
     * @param int $index 需要下滤的元素索引
     */
    private function siftDown(int $index): void
    {
        // 备份当前元素
        $element = $this->elements[$index];
        // half是最后一个非叶子节点的索引
        $half = $this->size >> 1;
        while ($index < $half) {
            // 左子节点索引
            $childIndex = ($index << 1) + 1;
            $child = $this->elements[$childIndex];
            // 右子节点索引
            $rightIndex = $childIndex + 1;
            // 判断是否存在右子节点，并选择较大的子节点
            if ($rightIndex < $this->size) {
                $right = $this->elements[$rightIndex];
                if ($this->compare($right, $child) > 0) {
                    $child = $right;
                    $childIndex = $rightIndex;
                }
            }
            // 如果当前元素大于等于较大子节点，则满足堆特性
            if ($this->compare($element, $child) >= 0) {
                break;
            }
            // 较大的子节点上移至当前节点位置
            $this->elements[$index] = $child;
            // 继续向下检查，更新索引为较大子节点位置
            $index = $childIndex;
        }
        // 在合适位置放置原始元素
        $this->elements[$index] = $element;
    }

    /**
     * 比较两个元素的大小
     * @param int $e1 第一个元素
     * @param int $e2 第二个元素
     * @return int 比较结果
     */
    private function compare(int $e1, int $e2): int
    {
        if ($this->comparator != null) {
            return $this->comparator->compare($e1, $e2);
        }
        return $e1 <=> $e2;
    }

    /**
     * 验证元素，元素不能为null
     * @param int $element 待验证的元素
     */
    private function checkElement(int $element): void
    {
        if ($element === null) {
            throw new InvalidArgumentException("element must not be null");
        }
    }

    /**
     * 扩容，数组容量不够，扩容加大容量到原始容量的1.5倍
     * @param int $capacity 需要达到的最小容量
     */
    private function expansion(int $capacity): void
    {
        $oldCapacity = count($this->elements);
        if ($oldCapacity >= $capacity) {
            return;
        }
        // 按照1.5倍比例扩容
        $newCapacity = $oldCapacity + ($oldCapacity >> 1);
        // 创建新的数组容器
        $newElements = array_fill(0, $newCapacity, null);
        // 将原有数据迁移至新数组
        for ($i = 0; $i < $this->size; $i++) {
            $newElements[$i] = $this->elements[$i];
        }
        // 更新底层存储数组
        $this->elements = $newElements;
    }
}
