<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 计数排序实现类
 * 基于元素值范围统计频率进行排序，适用于小范围整型数据集。
 * 时间复杂度 O(n + k)，其中 k 是数据值范围，空间复杂度 O(k)。
 */
class CountingSort extends Sort
{
    /**
     * 对数组进行计数排序。
     *
     * 排序过程分为以下几个步骤：
     * 1. 找出数组中的最小值和最大值以确定值范围；
     * 2. 创建计数数组并统计每个元素出现的次数；
     * 3. 构建前缀和数组以确定每个元素在输出数组中的位置；
     * 4. 从后向前遍历原数组，将元素放置到正确位置以保证稳定性；
     * 5. 将排序结果复制回原数组。
     */
    protected function sortInternal(): void
    {
        $min = $this->elements[0];
        $max = $this->elements[0];

        foreach ($this->elements as $element) {
            if ($element < $min) {
                $min = $element;
            }
            if ($element > $max) {
                $max = $element;
            }
        }

        $counts = array_fill(0, $max - $min + 1, 0);

        foreach ($this->elements as $element) {
            $counts[$element - $min]++;
        }

        for ($i = 1; $i < count($counts); $i++) {
            $counts[$i] += $counts[$i - 1];
        }

        $newArray = [];

        for ($i = count($this->elements) - 1; $i >= 0; $i--) {
            $element = $this->elements[$i];
            $newArray[--$counts[$element - $min]] = $element;
        }

        for ($i = 0; $i < count($newArray); $i++) {
            $this->elements[$i] = $newArray[$i];
        }
    }
}
