<?php

namespace Shenlink\Algorithms\Search;

/**
 * upperFloor 二分搜索实现类
 * 获取小于等于 target 的最大的索引
 */
class BinarySearchUpperFloor implements BinarySearch
{
    /**
     * 在指定的有序数组中查找小于等于 target 的最大的索引
     *
     * @param array<int> $elements 要搜索的有序数组
     * @param int $target   要查找的目标值
     * @return int 返回获取小于等于 target 的最大的索引
     */
    public function search(array $elements, int $target): int
    {
        $left = -1;
        $right = count($elements) - 1;
        while ($left < $right) {
            $mid = $left + (int) (($right - $left + 1) / 2);
            if ($elements[$mid] <= $target) {
                $left = $mid;
            } else {
                $right = $mid - 1;
            }
        }
        return $left;
    }
}
