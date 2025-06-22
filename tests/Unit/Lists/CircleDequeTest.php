<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Lists\CircleDeque;

/**
 * 双端队列测试类
 * 测试基于循环数组实现的双端队列功能
 */
class CircleDequeTest extends TestCase
{
    /**
     * 循环双端队列实例
     */
    private CircleDeque $deque;

    /**
     * 初始化测试用的循环双端队列
     */
    protected function setUp(): void
    {
        $this->deque = new CircleDeque();
    }

    /**
     * 测试从队尾入队操作
     * 验证元素能否正确添加到队列尾部
     */
    public function testEnQueueRear(): void
    {
        $this->deque->enQueueRear(1);
        $this->assertEquals(1, $this->deque->front());
        $this->assertEquals(1, $this->deque->size());
        $this->deque->enQueueRear(2);
        $this->assertEquals(1, $this->deque->front());
        $this->assertEquals(2, $this->deque->rear());
        $this->assertEquals(2, $this->deque->size());

        $this->deque->clear();
        $this->deque->enQueueRear(1);
        $this->assertEquals(1, $this->deque->front());
        $this->assertEquals(1, $this->deque->size());

        $this->deque->clear();
        for ($i = 0; $i < 10; $i++) {
            $this->deque->enQueueRear($i);
        }
        for ($i = 0; $i < 3; $i++) {
            $this->deque->deQueueFront();
        }
        $this->deque->enQueueRear(10);
        $this->deque->enQueueRear(11);
        $this->assertEquals(
            "size: 9, elements: [3, 4, 5, 6, 7, 8, 9, 10, 11], capacity: 10, origin: [10, 11, null, 3, 4, 5, 6, 7, 8, 9]",
            $this->deque->toString()
        );
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
        $this->assertEquals(1, $this->deque->size());

        $this->assertEquals(2, $this->deque->deQueueFront());
        $this->assertTrue($this->deque->isEmpty());
        $this->assertEquals(0, $this->deque->size());

        $this->deque->enQueueRear(1);
        $this->deque->enQueueRear(2);
        $this->assertEquals(2, $this->deque->rear());
        $this->assertEquals(1, $this->deque->deQueueFront());
        $this->assertEquals(2, $this->deque->front());
        $this->assertEquals(1, $this->deque->size());

        $this->deque->clear();
        for ($i = 0; $i < 10; $i++) {
            $this->deque->enQueueRear($i);
        }
        for ($i = 0; $i < 3; $i++) {
            $this->deque->deQueueFront();
        }
        $this->assertEquals(
            "size: 7, elements: [3, 4, 5, 6, 7, 8, 9], capacity: 10, origin: [null, null, null, 3, 4, 5, 6, 7, 8, 9]",
            $this->deque->toString()
        );
    }

    /**
     * 测试从队首入队操作
     * 验证元素能否正确添加到队列头部
     */
    public function testEnQueueFront(): void
    {
        $this->deque->enQueueFront(1);
        $this->assertEquals(1, $this->deque->front());
        $this->assertEquals(1, $this->deque->size());
        $this->deque->enQueueFront(2);
        $this->assertEquals(2, $this->deque->front());
        $this->assertEquals(1, $this->deque->rear());
        $this->assertEquals(2, $this->deque->size());

        $this->deque->clear();
        $this->deque->enQueueFront(1);
        $this->assertEquals(1, $this->deque->front());
        $this->assertEquals(1, $this->deque->size());

        $this->deque->clear();
        for ($i = 9; $i >= 0; $i--) {
            $this->deque->enQueueFront($i);
        }
        for ($i = 0; $i < 3; $i++) {
            $this->deque->deQueueRear();
        }
        $this->deque->enQueueFront(10);
        $this->deque->enQueueFront(11);
        $this->assertEquals(
            "size: 9, elements: [11, 10, 0, 1, 2, 3, 4, 5, 6], capacity: 10, origin: [0, 1, 2, 3, 4, 5, 6, null, 11, 10]",
            $this->deque->toString()
        );
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
        $this->assertEquals(1, $this->deque->front());
        $this->assertEquals(1, $this->deque->size());
        $this->assertEquals(1, $this->deque->deQueueRear());
        $this->assertTrue($this->deque->isEmpty());
        $this->assertEquals(0, $this->deque->size());

        $this->deque->clear();
        $this->deque->enQueueFront(1);
        $this->deque->enQueueFront(2);
        $this->assertEquals(1, $this->deque->deQueueRear());
        $this->assertEquals(2, $this->deque->front());
        $this->assertEquals(1, $this->deque->size());

        $this->deque->clear();
        for ($i = 0; $i < 10; $i++) {
            $this->deque->enQueueRear($i);
        }
        for ($i = 0; $i < 3; $i++) {
            $this->deque->deQueueRear();
        }
        $this->assertEquals(
            "size: 7, elements: [0, 1, 2, 3, 4, 5, 6], capacity: 10, origin: [0, 1, 2, 3, 4, 5, 6, null, null, null]",
            $this->deque->toString()
        );
    }

