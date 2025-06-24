<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 快速排序实现类
 * 基于分治策略进行排序，通过选定基准元素将数组划分为两个子数组，分别进行递归排序。
 * 时间复杂度平均为 O(n log n)，最差情况下为 O(n^2)，空间复杂度为 O(log n)。
 */
class QuickSortBasic extends Sort
{
    /**
     * 对数组进行排序，默认从整个数组范围开始排序。
     */
    public function sortInternal(): void
    {
        $this->quickSort(0, count($this->elements));
    }

    /**
     * 对指定范围内的数组进行快速排序。
     *
     * 排序过程分为以下几个步骤：
     * 1. 如果当前范围小于两个元素，无需排序；
     * 2. 随机选择一个基准元素，并将其交换到起始位置；
     * 3. 使用 partition 方法将数组划分为两个子数组；
     * 4. 对左右两个子数组分别递归排序。
     *
     * @param int $begin 排序范围的起始索引（包含）
     * @param int $end   排序范围的结束索引（不包含）
     */
    private function quickSort(int $begin, int $end): void
    {
        if ($end - $begin < 2) {
            return;
        }

        $mid = $this->partition($begin, $end);
        $this->quickSort($begin, $mid);
        $this->quickSort($mid + 1, $end);
    }

    /**
     * 将指定范围内的数组按照基准元素进行划分。
     *
     * 划分过程分为以下几个步骤：
     * 1. 随机化选择基准元素并将其交换到起始位置，防止退化成 O(n^2)；
     * 2. 初始化指针 j 指向起始位置；
     * 3. 遍历数组，如果当前元素小于基准元素，则将其交换到 j 的下一个位置；
     * 4. 最终将基准元素交换到正确位置，并返回其索引。
     *
     * @param int $begin 划分范围的起始索引（包含）
     * @param int $end   划分范围的结束索引（不包含）
     * @return int 基准元素最终所在的位置索引
     */
    private function partition(int $begin, int $end): int
    {
        $randomIndex = $begin + random_int(0, $end - $begin - 1);
        $this->swap($begin, $randomIndex);

        $j = $begin;

        for ($i = $begin + 1; $i < $end; $i++) {
            if ($this->compareByIndex($i, $begin) < 0) {
                $j++;
                $this->swap($i, $j);
            }
        }

        $this->swap($begin, $j);
        return $j;
    }
}
