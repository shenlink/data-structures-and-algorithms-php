<?php

declare(strict_types=1);

namespace Tests\Unit\Sort;

use Shenlink\Algorithms\Sort\InsertionSortBinarySearch;

/**
 * 插入排序双指针优化版本 InsertionSortBinarySearch 的测试类，继承自 SortTest
 */
class InsertionSortBinarySearchTest extends SortTest
{
    /**
     * 初始化待测试的排序算法实例
     */
    public function setUp(): void
    {
        $this->prepare();
        $this->sort = new InsertionSortBinarySearch();
    }
}
