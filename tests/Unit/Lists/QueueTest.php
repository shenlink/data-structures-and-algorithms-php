<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Lists\Queue;

/**
 * 队列接口测试类
 * 测试队列(Queue)实现的基本功能
 */
class QueueTest extends TestCase
{
    /**
     * 队列实例
     */
    private Queue $queue;

    /**
     * 初始化测试用的通用队列
     */
    protected function setUp(): void
    {
        $this->queue = new Queue();
    }

    /**
     * 测试入队操作
     * 验证元素能否正确添加到队列尾部
     */
    public function testEnQueue(): void
    {
        $this->queue->enQueue(1);
        $this->assertEquals(1, $this->queue->size());
        $this->assertEquals(1, $this->queue->front());
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
        $this->assertEquals(1, $this->queue->size());
        $this->assertEquals(2, $this->queue->front());
    }

    /**
     * 测试获取队头元素操作
     * 验证能否正确获取队列头部元素
     */
    public function testFront(): void
    {
        $this->queue->enQueue(1);
        $this->assertEquals(1, $this->queue->front());
    }

    /**
     * 测试获取队头元素操作在空队列上的行为
     * 验证能否正确抛出异常
     */
    public function testFrontOnEmptyQueue(): void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->queue->front();
    }

    /**
     * 测试清空队列操作
     * 验证队列能否正确清空
     */
    public function testClear(): void
    {
        $this->queue->enQueue(1);
        $this->queue->enQueue(2);
        $this->queue->clear();
        $this->assertTrue($this->queue->isEmpty());
        $this->assertEquals(0, $this->queue->size());
    }

    /**
     * 测试获取队列大小操作
     * 验证队列大小能否正确返回
     */
    public function testSize(): void
    {
        $this->assertEquals(0, $this->queue->size());
        $this->queue->enQueue(1);
        $this->assertEquals(1, $this->queue->size());
        $this->queue->enQueue(2);
        $this->assertEquals(2, $this->queue->size());
        $this->queue->deQueue();
        $this->assertEquals(1, $this->queue->size());
    }

    /**
     * 测试判断队列是否为空操作
     * 验证队列是否为空判断是否正确
     */
    public function testIsEmpty(): void
    {
        $this->assertTrue($this->queue->isEmpty());
        $this->queue->enQueue(1);
        $this->assertFalse($this->queue->isEmpty());
        $this->queue->deQueue();
        $this->assertTrue($this->queue->isEmpty());
    }
}
