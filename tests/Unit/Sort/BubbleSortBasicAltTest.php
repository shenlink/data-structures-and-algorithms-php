<?php

declare(strict_types=1);

namespace Tests\Unit\Sort;

use Shenlink\Algorithms\Sort\BubbleSortBasicAlt;

/**
 * 冒泡排序实现类 BubbleSortBasicAlt 的测试类，继承自 SortTest
 */
class BubbleSortBasicAltTest extends SortTest
{
    /**
     * 初始化待测试的排序算法实例
     */
    public function setUp(): void
    {
        $this->prepare();
        $this->sort = new BubbleSortBasicAlt();
    }
}
