<?php

declare(strict_types=1);

namespace Tests\Unit\Tree;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Tree\AVLTree;

/**
 * AVL 树测试类
 * 测试 AVLTree 的基本功能，包括添加、删除等操作，并验证其平衡性与结构正确性
 */
class AVLTest extends TestCase
{
    /**
     * 被测试的 AVL 树实例，用于执行各种添加和删除操作
     */
    private AVLTree $tree;

    /**
     * 初始化一个新的 AVL 树实例
     */
    protected function setUp(): void
    {
        $this->tree = new AVLTree();
    }

    /**
     * 测试添加元素到 AVL 树并验证结构与大小
     * 验证以下情况：
     * - 添加单个元素后树的结构
     * - 添加多个元素后的结构与包含关系
     * - 添加重复元素后的行为
     */
    public function testAdd(): void
    {
        $this->assertEquals("size: 0, height: 0\n", $this->tree->toString());
        $this->tree->add(10);
        $this->assertEquals("size: 1, height: 1\n1: 10 ", $this->tree->toString());
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
        $this->assertEquals(
            "size: 5, height: 3\n" .
                "1: 1 \n" .
                "2: 0 3 \n" .
                "3: null null 2 4 ",
            $this->tree->toString()
        );
        $this->tree->clear();
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->assertEquals(
            "size: 7, height: 3\n" .
                "1: 10 \n" .
                "2: 5 15 \n" .
                "3: 3 7 12 18 ",
            $this->tree->toString()
        );
        $this->tree->clear();
        for ($i = 1; $i < 20; $i++) {
            $this->tree->add($i);
        }
        $this->assertEquals(
            "size: 19, height: 5\n" .
                "1: 8 \n" .
                "2: 4 12 \n" .
                "3: 2 6 10 16 \n" .
                "4: 1 3 5 7 9 11 14 18 \n" .
                "5: null null null null null null null null null null null " .
                "null 13 15 17 19 ",
            $this->tree->toString()
        );
    }

    /**
     * 测试从 AVL 树中删除元素并验证结构与大小
     * 验证以下情况：
     * - 删除空树中的元素（无影响）
     * - 删除根节点
     * - 删除叶子节点、度为1的节点、度为2的节点
     * - 删除不存在的值（无影响）
     * - 删除后树是否保持平衡
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
        $this->assertEquals(
            "size: 2, height: 2\n" .
                "1: 10 \n" .
                "2: null 15 ",
            $this->tree->toString()
        );

        // 删除重复值
        $this->tree->remove(5);
        $this->assertEquals(2, $this->tree->size());
        $this->assertFalse($this->tree->contains(5));
        $this->assertTrue($this->tree->contains(10));
        $this->assertEquals(
            "size: 2, height: 2\n" .
                "1: 10 \n" .
                "2: null 15 ",
            $this->tree->toString()
        );

        $this->tree->clear();
        $data = [7, 4, 9, 2, 5];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->assertEquals(5, $this->tree->size());
        $this->tree->remove(5);
        $this->assertEquals(
            "size: 4, height: 3\n" .
                "1: 7 \n" .
                "2: 4 9 \n" .
                "3: 2 null null null ",
            $this->tree->toString()
        );

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
        $this->assertEquals(
            "size: 4, height: 3\n" .
                "1: 10 \n" .
                "2: 3 15 \n" .
                "3: null null null 16 ",
            $this->tree->toString()
        );
        $this->tree->remove(15);
        $this->assertEquals(3, $this->tree->size());
        $this->assertFalse($this->tree->contains(15));
        $this->assertTrue($this->tree->contains(10));
        $this->assertEquals(
            "size: 3, height: 2\n" .
                "1: 10 \n" .
                "2: 3 16 ",
            $this->tree->toString()
        );

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
        $this->assertEquals(
            "size: 6, height: 3\n" .
                "1: 10 \n" .
                "2: 3 15 \n" .
                "3: null 7 12 18 ",
            $this->tree->toString()
        );
        $this->tree->remove(15);
        $this->assertEquals(5, $this->tree->size());
        $this->assertFalse($this->tree->contains(15));
        $this->assertTrue($this->tree->contains(10));
        $this->assertEquals(
            "size: 5, height: 3\n" .
                "1: 10 \n" .
                "2: 3 12 \n" .
                "3: null 7 null 18 ",
            $this->tree->toString()
        );

        // 删除不存在的值
        $this->tree->remove(20);
        $this->assertEquals(5, $this->tree->size());
        $this->assertFalse($this->tree->contains(15));
        $this->assertTrue($this->tree->contains(10));
        $this->assertEquals(
            "size: 5, height: 3\n" .
                "1: 10 \n" .
                "2: 3 12 \n" .
                "3: null 7 null 18 ",
            $this->tree->toString()
        );

        // 测试添加多个元素
        $this->tree->clear();
        for ($i = 1; $i < 20; $i++) {
            $this->tree->add($i);
        }
        $this->assertEquals(19, $this->tree->size());
        $this->assertEquals(
            "size: 19, height: 5\n" .
                "1: 8 \n" .
                "2: 4 12 \n" .
                "3: 2 6 10 16 \n" .
                "4: 1 3 5 7 9 11 14 18 \n" .
                "5: null null null null null null null null null null null " .
                "null 13 15 17 19 ",
            $this->tree->toString()
        );
        $this->tree->remove(1);
        $this->assertEquals(
            "size: 18, height: 5\n" .
                "1: 8 \n" .
                "2: 4 12 \n" .
                "3: 2 6 10 16 \n" .
                "4: null 3 5 7 9 11 14 18 \n" .
                "5: null null null null null null null null null null " .
                "null null 13 15 17 19 ",
            $this->tree->toString()
        );
        $this->tree->remove(11);
        $this->assertEquals(
            "size: 17, height: 5\n" .
                "1: 8 \n" .
                "2: 4 12 \n" .
                "3: 2 6 10 16 \n" .
                "4: null 3 5 7 9 null 14 18 \n" .
                "5: null null null null null null null null null null null " .
                "null 13 15 17 19 ",
            $this->tree->toString()
        );
        $this->tree->remove(19);
        $this->assertEquals(
            "size: 16, height: 5\n" .
                "1: 8 \n" .
                "2: 4 12 \n" .
                "3: 2 6 10 16 \n" .
                "4: null 3 5 7 9 null 14 18 \n" .
                "5: null null null null null null null null null null " .
                "null null 13 15 17 null ",
            $this->tree->toString()
        );
    }
}
