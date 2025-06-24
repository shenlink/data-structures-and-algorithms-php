<?php

declare(strict_types=1);

namespace Tests\Unit\Sort;

use Shenlink\Algorithms\Sort\CountingSort;

/**
 * 计数排序实现类 CountingSort 的测试类，继承自 SortTest
 */
class CountingSortTest extends SortTest
{
    /**
     * 初始化待测试的排序算法实例
     */
    public function setUp(): void
    {
        $this->prepare();
        $this->sort = new CountingSort();
    }
}
