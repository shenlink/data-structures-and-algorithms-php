<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Lists\SkipList;

/**
 * 跳跃表测试类
 * 测试跳跃表实现的键值对存储功能
 */
class SkipListTest extends TestCase
{
    /**
     * 测试用的跳跃表实例
     */
    private SkipList $skipList;

    /**
     * 初始化测试用的跳跃表
     */
    protected function setUp(): void
    {
        $this->skipList = new SkipList();
    }

    /**
     * 测试清空跳跃表的方法
     */
    public function testClear(): void
    {
        $this->assertSame(0, $this->skipList->size());
        $this->assertTrue($this->skipList->isEmpty());
        $this->skipList->put(1, "One");
        $this->assertSame(1, $this->skipList->size());
        $this->assertFalse($this->skipList->isEmpty());
        $this->skipList->clear();
        $this->assertSame(0, $this->skipList->size());
        $this->assertTrue($this->skipList->isEmpty());
    }

    /**
     * 测试获取跳跃表大小的方法
     */
    public function testSize(): void
    {
        $this->assertSame(0, $this->skipList->size());
        $this->skipList->put(1, "One");
        $this->assertSame(1, $this->skipList->size());
    }

    /**
     * 测试判断跳跃表是否为空的方法
     */
    public function testIsEmpty(): void
    {
        $this->assertTrue($this->skipList->isEmpty());
        $this->skipList->put(1, "One");
        $this->assertFalse($this->skipList->isEmpty());
    }

    /**
     * 测试获取跳跃表中指定键对应的值的方法
     */
    public function testGet(): void
    {
        $this->skipList->put(1, "One");
        $this->assertSame("One", $this->skipList->get(1));
        $this->assertNull($this->skipList->get(99));
    }

    /**
     * 测试向跳跃表中插入键值对的方法
     */
    public function testPut(): void
    {
        $this->skipList->put(1, "One");
        $this->assertSame("One", $this->skipList->get(1));
        $this->assertSame("One", $this->skipList->put(1, "Updated One"));
    }

    /**
     * 测试从跳跃表中删除指定键对应的键值对的方法
     */
    public function testRemove(): void
    {
        $this->skipList->put(1, "One");
        $this->assertSame("One", $this->skipList->remove(1));
        $this->assertNull($this->skipList->get(1));
        $this->assertNull($this->skipList->remove(99));
    }

    /**
     * 测试跳跃表中存储多个键值对的情况
     */
    public function testMultipleEntries(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            $this->skipList->put($i, "Value$i");
        }
        for ($i = 1; $i <= 100; $i++) {
            $this->assertSame("Value$i", $this->skipList->get($i));
        }
        for ($i = 1; $i <= 100; $i++) {
            $removed = $this->skipList->remove($i);
            $this->assertSame("Value$i", $removed);
            $this->assertNull($this->skipList->get($i));
        }
        $this->assertTrue($this->skipList->isEmpty());
    }
}
