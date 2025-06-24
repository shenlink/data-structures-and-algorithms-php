<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 冒泡排序优化版
 * 通过记录每轮最后一次交换的位置，减少无意义的比较范围
 */
class BubbleSortLastSwap extends Sort
{
    /**
     * 对数组进行排序，采用冒泡排序优化算法。
     * 每一轮遍历中记录最后一个交换的位置，作为下一轮比较的边界，
     * 减少不必要的比较次数，提高效率。
     */
    protected function sortInternal(): void
    {
        // 有序区的边界，每次循环都将无序区间的边界向左移动一位
        $sortedIndex = 1;
        // 执行 n - 1 轮循环
        for ($end = count($this->elements) - 1; $end > 0; $end--) {
            // 这里设置为1，在这轮循环中，如果没有发生一次交换，
            // 那 end = sortedIndex，则下一轮循环时，end == 0，结束循环
            $sortedIndex = 1;
            for ($begin = 1; $begin <= $end; $begin++) {
                if ($this->compareByIndex($begin, $begin - 1) < 0) {
                    $this->swap($begin, $begin - 1);
                    $sortedIndex = $begin;
                }
            }
            // sortedIndex是最后一次有序的位置，
            // end = sortedIndex，下一轮循环时，
            // end = sortedIndex - 1
            $end = $sortedIndex;
        }
    }
}
