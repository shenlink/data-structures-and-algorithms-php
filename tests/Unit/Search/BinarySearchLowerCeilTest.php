<?php

declare(strict_types=1);

namespace Tests\Unit\Search;

use Shenlink\Algorithms\Search\BinarySearchLowerCeil;

/**
 * BinarySearchLowerCeil 测试类
 */
class BinarySearchLowerCeilTest extends BinarySearchTest
{
    /**
     * 初始化 BinarySearchLowerCeil 实例和测试数据
     */
    protected function setUp(): void
    {
        $this->binarySearch = new BinarySearchLowerCeil();
        $this->elements = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $this->results = [0, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    }
}
