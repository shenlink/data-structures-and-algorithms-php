<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Lists\Deque;

/**
 * 双端队列接口测试类
 * 测试双端队列的基本操作功能
 */
class DequeTest extends TestCase
{
    /**
     * 双端队列实例
     */
    private Deque $deque;

    /**
     * 初始化测试用的通用双端队列
     */
    protected function setUp(): void
    {
        $this->deque = new Deque();
    }

    /**
     * 测试从队尾入队操作
     * 验证元素能否正确添加到队列尾部
     */
    public function testEnQueueRear(): void
    {
        $this->deque->enQueueRear(1);
        $this->assertEquals(1, $this->deque->rear());
        $this->assertEquals(1, $this->deque->front());
    }

    /**
     * 测试从队首出队操作
     * 验证元素能否正确从队列头部移除
     */
    public function testDeQueueFront(): void
    {
        $this->deque->enQueueRear(1);
        $this->deque->enQueueRear(2);
        $this->assertEquals(1, $this->deque->deQueueFront());
        $this->assertEquals(2, $this->deque->front());
    }

    /**
     * 测试从队首入队操作
     * 验证元素能否正确添加到队列头部
     */
    public function testEnQueueFront(): void
    {
        $this->deque->enQueueFront(1);
        $this->deque->enQueueFront(2);
        $this->assertEquals(2, $this->deque->front());
        $this->assertEquals(1, $this->deque->rear());
    }

    /**
     * 测试从队尾出队操作
     * 验证元素能否正确从队列尾部移除
     */
    public function testDeQueueRear(): void
    {
        $this->deque->enQueueRear(1);
        $this->deque->enQueueRear(2);
        $this->assertEquals(2, $this->deque->deQueueRear());
        $this->assertEquals(1, $this->deque->rear());
    }

    /**
     * 测试获取队首元素操作
     * 验证能否正确获取队列头部元素
     */
    public function testFront(): void
    {
        $this->deque->enQueueFront(1);
        $this->assertEquals(1, $this->deque->front());
    }

    /**
     * 测试获取队尾元素操作
     * 验证能否正确获取队列尾部元素
     */
    public function testRear(): void
    {
        $this->deque->enQueueRear(1);
        $this->assertEquals(1, $this->deque->rear());
        $this->deque->enQueueRear(2);
        $this->assertEquals(2, $this->deque->rear());
    }

    /**
     * 测试清空队列操作
     * 验证能否正确清空队列
     */
    public function testClear(): void
    {
        $this->assertTrue($this->deque->isEmpty());
        $this->deque->enQueueRear(1);
        $this->deque->enQueueRear(2);
        $this->deque->clear();
        $this->assertTrue($this->deque->isEmpty());
    }

    /**
     * 测试获取队列大小操作
     * 验证能否正确获取队列大小
     */
    public function testSize(): void
    {
        $this->assertEquals(0, $this->deque->size());
        $this->deque->enQueueRear(1);
        $this->assertEquals(1, $this->deque->size());
        $this->deque->enQueueRear(2);
        $this->assertEquals(2, $this->deque->size());
    }

    /**
     * 测试判断队列是否为空操作
     * 验证能否正确判断队列是否为空
     */
    public function testIsEmpty(): void
    {
        $this->assertTrue($this->deque->isEmpty());
        $this->deque->enQueueRear(1);
        $this->assertFalse($this->deque->isEmpty());
    }
}
