<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 插入排序实现类
 * 通过构建有序序列，对于未排序数据，在已排序序列中从后向前扫描，找到相应位置并插入。
 */
class InsertionSortBasic extends Sort
{
    /**
     * 执行插入排序的具体逻辑。
     *
     * 排序过程：
     * - 循环 n - 1 轮，每轮将当前元素插入到前面已经排序的元素中的合适位置；
     * - 从当前元素开始往前找，如果当前元素比前一个元素小，则交换位置；
     * - 交换之后，继续向前查看，直到找到合适的位置或者到达数组起始位置。
     */
    protected function sortInternal(): void
    {
        for ($begin = 1; $begin < count($this->elements); $begin++) {
            $current = $begin;
            while ($current > 0 && $this->compareByIndex($current, $current - 1) < 0) {
                $this->swap($current, $current - 1);
                $current--;
            }
        }
    }
}
