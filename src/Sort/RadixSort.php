<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 基数排序实现类
 * 底层使用的是基数排序，适用于整型数据集
 * 时间复杂度为 O(n * k)，其中 k 是最大数字的位数，空间复杂度为 O(n)
 */
class RadixSort extends Sort
{
    /**
     * 对数组进行基数排序。
     *
     * 排序过程分为以下几个步骤：
     * 1. 找出数组中的最大值以确定排序轮数；
     * 2. 每一轮对个位、十位、百位等依次进行排序；
     * 3. 使用计数排序作为子过程对每一位进行排序处理。
     */
    protected function sortInternal(): void
    {
        if (empty($this->elements)) {
            return;
        }

        $max = max($this->elements);

        for ($divider = 1; $divider <= $max; $divider *= 10) {
            $this->countingSort($divider);
        }
    }

    /**
     * 对指定的位数进行计数排序。
     *
     * @param int $divider 当前排序的位数因子（如 1, 10, 100 等）
     */
    private function countingSort(int $divider): void
    {
        // 由 $min = (int) ($this->elements[0] / $divider % 10);改为$min = (int) ($this->elements[0] % ($divider * 10) / $divider);，避免浮点数运算导致出现警告
        $min = (int) ($this->elements[0] % ($divider * 10) / $divider);
        $max = $min;

        foreach ($this->elements as $element) {
            $digit = (int) (($element % ($divider * 10)) / $divider);
            if ($digit < $min) $min = $digit;
            if ($digit > $max) $max = $digit;
        }

        $counts = array_fill(0, $max - $min + 1, 0);

        foreach ($this->elements as $element) {
            $digit = (int) (($element % ($divider * 10)) / $divider);
            $counts[$digit - $min]++;
        }

        for ($i = 1; $i < count($counts); $i++) {
            $counts[$i] += $counts[$i - 1];
        }

        $newArray = [];

        for ($i = count($this->elements) - 1; $i >= 0; $i--) {
            $digit = (int) (($this->elements[$i] % ($divider * 10)) / $divider);
            $newArray[--$counts[$digit - $min]] = $this->elements[$i];
        }

        $this->elements = $newArray;
    }
}
