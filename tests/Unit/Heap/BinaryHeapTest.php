<?php

declare(strict_types=1);

namespace Tests\Unit\Heap;

use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Heap\BinaryHeap;
use Shenlink\Algorithms\Utils\Comparator;

/**
 * 二叉堆测试类
 * 测试 BinaryHeap 类的各种功能
 */
class BinaryHeapTest extends TestCase
{
    /**
     * 最大堆实例，用于测试最大堆功能
     */
    private BinaryHeap $maxHeap;

    /**
     * 最小堆实例，用于测试最小堆功能
     */
    private BinaryHeap $minHeap;

    /**
     * 初始化测试用的最大堆和最小堆实例
     */
    protected function setUp(): void
    {
        // 创建一个最大堆
        $this->maxHeap = new BinaryHeap([], new class implements Comparator {
            public function compare($o1, $o2): int
            {
                return $o1 <=> $o2;
            }
        });
        // 创建一个最小堆
        $this->minHeap = new BinaryHeap([], new class implements Comparator {
            public function compare($o1, $o2): int
            {
                return $o2 <=> $o1;
            }
        });
    }

    /**
     * 测试清除堆中所有元素操作
     */
    public function testClear(): void
    {
        $this->assertEquals(0, $this->maxHeap->size());
        $this->assertEquals(0, $this->minHeap->size());

        for ($i = 0; $i < 100; $i++) {
            $this->maxHeap->add($i);
            $this->minHeap->add($i);
        }

        $this->assertEquals(100, $this->maxHeap->size());
        $this->assertEquals(100, $this->minHeap->size());

        $this->maxHeap->clear();
        $this->minHeap->clear();

        $this->assertEquals(0, $this->maxHeap->size());
        $this->assertEquals(0, $this->minHeap->size());
    }

    /**
     * 测试获取堆中元素数量操作
     */
    public function testSize(): void
    {
        $this->assertEquals(0, $this->maxHeap->size());
        $this->assertEquals(0, $this->minHeap->size());

        for ($i = 0; $i < 100; $i++) {
            $this->maxHeap->add($i);
            $this->minHeap->add($i);
        }

        $this->assertEquals(100, $this->maxHeap->size());
        $this->assertEquals(100, $this->minHeap->size());
    }

    /**
     * 测试判断堆是否为空操作
     */
    public function testIsEmpty(): void
    {
        $this->assertTrue($this->maxHeap->isEmpty());
        $this->assertTrue($this->minHeap->isEmpty());

        for ($i = 0; $i < 100; $i++) {
            $this->maxHeap->add($i);
            $this->minHeap->add($i);
        }

        $this->assertFalse($this->maxHeap->isEmpty());
        $this->assertFalse($this->minHeap->isEmpty());

        $this->maxHeap->clear();
        $this->minHeap->clear();

        $this->assertTrue($this->maxHeap->isEmpty());
        $this->assertTrue($this->minHeap->isEmpty());
    }

    /**
     * 测试向堆中添加元素操作
     */
    public function testAdd(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $this->maxHeap->add($i);
            $this->minHeap->add($i);
        }

        $this->assertEquals(100, $this->maxHeap->size());
        $this->assertEquals(100, $this->minHeap->size());
        $this->assertEquals(99, $this->maxHeap->get());
        $this->assertEquals(0, $this->minHeap->get());
    }

    /**
     * 测试获取堆顶元素但不移除它
     */
    public function testGet(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $this->maxHeap->add($i);
            $this->minHeap->add($i);
        }

        $this->assertEquals(99, $this->maxHeap->get());
        $this->assertEquals(0, $this->minHeap->get());
    }

    /**
     * 测试移除并返回堆顶元素操作
     */
    public function testRemove(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $this->maxHeap->add($i);
            $this->minHeap->add($i);
        }

        $this->assertEquals(100, $this->maxHeap->size());
        $this->assertEquals(100, $this->minHeap->size());

        for ($i = 99; $i >= 0; $i--) {
            $this->assertEquals($i, $this->maxHeap->remove());
        }

        for ($i = 0; $i < 100; $i++) {
            $this->assertEquals($i, $this->minHeap->remove());
        }

        $this->assertEquals(0, $this->maxHeap->size());
        $this->assertEquals(0, $this->minHeap->size());
    }

    /**
     * 测试替换堆顶元素并返回旧元素操作
     */
    public function testReplace(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $this->maxHeap->add($i);
            $this->minHeap->add($i);
        }

        $this->assertEquals(99, $this->maxHeap->replace(100));
        $this->assertEquals(0, $this->minHeap->replace(-1));

        $this->assertEquals(100, $this->maxHeap->get());
        $this->assertEquals(-1, $this->minHeap->get());
    }

    /**
     * 测试使用元素数组批量构建堆的操作
     */
    public function testHeapify(): void
    {
        $elements = [];
        for ($i = 0; $i < 100; $i++) {
            $elements[$i] = $i;
        }

        $this->maxHeap = new BinaryHeap($elements, new class implements Comparator {
            public function compare($o1, $o2): int
            {
                return $o1 <=> $o2;
            }
        });
        $this->minHeap = new BinaryHeap($elements, new class implements Comparator {
            public function compare($o1, $o2): int
            {
                return $o2 <=> $o1;
            }
        });

        $this->assertEquals(100, $this->maxHeap->size());
        $this->assertEquals(100, $this->minHeap->size());

        for ($i = 99; $i >= 0; $i--) {
            $this->assertEquals($i, $this->maxHeap->remove());
        }

        for ($i = 0; $i < 100; $i++) {
            $this->assertEquals($i, $this->minHeap->remove());
        }

        $this->assertEquals(0, $this->maxHeap->size());
        $this->assertEquals(0, $this->minHeap->size());
    }

    /**
     * 测试从空堆中获取堆顶元素时的异常处理
     */
    public function testGetFromEmptyHeap(): void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage("Heap is empty");

        $this->minHeap->get();
    }

    /**
     * 测试从空堆中移除堆顶元素时的异常处理
     */
    public function testRemoveFromEmptyHeap(): void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage("Heap is empty");

        $this->minHeap->remove();
    }
}
