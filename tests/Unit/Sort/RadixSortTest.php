<?php

declare(strict_types=1);

namespace Tests\Unit\Sort;

use Shenlink\Algorithms\Sort\RadixSort;

/**
 * 基数排序实现类 RadixSort 的测试类，继承自 SortTest
 */
class RadixSortTest extends SortTest
{
    /**
     * 初始化待测试的排序算法实例
     */
    public function setUp(): void
    {
        $this->prepare();
        $this->sort = new RadixSort();
    }
}
