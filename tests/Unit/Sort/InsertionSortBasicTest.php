<?php

declare(strict_types=1);

namespace Tests\Unit\Sort;

use Shenlink\Algorithms\Sort\InsertionSortBasic;

/**
 * 插入排序基础版本 InsertionSortBasic 的测试类，继承自 SortTest
 */
class InsertionSortBasicTest extends SortTest
{
    /**
     * 初始化待测试的排序算法实例
     */
    public function setUp(): void
    {
        $this->prepare();
        $this->sort = new InsertionSortBasic();
    }
}
