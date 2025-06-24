<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 堆排序实现类
 * 利用最大堆的特性进行排序，通过构建堆并逐步取出堆顶元素完成排序。
 * 时间复杂度 O(n log n)，空间复杂度 O(1)，属于原地排序算法。
 */
class HeapSort extends Sort
{
    /**
     * 堆大小，用于记录当前堆中的元素个数。
     * @var int
     */
    private int $heapSize;

    /**
     * 对数组进行堆排序的具体逻辑。
     *
     * 排序过程分为以下几个步骤：
     * 1. 构建最大堆：从最后一个非叶子节点开始，依次向上执行下滤操作；
     * 2. 交换堆顶和堆底元素，并减少堆大小；
     * 3. 对新的堆顶执行下滤操作以恢复堆性质；
     * 4. 重复上述步骤直到堆中只剩一个元素。
     */
    protected function sortInternal(): void
    {
        $this->heapSize = count($this->elements);

        // 原地建堆
        for ($i = ($this->heapSize >> 1) - 1; $i >= 0; $i--) {
            $this->siftDown($i);
        }

        while ($this->heapSize > 1) {
            // 交换堆顶和堆底
            $this->swap(0, --$this->heapSize);
            $this->siftDown(0);
        }
    }

    /**
     * 对指定索引位置的节点执行下滤操作，以维护最大堆的性质。
     *
     * @param int $index 要下滤的节点索引
     */
    private function siftDown(int $index): void
    {
        $element = $this->elements[$index];
        $half = $this->heapSize >> 1;

        while ($index < $half) {
            $childIndex = ($index << 1) + 1;
            $child = $this->elements[$childIndex];
            $rightIndex = $childIndex + 1;

            if ($rightIndex < $this->heapSize) {
                $right = $this->elements[$rightIndex];
                if ($this->compareByIndex($rightIndex, $childIndex) > 0) {
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
