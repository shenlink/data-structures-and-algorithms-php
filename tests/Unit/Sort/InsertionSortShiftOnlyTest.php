<?php

declare(strict_types=1);

namespace Tests\Unit\Sort;

use Shenlink\Algorithms\Sort\InsertionSortShiftOnly;

/**
 * 插入排序优化版本 InsertionSortShiftOnly 的测试类，继承自 SortTest
 */
class InsertionSortShiftOnlyTest extends SortTest
{
    /**
     * 初始化待测试的排序算法实例
     */
    public function setUp(): void
    {
        $this->prepare();
        $this->sort = new InsertionSortShiftOnly();
    }
}
