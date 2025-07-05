<?php

declare(strict_types=1);

namespace Tests\Unit\Tree;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Tree\RedBlackTree;

/**
 * RedBlackTreeTest 类，用于测试 RedBlackTree 的各种功能。
 */
class RedBlackTreeTest extends TestCase
{
    /**
     * 用于测试的红黑树实例。
     */
    private RedBlackTree $tree;

    /**
     * 每个测试方法执行前初始化一个新的红黑树实例。
     */
    protected function setUp(): void
    {
        $this->tree = new RedBlackTree();
    }

    /**
     * 测试红黑树的 add 方法。
     * 验证添加元素后树的大小、高度以及元素的存在性。
     */
    public function testAdd(): void
    {
        $this->assertEquals("size: 0, height: 0\n", $this->tree->toString());
        $this->tree->add(10);
        $this->assertEquals("size: 1, height: 1\n" .
            "1: 10 ", $this->tree->toString());
        $this->tree->add(5);
        $this->tree->add(15);
        $this->assertEquals(3, $this->tree->size());
        $this->assertTrue($this->tree->contains(10));
        $this->assertTrue($this->tree->contains(5));
        $this->assertTrue($this->tree->contains(15));
        $this->assertFalse($this->tree->contains(20));
        $this->tree->clear();
        for ($i = 0; $i < 5; $i++) {
            $this->tree->add($i);
        }
        for ($i = 0; $i < 5; $i++) {
            $this->assertTrue($this->tree->contains($i));
        }
        $this->assertFalse($this->tree->contains(6));
        $this->assertEquals("size: 5, height: 3\n" .
            "1: 1 \n" .
            "2: 0 3 \n" .
            "3: null null 2 4 ", $this->tree->toString());
        $this->tree->clear();
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->assertEquals("size: 7, height: 3\n" .
            "1: 10 \n" .
            "2: 5 15 \n" .
            "3: 3 7 12 18 ", $this->tree->toString());
        $this->tree->clear();
        for ($i = 1; $i < 20; $i++) {
            $this->tree->add($i);
        }
        $this->assertEquals("size: 19, height: 6\n" .
            "1: 8 \n" .
            "2: 4 12 \n" .
            "3: 2 6 10 14 \n" .
            "4: 1 3 5 7 9 11 13 16 \n" .
            "5: null null null null null null null null null null null " .
            "null null null 15 18 \n" .
            "6: null null null null null null null null null null null " .
            "null null null null null null null null null null null null " .
            "null null null null null null null 17 19 ", $this->tree->toString());
    }

    /**
     * 测试红黑树的 remove 方法。
     * 验证删除元素后树的大小、高度以及元素的存在性。
     */
    public function testRemove(): void
    {
        // 删除空树
        $this->tree->remove(10);
        // 删除根节点
        $this->tree->add(10);
        $this->tree->remove(10);
        $this->assertEquals(0, $this->tree->size());
        $this->assertTrue($this->tree->isEmpty());
        $this->assertEquals("size: 0, height: 0\n", $this->tree->toString());

        // 删除重复值
        $this->tree->remove(10);
        // 删除度为0的节点
        $this->tree->clear();
        $data = [10, 5, 15];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->tree->remove(5);
        $this->assertEquals(2, $this->tree->size());
        $this->assertFalse($this->tree->contains(5));
        $this->assertTrue($this->tree->contains(10));
        $this->assertEquals("size: 2, height: 2\n" .
            "1: 10 \n" .
            "2: null 15 ", $this->tree->toString());

        // 删除重复值
        $this->tree->remove(5);
        $this->assertEquals(2, $this->tree->size());
        $this->assertFalse($this->tree->contains(5));
        $this->assertTrue($this->tree->contains(10));
        $this->assertEquals("size: 2, height: 2\n" .
            "1: 10 \n" .
            "2: null 15 ", $this->tree->toString());

        $this->tree->clear();
        $data = [7, 4, 9, 2, 5];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->assertEquals(5, $this->tree->size());
        $this->tree->remove(5);
        $this->assertEquals("size: 4, height: 3\n" .
            "1: 7 \n" .
            "2: 4 9 \n" .
            "3: 2 null null null ", $this->tree->toString());

        // 删除度为1的节点
        $this->tree->clear();
        $data = [10, 5, 15, 3, 16];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->tree->remove(5);
        $this->assertEquals(4, $this->tree->size());
        $this->assertFalse($this->tree->contains(5));
        $this->assertTrue($this->tree->contains(10));
        $this->assertEquals("size: 4, height: 3\n" .
            "1: 10 \n" .
            "2: 3 15 \n" .
            "3: null null null 16 ", $this->tree->toString());
        $this->tree->remove(15);
        $this->assertEquals(3, $this->tree->size());
        $this->assertFalse($this->tree->contains(15));
        $this->assertTrue($this->tree->contains(10));
        $this->assertEquals("size: 3, height: 2\n" .
            "1: 10 \n" .
            "2: 3 16 ", $this->tree->toString());

        // 删除度为2的节点
        $this->tree->clear();
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->tree->remove(5);
        $this->assertEquals(6, $this->tree->size());
        $this->assertFalse($this->tree->contains(5));
        $this->assertTrue($this->tree->contains(7));
        $this->assertEquals("size: 6, height: 3\n" .
            "1: 10 \n" .
            "2: 3 15 \n" .
            "3: null 7 12 18 ", $this->tree->toString());
        $this->tree->remove(15);
        $this->assertEquals(5, $this->tree->size());
        $this->assertFalse($this->tree->contains(15));
        $this->assertTrue($this->tree->contains(10));
        $this->assertEquals("size: 5, height: 3\n" .
            "1: 10 \n" .
            "2: 3 12 \n" .
            "3: null 7 null 18 ", $this->tree->toString());

        // 删除不存在的值
        $this->tree->remove(20);
        $this->assertEquals(5, $this->tree->size());
        $this->assertFalse($this->tree->contains(15));
        $this->assertTrue($this->tree->contains(10));
        $this->assertEquals("size: 5, height: 3\n" .
            "1: 10 \n" .
            "2: 3 12 \n" .
            "3: null 7 null 18 ", $this->tree->toString());

        // 测试添加多个元素
        $this->tree->clear();
        for ($i = 1; $i <= 20; $i++) {
            $this->tree->add($i);
        }
        $this->assertEquals(20, $this->tree->size());
        $this->tree->remove(1);
        $this->assertEquals("size: 19, height: 6\n" .
            "1: 8 \n" .
            "2: 4 12 \n" .
            "3: 2 6 10 16 \n" .
            "4: null 3 5 7 9 11 14 18 \n" .
            "5: null null null null null null null null null null null " .
            "null 13 15 17 19 \n" .
            "6: null null null null null null null null null null null " .
            "null null null null null null null null null null null null " .
            "null null null null null null null null 20 ", $this->tree->toString());
        $this->tree->remove(11);
        $this->assertEquals("size: 18, height: 5\n" .
            "1: 8 \n" .
            "2: 4 16 \n" .
            "3: 2 6 12 18 \n" .
            "4: null 3 5 7 10 14 17 19 \n" .
            "5: null null null null null null null null 9 null 13 15 null" .
            " null null 20 ", $this->tree->toString());
        $this->tree->remove(19);
        $this->assertEquals("size: 17, height: 5\n" .
            "1: 8 \n" .
            "2: 4 16 \n" .
            "3: 2 6 12 18 \n" .
            "4: null 3 5 7 10 14 17 20 \n" .
            "5: null null null null null null null null 9 null 13 15 null" .
            " null null null ", $this->tree->toString());
    }
}
