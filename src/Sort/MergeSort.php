<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 归并排序实现类
 * 基于分治策略进行排序，将数组分为两个子数组分别排序后合并，
 * 时间复杂度为 O(n log n)，空间复杂度为 O(n)。
 */
class MergeSort extends Sort
{
    /**
     * 左边的数组，可以重复利用以减少内存分配
     * @var array<int>
     */
    private array $leftArray;

    /**
     * 执行归并排序，默认从整个数组范围开始排序。
     */
    public function sortInternal(): void
    {
        $this->leftArray = array_fill(0, (int)(count($this->elements) >> 1), 0);
        $this->sortRange(0, count($this->elements));
    }

    /**
     * 对指定范围内的数组进行归并排序。
     *
     * 排序过程分为以下几个步骤：
     * 1. 如果当前范围小于两个元素，无需排序；
     * 2. 将数组分为左右两部分，分别递归排序；
     * 3. 将排序好的两部分进行归并操作。
     *
     * @param int $begin 排序范围的起始索引（包含）
     * @param int $end   排序范围的结束索引（不包含）
     */
    private function sortRange(int $begin, int $end): void
    {
        if ($end - $begin < 2) {
            return;
        }

        $mid = (int)(($begin + $end) >> 1);
        $this->sortRange($begin, $mid);
        $this->sortRange($mid, $end);
        $this->merge($begin, $mid, $end);
    }

    /**
     * 归并操作，将两个有序子数组合并成一个有序数组。
     *
     * 合并过程分为以下几个步骤：
     * 1. 复制左边的数组到临时数组中；
     * 2. 依次比较左右两个子数组的元素，将较小的元素放入原数组；
     * 3. 当其中一个子数组处理完后，将另一个子数组剩余元素直接复制过去。
     *
     * @param int $begin 排序范围的起始索引（包含）
     * @param int $mid   数组中间位置索引，用于划分两个子数组
     * @param int $end   排序范围的结束索引（不包含）
     */
    private function merge(int $begin, int $mid, int $end): void
    {
        $li = 0;
        $le = $mid - $begin;
        $ri = $mid;
        $re = $end;
        $ai = $begin;

        for ($i = $li; $i < $le; $i++) {
            $this->leftArray[$i] = $this->elements[$begin + $i];
        }

        while ($li < $le) {
            if ($ri < $re && $this->elements[$ri] < $this->leftArray[$li]) {
                $this->elements[$ai++] = $this->elements[$ri++];
            } else {
                $this->elements[$ai++] = $this->leftArray[$li++];
            }
        }
    }
}
