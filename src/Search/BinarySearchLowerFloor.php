<?php

namespace Shenlink\Algorithms\Search;

/**
 * lowerFloor 二分搜索实现类
 * 小于 target 时，获取小于 target 的最大值的索引
 * 等于 target 时，获取所有 target 中最小的索引
 */
class BinarySearchLowerFloor implements BinarySearch
{
    /**
     * 小于 target 时，返回小于 target 的最大值的索引
     * 等于 target 时，返回所有 target 中最小的索引
     *
     * @param array<int> $elements 要搜索的有序数组
     * @param int $target   要查找的目标值
     * @return int 小于 target 时，返回小于 target 的最大值的索引，等于 target 时，返回所有 target 中最小的索引
     */
    public function search(array $elements, int $target): int
    {
        $left = $this->lower($elements, $target);
        if ($left + 1 < count($elements) && $elements[$left + 1] === $target) {
            return $left + 1;
        }
        return $left;
    }

    /**
     * 在指定的有序数组中查找小于 target 的最大值的索引。
     *
     * @param array<int> $elements 要搜索的有序数组
     * @param int $target   要查找的目标值
     * @return int 返回小于 target 的最大值的索引
     */
    private function lower(array $elements, int $target): int
    {
        $left = -1;
        $right = count($elements) - 1;
        while ($left < $right) {
            $mid = $left + (int) (($right - $left + 1) / 2);
            if ($elements[$mid] < $target) {
                $left = $mid;
            } else {
                $right = $mid - 1;
            }
        }
        return $left;
    }
}
