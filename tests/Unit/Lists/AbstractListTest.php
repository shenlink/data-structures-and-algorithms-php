<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Lists\IList;

/**
 * 抽象线性表测试类，实现了 ListTest 接口定义的基础测试方法
 */
abstract class AbstractListTest extends TestCase implements ListTest
{
    /**
     * 线性表实例
     */
    protected IList $list;

    /**
     * 测试清空线性表功能
     */
    public function testClear(): void
    {
        $this->list->add(1);
        $this->list->add(2);
        $this->list->add(3);
        $this->list->clear();
        $this->assertEquals(0, $this->list->size());
    }

    /**
     * 测试获取线性表大小功能
     */
    public function testSize(): void
    {
        $this->list->add(0);
        $this->list->add(1);
        $this->list->add(2);
        $this->assertEquals(3, $this->list->size());
        $this->list->clear();
        $this->assertEquals(0, $this->list->size());
    }

    /**
     * 测试判断线性表是否为空的功能
     */
    public function testIsEmpty(): void
    {
        $this->assertTrue($this->list->isEmpty());
        $this->list->add(0);
        $this->assertFalse($this->list->isEmpty());
        $this->list->clear();
        $this->assertTrue($this->list->isEmpty());
    }

    /**
     * 测试判断线性表是否包含指定元素的功能
     */
    public function testContains(): void
    {
        $this->list->add(0);
        $this->assertTrue($this->list->contains(0));
        $this->assertFalse($this->list->contains(1));
        $this->list->remove(0);
        $this->assertFalse($this->list->contains(0));
    }

    /**
     * 测试向线性表尾部添加元素的功能
     */
    public function testAdd(): void
    {
        $this->list->add(1);
        $this->list->add(2);
        $this->list->add(3);
        $this->assertEquals(1, $this->list->get(0));
        $this->assertEquals(2, $this->list->get(1));
        $this->assertEquals(3, $this->list->get(2));
        $this->assertEquals(3, $this->list->size());
    }

    /**
     * 测试向线性表指定添加元素的功能
     */
    public function testAddAt(): void
    {
        $this->expectException(OutOfBoundsException::class);

        $this->list->add(1);
        $this->list->add(2);
        $this->list->add(3);
        $this->assertEquals(1, $this->list->get(0));
        $this->assertEquals(2, $this->list->get(1));
        $this->assertEquals(3, $this->list->get(2));
        $this->assertEquals(3, $this->list->size());
        $this->list->addAt(4, 4);
    }

    /**
     * 测试获取指定索引处元素的功能
     */
    public function testGet(): void
    {
        $this->expectException(OutOfBoundsException::class);

        $this->list->add(0);
        $this->assertEquals(0, $this->list->get(0));
        $this->list->get(1);
    }

    /**
     * 测试替换指定索引处元素的功能
     */
    public function testSet(): void
    {
        $this->expectException(OutOfBoundsException::class);

        $this->list->add(0);
        $this->list->add(1);
        $this->list->add(2);
        $this->list->add(3);
        $this->list->set(1, 2);
        $this->assertEquals(2, $this->list->get(2));
        $this->list->set(4, 4);
    }

    /**
     * 测试在指定索引处插入元素的功能
     */
    public function testAddAtIndex(): void
    {
        $this->expectException(OutOfBoundsException::class);

        $this->list->add(1);
        $this->list->add(2);
        $this->list->add(3);
        $this->list->addAt(0, 1);
        $this->list->addAt(0, 0);
        $this->list->addAt(4, $this->list->size());
        $this->assertEquals(0, $this->list->get(0));
        $this->assertEquals(1, $this->list->get(1));
        $this->assertEquals(2, $this->list->get(3));
        $this->assertEquals(6, $this->list->size());
        $this->list->addAt(7, 5);
    }

    /**
     * 测试删除指定索引处元素的功能
     */
    public function testRemove(): void
    {
        $this->expectException(OutOfBoundsException::class);

        for ($i = 1; $i < 6; $i++) {
            $this->list->add($i);
        }
        $this->assertEquals(1, $this->list->remove(0));
        $this->assertEquals(3, $this->list->remove(1));
        $this->assertEquals(5, $this->list->remove($this->list->size() - 1));
        $this->assertEquals(4, $this->list->get(1));
        $this->list->remove(2);
    }

    /**
     * 测试查找指定元素首次出现位置的功能
     */
    public function testIndexOf(): void
    {
        $this->list->add(1);
        $this->list->add(2);
        $this->list->add(3);
        $this->assertEquals(2, $this->list->indexOf(3));
    }

    /**
     * 测试索引越界异常处理
     */
    public function testCheckIndex(): void
    {
        $this->expectException(OutOfBoundsException::class);

        $this->list->add(0);
        $this->list->get(1);
    }

    /**
     * 测试针对 add 操作的索引越界异常处理
     */
    public function testCheckIndexForAdd(): void
    {
        $this->expectException(OutOfBoundsException::class);

        $this->list->add(0);
        $this->list->addAt(2, 0);
    }
}
