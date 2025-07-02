<?php

namespace Shenlink\Algorithms\Search;

/**
 * upperCeil 二分搜索实现类
 * 大于 target 时，获取最小值的索引
 * 等于 target 时，获取所有 target 中最大的索引
 */
class BinarySearchUpperCeil implements BinarySearch
{
    /**
     * 大于 target 时，获取最小值的索引
     * 等于 target 时，获取所有 target 中最大的索引
     *
     * @param array<int> $elements 要搜索的有序数组
     * @param int $target   要查找的目标值
     * @return int 大于 target 时，返回最小值的索引，等于 target 时，返回所有 target 中最大的索引
     */
    public function search(array $elements, int $target): int
    {
        $upperIndex = $this->upper($elements, $target);
        if ($upperIndex - 1 >= 0 && $elements[$upperIndex - 1] === $target) {
            return $upperIndex - 1;
        }
        return $upperIndex;
    }

    /**
     * 在指定的有序数组中查找大于 target 的最小值的索引。
     *
     * @param array<int> $elements 要搜索的有序数组
     * @param int $target   要查找的目标值
     * @return int 返回大于 target 的最小值的索引
     */
    private function upper(array $elements, int $target): int
    {
        $left = 0;
        $right = count($elements);
        while ($left < $right) {
            $mid = $left + (int) (($right - $left) / 2);
            if ($elements[$mid] <= $target) {
                $left = $mid + 1;
            } else {
                $right = $mid;
            }
        }
        return $left;
    }
}
