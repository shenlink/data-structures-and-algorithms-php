<?php

declare(strict_types=1);

namespace Tests\Unit\Sort;

use Shenlink\Algorithms\Sort\BubbleSortLastSwap;

/**
 * 冒泡排序改进版本 BubbleSortLastSwap 的测试类，继承自 SortTest
 */
class BubbleSortLastSwapTest extends SortTest
{
    /**
     * 初始化待测试的排序算法实例
     */
    public function setUp(): void
    {
        $this->prepare();
        $this->sort = new BubbleSortLastSwap();
    }
}
