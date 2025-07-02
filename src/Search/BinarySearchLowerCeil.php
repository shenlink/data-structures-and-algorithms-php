<?php

namespace Shenlink\Algorithms\Search;

/**
 * lowerCeil 二分搜索实现类
 * 获取大于等于 target 的最小值的索引
 */
class BinarySearchLowerCeil implements BinarySearch
{
    /**
     * 在指定的有序数组中查找大于等于 target 的最小值的索引。
     *
     * @param array<int> $elements 要搜索的有序数组
     * @param int $target   要查找的目标值
     * @return int 返回大于等于 target 的最小值的索引
     */
    public function search(array $elements, int $target): int
    {
        $left = 0;
        $right = count($elements);
        while ($left < $right) {
            $mid = $left + (int) (($right - $left) / 2);
            if ($elements[$mid] < $target) {
                $left = $mid + 1;
            } else {
                $right = $mid;
            }
        }
        return $left;
    }
}
