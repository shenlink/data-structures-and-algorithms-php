<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 3路快速排序实现类
 * 基于分治策略进行排序，采用三向切分方式处理重复元素，适用于包含大量重复元素的数组。
 * 时间复杂度平均为 O(n log n)，最差情况下为 O(n^2)，空间复杂度为 O(log n)。
 */
class QuickSort3Way extends Sort
{
    /**
     * 对数组进行排序，默认从整个数组范围开始排序。
     */
    public function sortInternal(): void
    {
        $this->quickSort(0, count($this->elements));
    }

    /**
     * 对指定范围内的数组进行3路快速排序。
     *
     * 排序过程分为以下几个步骤：
     * 1. 如果起始索引大于等于结束索引，则无需排序，直接返回；
     * 2. 随机选择一个基准元素，并将其交换到起始位置；
     * 3. 定义三个指针 lt、i 和 gt 分别指向小于、等于和大于基准值的区域；
     * 4. 遍历数组并根据当前元素与基准值的比较结果调整元素位置；
     * 5. 将基准值放到正确的位置上，并对左右两个子数组分别递归排序。
     *
     * @param int $begin 排序范围的起始索引（包含）
     * @param int $end   排序范围的结束索引（不包含）
     */
    private function quickSort(int $begin, int $end): void
    {
        if ($begin >= $end) {
            return;
        }

        $randomIndex = $begin + random_int(0, $end - $begin - 1);
        $this->swap($begin, $randomIndex);

        $lt = $begin;
        $i = $begin + 1;
        $gt = $end;

        while ($i < $gt) {
            if ($this->compareByIndex($i, $begin) < 0) {
                $lt++;
                $this->swap($i++, $lt);
            } elseif ($this->compareByIndex($i, $begin) > 0) {
                $gt--;
                $this->swap($i, $gt);
            } else {
                $i++;
            }
        }

        $this->swap($begin, $lt);
        $this->quickSort($begin, $lt);
        $this->quickSort($gt, $end);
    }
}
