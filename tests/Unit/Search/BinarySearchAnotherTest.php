<?php

declare(strict_types=1);

namespace Tests\Unit\Search;

use Shenlink\Algorithms\Search\BinarySearchAnother;

/**
 * BinarySearchAnother 测试类
 */
class BinarySearchAnotherTest extends BinarySearchTest
{
    /**
     * 初始化 BinarySearchAnother 实例和测试数据
     */
    protected function setUp(): void
    {
        $this->binarySearch = new BinarySearchAnother();
        $this->elements = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $this->results = [-1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    }
}
