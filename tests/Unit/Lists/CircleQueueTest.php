<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Lists\CircleQueue;

/**
 * 循环队列测试类
 * 测试基于循环数组实现的队列功能
 */
class CircleQueueTest extends TestCase
{
    /**
     * 循环队列实例
     */
    private CircleQueue $queue;

    /**
     * 初始化测试用的循环队列
     */
    protected function setUp(): void
    {
        $this->queue = new CircleQueue();
    }

    /**
     * 测试入队操作
     * 验证元素能否正确添加到队列尾部
     */
    public function testEnQueue(): void
    {
        $this->queue->enQueue(1);
        $this->assertEquals(1, $this->queue->front());
        $this->assertEquals(1, $this->queue->size());
        $this->queue->clear();
        for ($i = 0; $i < 10; $i++) {
            $this->queue->enQueue($i);
        }
        for ($i = 0; $i < 3; $i++) {
            $this->queue->deQueue();
        }
        $this->queue->enQueue(10);
        $this->queue->enQueue(11);
        $this->assertEquals(
            "size: 9, elements: [3, 4, 5, 6, 7, 8, 9, 10, 11], capacity: 10, origin: [10, 11, null, 3, 4, 5, 6, 7, 8, 9]",
            $this->queue->toString()
        );
    }

    /**
     * 测试出队操作
     * 验证元素能否正确从队列头部移除
     */
    public function testDeQueue(): void
    {
        $this->queue->enQueue(1);
        $this->queue->enQueue(2);
        $this->assertEquals(1, $this->queue->deQueue());
        $this->assertEquals(2, $this->queue->front());
        $this->assertEquals(1, $this->queue->size());
        $this->queue->clear();
        for ($i = 0; $i < 10; $i++) {
            $this->queue->enQueue($i);
        }
        for ($i = 0; $i < 3; $i++) {
            $this->queue->deQueue();
        }
        $this->assertEquals(
            "size: 7, elements: [3, 4, 5, 6, 7, 8, 9], capacity: 10, origin: [null, null, null, 3, 4, 5, 6, 7, 8, 9]",
            $this->queue->toString()
        );
    }

    /**
     * 测试获取队头元素操作
     * 验证能否正确获取队列头部元素
     */
    public function testFront(): void
    {
        $this->queue->enQueue(1);
        $this->assertEquals(1, $this->queue->front());
        $this->queue->clear();
        for ($i = 0; $i < 10; $i++) {
            $this->queue->enQueue($i);
        }
        for ($i = 0; $i < 3; $i++) {
            $this->queue->deQueue();
        }
        $this->assertEquals(3, $this->queue->front());
        $this->assertEquals(
            "size: 7, elements: [3, 4, 5, 6, 7, 8, 9], capacity: 10, origin: [null, null, null, 3, 4, 5, 6, 7, 8, 9]",
            $this->queue->toString()
        );
    }

    /**
     * 测试清空队列操作
     * 验证队列能否被正确清空
     */
    public function testClear(): void
    {
        $this->assertTrue($this->queue->isEmpty());
        $this->queue->enQueue(1);
        $this->queue->enQueue(2);
        $this->queue->clear();
        $this->assertTrue($this->queue->isEmpty());
        $this->assertEquals(0, $this->queue->size());
        for ($i = 0; $i < 10; $i++) {
            $this->queue->enQueue($i);
        }
        $this->queue->deQueue();
        $this->queue->deQueue();
        $this->queue->clear();
        $this->assertEquals(
            "size: 0, elements: [], capacity: 10, origin: [null, null, null, null, null, null, null, null, null, null]",
            $this->queue->toString()
        );
    }

    /**
     * 测试获取队列大小操作
     * 验证能否正确获取队列中元素的数量
     */
    public function testSize(): void
    {
        $this->assertEquals(0, $this->queue->size());
        $this->queue->enQueue(1);
        $this->assertEquals(1, $this->queue->size());
        $this->queue->enQueue(2);
        $this->assertEquals(2, $this->queue->size());
        $this->queue->deQueue();
        $this->queue->deQueue();
        $this->assertEquals(0, $this->queue->size());
    }

    /**
     * 测试判断队列是否为空操作
     * 验证能否正确判断队列是否为空
     */
    public function testIsEmpty(): void
    {
        $this->assertTrue($this->queue->isEmpty());
        $this->queue->enQueue(1);
        $this->assertFalse($this->queue->isEmpty());
        $this->queue->deQueue();
        $this->assertTrue($this->queue->isEmpty());
    }

    /**
     * 测试队列扩容操作
     * 验证队列在元素数量超过容量时能否正确扩容
     */
    public function testExpansion(): void
    {
        for ($i = 0; $i < 15; $i++) {
            $this->queue->enQueue($i);
        }
        $this->assertEquals(15, $this->queue->size());
        $this->queue->clear();
        for ($i = 0; $i < 20; $i++) {
            $this->queue->enQueue($i);
        }
        $this->assertEquals(20, $this->queue->size());
        $this->assertEquals(
            "size: 20, elements: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19], capacity: 22, origin: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, null, null]",
            $this->queue->toString()
        );
    }

    /**
     * 测试队列缩容操作
     * 验证队列在元素数量减少到一定比例时能否正确缩容
     */
    public function testShrinking(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $this->queue->enQueue($i);
        }
        $this->assertEquals(20, $this->queue->size());
        for ($i = 0; $i < 10; $i++) {
            $this->queue->deQueue();
        }
        $this->assertEquals(10, $this->queue->size());
        $this->assertEquals(
            "size: 10, elements: [10, 11, 12, 13, 14, 15, 16, 17, 18, 19], capacity: 11, origin: [null, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]",
            $this->queue->toString()
        );
    }

    /**
     * 测试队列字符串表示操作
     * 验证能否正确获取队列的字符串表示
     */
    public function testToString(): void
    {
        $this->assertEquals(
            "size: 0, elements: [], capacity: 10, origin: [null, null, null, null, null, null, null, null, null, null]",
            $this->queue->toString()
        );
        $this->queue->enQueue(1);
        $this->assertEquals(
            "size: 1, elements: [1], capacity: 10, origin: [1, null, null, null, null, null, null, null, null, null]",
            $this->queue->toString()
        );
        $this->queue->enQueue(2);
        $this->assertEquals(
            "size: 2, elements: [1, 2], capacity: 10, origin: [1, 2, null, null, null, null, null, null, null, null]",
            $this->queue->toString()
        );
        for ($i = 3; $i < 15; $i++) {
            $this->queue->enQueue($i);
        }
        $this->assertEquals(
            "size: 14, elements: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14], capacity: 15, origin: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, null]",
            $this->queue->toString()
        );
        $this->queue->deQueue();
        $this->assertEquals(
            "size: 13, elements: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14], capacity: 15, origin: [null, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, null]",
            $this->queue->toString()
        );
    }
}
