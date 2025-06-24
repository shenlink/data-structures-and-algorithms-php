<?php

declare(strict_types=1);

namespace Tests\Unit\Sort;

use Shenlink\Algorithms\Sort\QuickSort3Way;

/**
 * 快速排序3路排序优化版本 QuickSort3Way 的测试类，继承自 SortTest
 */
class QuickSort3WayTest extends SortTest
{
    /**
     * 排序测试数据规模
     */
    protected int $size = 1000;

    /**
     * 初始化待测试的排序算法实例
     */
    public function setUp(): void
    {
        $this->prepare();
        $this->sort = new QuickSort3Way();
    }
}
