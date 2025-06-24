<?php

declare(strict_types=1);

namespace Tests\Unit\Sort;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Sort\Sort;

/**
 * 排序算法测试基类 - 定义了通用的排序测试框架和验证方法
 */
abstract class SortTest extends TestCase
{
    /**
     * 当前使用的排序算法实现
     */
    protected Sort $sort;

    /**
     * 测试数组大小，默认为100个元素
     */
    protected int $size = 100;

    /**
     * 待排序的数据集合
     * @var array<int>
     */
    protected array $elements;

    /**
     * 初始化测试数据集
     * 创建指定大小的随机整数数组用于排序测试
     */
    public function prepare(): void
    {
        $n = $this->size;
        $this->elements = array();
        for ($i = 0; $i < $n; $i++) {
            $this->elements[$i] = rand(0, $n);
        }
    }

    /**
     * 测试排序功能的正确性
     * 验证排序后的数组是否按升序排列
     */
    public function testSort(): void
    {
        $this->sort->sort($this->elements);
        $this->assertTrue($this->isSorted());
    }

    /**
     * 辅助方法验证数组是否已排序
     *
     * @return bool 如果数组有序返回 true，否则返回 false
     */
    protected function isSorted(): bool
    {
        for ($i = 0; $i < count($this->elements) - 1; $i++) {
            if ($this->elements[$i] > $this->elements[$i + 1]) {
                return false;
            }
        }
        return true;
    }
}
