<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Lists\PriorityQueue;
use Shenlink\Algorithms\Utils\Comparator;

/**
 * 优先队列测试类
 * 测试基于堆实现的优先队列功能
 */
class PriorityQueueTest extends TestCase
{
    /**
     * 优先队列实例
     */
    private PriorityQueue $queue;

    /**
     * 初始化测试用的优先队列
     */
    protected function setUp(): void
    {
        // 使用默认的自然顺序比较器
        $this->queue = new PriorityQueue(new class implements Comparator {
            public function compare($o1, $o2): int
            {
                return $o1 <=> $o2;
            }
        });
    }

    /**
     * 测试获取队列大小的方法
     */
    public function testSize(): void
    {
        // 初始状态下队列为空，大小为0
        $this->assertSame(0, $this->queue->size());

        // 添加一个元素后，队列大小变为1
        $this->queue->enQueue(10);
        $this->assertSame(1, $this->queue->size());

        // 再添加一个元素，队列大小变为2
        $this->queue->enQueue(20);
        $this->assertSame(2, $this->queue->size());

        // 移除一个元素后，队列大小减为1
        $this->queue->deQueue();
        $this->assertSame(1, $this->queue->size());
    }

    /**
     * 测试检查队列是否为空的方法
     */
    public function testIsEmpty(): void
    {
        // 初始状态下队列为空
        $this->assertTrue($this->queue->isEmpty());

        // 添加一个元素后，队列不再为空
        $this->queue->enQueue(10);
        $this->assertFalse($this->queue->isEmpty());

        // 移除一个元素后，队列重新变为空
        $this->queue->deQueue();
        $this->assertTrue($this->queue->isEmpty());
    }

    /**
     * 测试清空队列的方法
     */
    public function testClear(): void
    {
        // 初始状态下队列为空，大小为0
        $this->assertSame(0, $this->queue->size());
        $this->assertTrue($this->queue->isEmpty());

        // 添加几个元素后
        $this->queue->enQueue(10);
        $this->queue->enQueue(20);
        $this->queue->enQueue(5);

        // 清空队列
        $this->queue->clear();

        // 清空后队列大小为0且为空
        $this->assertSame(0, $this->queue->size());
        $this->assertTrue($this->queue->isEmpty());
    }

    /**
     * 测试向队列中插入元素的方法
     */
    public function testEnQueue(): void
    {
        // 依次插入100个元素
        for ($i = 0; $i < 100; $i++) {
            $this->queue->enQueue($i);
        }
        // 验证队列大小是否为100
        $this->assertSame(100, $this->queue->size());

        // 依次移除元素并验证移除的顺序是否符合优先级
        for ($i = 99; $i >= 0; $i--) {
            $this->assertSame($i, $this->queue->deQueue());
        }
    }

    /**
     * 测试从队列中移除元素的方法
     */
    public function testDeQueue(): void
    {
        // 依次插入100个元素
        for ($i = 0; $i < 100; $i++) {
            $this->queue->enQueue($i);
        }
        // 验证队列大小是否为100
        $this->assertSame(100, $this->queue->size());

        // 依次移除元素并验证移除的顺序是否符合优先级
        for ($i = 99; $i >= 0; $i--) {
            $this->assertSame($i, $this->queue->deQueue());
        }

        // 验证队列是否已为空
        $this->assertSame(0, $this->queue->size());
        $this->assertTrue($this->queue->isEmpty());
    }

    /**
     * 测试获取队列首部元素的方法
     */
    public function testFront(): void
    {
        // 依次插入100个元素
        for ($i = 0; $i < 100; $i++) {
            $this->queue->enQueue($i);
        }

        // 验证队列首部元素是否为优先级最高的元素
        $this->assertSame(99, $this->queue->front());
    }
}
