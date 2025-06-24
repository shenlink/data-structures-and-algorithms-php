<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 桶排序实现类
 * 将数组中的元素分发到多个桶中，每个桶分别排序后合并回原数组。
 * 适用于数据分布较均匀的场景，时间复杂度接近 O(n)，空间复杂度较高。
 */
class BucketSort extends Sort
{
    /**
     * 对数组进行桶排序。
     *
     * 排序过程分为以下几个步骤：
     * 1. 确定数组非空；
     * 2. 找出最大值和最小值用于归一化处理；
     * 3. 创建桶并分配元素；
     * 4. 使用插入排序对每个桶进行排序；
     * 5. 合并所有桶的元素回原数组。
     */
    protected function sortInternal(): void
    {
        // 确保数组非空
        if (empty($this->elements)) {
            return;
        }

        // 找出最大值和最小值
        $min = min($this->elements);
        $max = max($this->elements);

        // 计算桶的数量（通常设为数组长度）
        $bucketCount = count($this->elements);
        $buckets = array_fill(0, $bucketCount, []);

        // 计算桶的区间范围（避免除零）
        $range = ($max - $min) > 0 ? ($max - $min) : 1;

        // 将元素分配到对应的桶中
        foreach ($this->elements as $num) {
            $bucketIndex = floor(($num - $min) / $range * ($bucketCount - 1));
            $buckets[$bucketIndex][] = $num;
        }

        // 对每个桶进行插入排序
        $sorted = [];
        foreach ($buckets as $bucket) {
            // 对非空桶排序
            if (!empty($bucket)) {
                // 使用插入排序
                for ($i = 1; $i < count($bucket); $i++) {
                    $key = $bucket[$i];
                    $j = $i - 1;
                    while ($j >= 0 && $bucket[$j] > $key) {
                        $bucket[$j + 1] = $bucket[$j];
                        $j--;
                    }
                    $bucket[$j + 1] = $key;
                }
                // 合并排序后的桶
                $sorted = array_merge($sorted, $bucket);
            }
        }

        // 将排序结果写回原始数组
        $this->elements = $sorted;
    }
}
