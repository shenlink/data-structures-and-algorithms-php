<?php

declare(strict_types=1);

namespace Tests\Unit\Search;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Search\BinarySearch;

/**
 * 二分查找测试基类 - 定义了通用的二分查找测试框架和验证方法
 */
abstract class BinarySearchTest extends TestCase
{
    /**
     * 当前使用的二分查找算法实现
     */
    protected BinarySearch $binarySearch;

    /**
     * 待查找的数据集合
     * @var array<int>
     */
    protected array $elements;

    /**
     * 查找结果的预期值数组
     * @var array<int>
     */
    protected array $results;

    /**
     * 测试查找功能的正确性
     * 遍历所有目标值进行查找，并验证结果是否符合预期
     */
    public function testSearch(): void
    {
        $list = [];
        for ($i = 0; $i <= count($this->elements); $i++) {
            $list[] = $this->binarySearch->search($this->elements, $i);
        }
        $this->assertSame($this->results, $list);
    }
}
