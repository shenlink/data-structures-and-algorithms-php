<?php

namespace Shenlink\Algorithms\Search;

/**
 * 基础的二分搜索实现
 * 该类提供了一种基础的实现二分搜索的思路。
 */
class BinarySearchBasic implements BinarySearch
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
        $right = count($elements) - 1;
        while ($left <= $right) {
            $mid = $left + (int) (($right - $left) / 2);
            if ($elements[$mid] === $target) {
                return $mid;
            }
            if ($elements[$mid] < $target) {
                $left = $mid + 1;
            } else {
                $right = $mid - 1;
            }
        }
        return -1;
    }
}
