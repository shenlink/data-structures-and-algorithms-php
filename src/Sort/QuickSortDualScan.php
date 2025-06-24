<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 双路快速排序的另外一种思路
 * 基于分治策略进行排序，采用双路快速排序算法，避免极端情况下的性能退化。
 * 时间复杂度平均为 O(n log n)，最差情况下为 O(n^2)，空间复杂度为 O(log n)。
 */
class QuickSortDualScan extends Sort
{
    /**
     * 对数组进行排序，默认从整个数组范围开始排序。
     */
    protected function sortInternal(): void
    {
        $this->quickSort(0, count($this->elements));
    }

    /**
     * 对指定范围内的数组进行快速排序。
     *
     * 排序过程分为以下几个步骤：
     * 1. 如果当前范围小于两个元素，无需排序；
     * 2. 使用 partition 方法将数组划分为两个子数组；
     * 3. 对左右两个子数组分别递归排序。
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
     * 1. 随机选择一个基准元素，并将其交换到起始位置；
     * 2. 定义两个指针 i 和 j，分别从左右两侧向中间扫描；
     * 3. 找到左侧大于等于基准的元素和右侧小于等于基准的元素并交换；
     * 4. 当两指针相遇时停止扫描，将基准元素与右指针指向的元素交换；
     * 5. 返回右指针的位置作为基准位置。
     *
     * @param int $begin 划分范围的起始索引（包含）
     * @param int $end   划分范围的结束索引（不包含）
     * @return int 基准元素最终所在的位置索引
     */
    private function partition(int $begin, int $end): int
    {
        $randomIndex = $begin + random_int(0, $end - $begin - 1);
        $this->swap($begin, $randomIndex);

        $pivot = $this->elements[$begin];
        $end--;

        while ($begin < $end) {
            while ($begin < $end) {
                if ($this->compare($pivot, $this->elements[$end]) < 0) {
                    $end--;
                } else {
                    $this->swap($begin, $end);
                    $begin++;
                    break;
                }
            }
            while ($begin < $end) {
                if ($this->compare($pivot, $this->elements[$begin]) > 0) {
                    $begin++;
                } else {
                    $this->swap($begin, $end);
                    $end--;
                    break;
                }
            }
        }

        $this->elements[$begin] = $pivot;
        return $begin;
    }
}
