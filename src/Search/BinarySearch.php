<?php

namespace Shenlink\Algorithms\Search;

/**
 * 定义搜索算法的公共接口，用于在数据集合中查找目标元素。
 * 该接口为不同的搜索算法实现提供了统一的 API 规范。
 */
interface BinarySearch
{
    /**
     * 在指定的数组中查找目标元素。
     *
     * @param array<int> $elements 要搜索的数组，必须是有序的（具体依赖实现）
     * @param int $target   要查找的目标值
     * @return int 如果找到目标则返回其索引位置，否则返回 -1
     */
    public function search(array $elements, int $target): int;
}