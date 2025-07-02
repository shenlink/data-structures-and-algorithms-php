<?php

namespace Shenlink\Algorithms\Search;

/**
 * 基础的二分搜索的另外一种实现
 * 该类基于 lowerCeil 二分搜索的思路实现基础的二分搜索
 */
class BinarySearchAnother implements BinarySearch
{
    /**
     * 在指定的有序数组中查找目标元素。
     *
     * @param array<int> $elements 要搜索的有序数组
     * @param int $target   要查找的目标值
     * @return int 如果找到目标则返回其索引位置，否则返回 -1
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
        if ($left < count($elements) && $elements[$left] === $target) {
            return $left;
        }
        return -1;
    }
}