    /**
     * 测试获取队首元素操作
     * 验证能否正确获取队列头部元素
     */
    public function testFront(): void
    {
        $this->deque->enQueueRear(1);
        $this->assertEquals(1, $this->deque->front());

        $this->deque->clear();
        $this->deque->enQueueRear(1);
        $this->assertEquals(1, $this->deque->front());

        $this->deque->clear();
        for ($i = 0; $i < 10; $i++) {
            $this->deque->enQueueRear($i);
        }
        for ($i = 0; $i < 3; $i++) {
            $this->deque->deQueueFront();
        }
        $this->assertEquals(3, $this->deque->front());
        $this->assertEquals(
            "size: 7, elements: [3, 4, 5, 6, 7, 8, 9], capacity: 10, origin: [null, null, null, 3, 4, 5, 6, 7, 8, 9]",
            $this->deque->toString()
        );
    }

    /**
     * 测试获取队尾元素操作
     * 验证能否正确获取队列尾部元素
     */
    public function testRear(): void
    {
        $this->deque->enQueueRear(1);
        $this->deque->enQueueRear(2);
        $this->assertEquals(2, $this->deque->rear());

        $this->deque->clear();
        $this->deque->enQueueRear(1);
        $this->assertEquals(1, $this->deque->front());

        $this->deque->clear();
        for ($i = 0; $i < 10; $i++) {
            $this->deque->enQueueRear($i);
        }
        for ($i = 0; $i < 3; $i++) {
            $this->deque->deQueueFront();
        }
        $this->assertEquals(3, $this->deque->front());
        $this->assertEquals(
            "size: 7, elements: [3, 4, 5, 6, 7, 8, 9], capacity: 10, origin: [null, null, null, 3, 4, 5, 6, 7, 8, 9]",
            $this->deque->toString()
        );
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
        $this->assertEquals(0, $this->deque->size());

        $this->deque->clear();
        $this->assertTrue($this->deque->isEmpty());
        $this->deque->enQueueFront(1);
        $this->deque->enQueueFront(2);
        $this->deque->clear();
        $this->assertTrue($this->deque->isEmpty());
        $this->assertEquals(0, $this->deque->size());
        for ($i = 0; $i < 10; $i++) {
            $this->deque->enQueueFront($i);
        }
        $this->deque->deQueueFront();
        $this->deque->deQueueFront();
        $this->deque->clear();
        $this->assertEquals(
            "size: 0, elements: [], capacity: 10, origin: [null, null, null, null, null, null, null, null, null, null]",
            $this->deque->toString()
        );
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
        $this->deque->deQueueFront();
        $this->deque->deQueueFront();
        $this->assertEquals(0, $this->deque->size());
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
        $this->deque->deQueueFront();
        $this->assertTrue($this->deque->isEmpty());
    }

    /**
     * 测试队列扩容操作
     * 验证队列在元素数量超过容量时能否正确扩容
     */
    public function testExpansion(): void
    {
        for ($i = 0; $i < 15; $i++) {
            $this->deque->enQueueRear($i);
        }
        $this->assertEquals(15, $this->deque->size());
        $this->deque->clear();
        for ($i = 0; $i < 20; $i++) {
            $this->deque->enQueueRear($i);
        }
        $this->assertEquals(20, $this->deque->size());
        $this->assertEquals(
            "size: 20, elements: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19], capacity: 22, origin: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, null, null]",
            $this->deque->toString()
        );
    }

    /**
     * 测试队列缩容操作
     * 验证队列在元素数量减少到一定程度时能否正确缩容
     */
    public function testShrinking(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $this->deque->enQueueRear($i);
        }
        $this->assertEquals(20, $this->deque->size());
        for ($i = 0; $i < 10; $i++) {
            $this->deque->deQueueRear();
        }
        $this->assertEquals(10, $this->deque->size());
        $this->assertEquals(
            "size: 10, elements: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9], capacity: 11, origin: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, null]",
            $this->deque->toString()
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
            $this->deque->toString()
        );
        $this->deque->enQueueRear(1);
        $this->assertEquals(
            "size: 1, elements: [1], capacity: 10, origin: [1, null, null, null, null, null, null, null, null, null]",
            $this->deque->toString()
        );
        $this->deque->enQueueRear(2);
        $this->assertEquals(
            "size: 2, elements: [1, 2], capacity: 10, origin: [1, 2, null, null, null, null, null, null, null, null]",
            $this->deque->toString()
        );
        for ($i = 3; $i < 15; $i++) {
            $this->deque->enQueueRear($i);
        }
        $this->assertEquals(
            "size: 14, elements: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14], capacity: 15, origin: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, null]",
            $this->deque->toString()
        );
        $this->deque->deQueueFront();
        $this->assertEquals(
            "size: 13, elements: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14], capacity: 15, origin: [null, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, null]",
            $this->deque->toString()
        );
        $this->deque->deQueueRear();
        $this->assertEquals(
            "size: 12, elements: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13], capacity: 15, origin: [null, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, null, null]",
            $this->deque->toString()
        );
    }
}
