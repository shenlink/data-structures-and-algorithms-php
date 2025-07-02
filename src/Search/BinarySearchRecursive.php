<?php

namespace Shenlink\Algorithms\Search;

/**
 * 基础的二分搜索的递归实现类
 * 该类使用递归方式实现基础的二分搜索算法。
 */
class BinarySearchRecursive implements BinarySearch
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
        return $this->searchRecursive($elements, 0, count($elements) - 1, $target);
    }

    /**
     * 递归方法查找目标元素。
     *
     * @param array<int> $elements 要搜索的有序数组
     * @param int $left      搜索范围左边界
     * @param int $right     搜索范围右边界
     * @param int $target    要查找的目标值
     * @return int 如果找到目标则返回其索引位置，否则返回 -1
     */
    private function searchRecursive(array $elements, int $left, int $right, int $target): int
    {
        if ($left > $right) {
            return -1;
        }
        $mid = $left + (int) (($right - $left) / 2);
        if ($elements[$mid] === $target) {
            return $mid;
        } elseif ($elements[$mid] < $target) {
            return $this->searchRecursive($elements, $mid + 1, $right, $target);
        } else {
            return $this->searchRecursive($elements, $left, $mid - 1, $target);
        }
    }
}
