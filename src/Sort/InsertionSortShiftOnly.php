<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 插入排序优化版
 * 将插入排序的交换操作改为赋值操作以提高性能
 */
class InsertionSortShiftOnly extends Sort
{
    /**
     * 对数组进行排序，采用优化插入排序算法。
     * 每轮将当前元素向前移动到合适位置，减少不必要的交换操作。
     * 排序过程：
     * - 从第二个元素开始遍历，每次取出当前位置的元素；
     * - 通过比较与前一个元素的大小，将前面较大的元素向后移动；
     * - 直到找到合适的位置再将当前元素插入；
     * - 这样可以减少交换次数，提升排序效率。
     */
    protected function sortInternal(): void
    {
        for ($begin = 1; $begin < count($this->elements); $begin++) {
            $current = $begin;
            $v = $this->elements[$current];

            while ($current > 0 && $v < $this->elements[$current - 1]) {
                $this->elements[$current] = $this->elements[$current - 1];
                $current--;
            }

            $this->elements[$current] = $v;
        }
    }
}
