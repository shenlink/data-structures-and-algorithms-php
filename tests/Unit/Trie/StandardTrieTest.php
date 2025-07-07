<?php

declare(strict_types=1);

namespace Tests\Unit\Trie;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Trie\StandardTrie;

/**
 * Trie 前缀树单元测试类
 * 用于验证 Trie 结构的基本功能是否正确实现，包括添加、获取、删除、前缀匹配等操作。
 */
class StandardTrieTest extends TestCase
{
    /**
     * Trie 树实例，用于存储字符串键值对
     */
    private ?StandardTrie $trie = null;

    /**
     * 每个测试用例执行前初始化一个新的 Trie 实例
     */
    protected function setUp(): void
    {
        $this->trie = new StandardTrie();
    }

    /**
     * 测试 Trie 的添加方法
     * 验证添加元素后，Trie 树的大小是否正确以及是否包含指定键
     */
    public function testAdd(): void
    {
        $this->trie->add("hello", "world");
        $this->assertEquals(1, $this->trie->size());
        $this->assertTrue($this->trie->contains("hello"));
    }

    /**
     * 测试 Trie 的获取方法
     * 验证通过键可以正确获取对应的值，并验证不存在的键返回 null
     */
    public function testGet(): void
    {
        $this->trie->add("hello", "world");
        $this->assertEquals("world", $this->trie->get("hello"));
        $this->assertNull($this->trie->get("hi"));
    }

    /**
     * 测试 Trie 的 contains 方法
     * 验证添加元素后是否能够正确识别存在或不存在的键
     */
    public function testContains(): void
    {
        $this->trie->add("hello", "world");
        $this->assertTrue($this->trie->contains("hello"));
        $this->assertFalse($this->trie->contains("hi"));
    }

    /**
     * 测试 Trie 的 remove 方法
     * 验证删除键后，该键不再存在于 Trie 中且大小更新正确
     */
    public function testRemove(): void
    {
        $this->trie->add("hello", "world");
        $this->assertEquals("world", $this->trie->remove("hello"));
        $this->assertFalse($this->trie->contains("hello"));
        $this->assertEquals(0, $this->trie->size());
    }

    /**
     * 测试 Trie 的 startsWith 方法
     * 验证给定前缀是否能够正确判断是否存在匹配的路径
     */
    public function testStartsWith(): void
    {
        $this->trie->add("hello", "world");
        $this->assertTrue($this->trie->startsWith("hel"));
        $this->assertTrue($this->trie->startsWith("hello"));
        $this->assertFalse($this->trie->startsWith("heo"));
    }

    /**
     * 测试 Trie 的 clear 方法
     * 验证清空 Trie 后所有数据是否被正确移除
     */
    public function testClear(): void
    {
        $this->assertEquals(0, $this->trie->size());
        $this->trie->add("hello", "world");
        $this->assertEquals(1, $this->trie->size());
        $this->trie->clear();
        $this->assertEquals(0, $this->trie->size());
        $this->assertFalse($this->trie->contains("hello"));
    }

    /**
     * 测试 Trie 的 size 方法
     * 验证 Trie 中存储的键值对数量是否准确
     */
    public function testSize(): void
    {
        $this->assertEquals(0, $this->trie->size());
        $this->trie->add("hello", "world");
        $this->assertEquals(1, $this->trie->size());
        $this->trie->add("hi", "o");
        $this->assertEquals(2, $this->trie->size());
    }

    /**
     * 测试 Trie 的 isEmpty 方法
     * 验证 Trie 是否为空的判断逻辑是否正确
     */
    public function testIsEmpty(): void
    {
        $this->assertTrue($this->trie->isEmpty());
        $this->trie->add("hello", "world");
        $this->assertFalse($this->trie->isEmpty());
        $this->trie->clear();
        $this->assertTrue($this->trie->isEmpty());
    }

    /**
     * 测试添加时对非法键（null 或空字符串）的处理
     * 预期抛出 InvalidArgumentException 异常
     */
    public function testAddWithNullKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->trie->add(null, "world");
    }

    /**
     * 测试添加空字符串时的异常处理
     */
    public function testAddWithEmptyKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->trie->add("", "world");
    }

    /**
     * 测试获取时对非法键（null 或空字符串）的处理
     * 预期抛出 InvalidArgumentException 异常
     */
    public function testGetWithNullKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->trie->get(null);
    }

    /**
     * 测试获取空字符串时的异常处理
     */
    public function testGetWithEmptyKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->trie->get("");
    }

    /**
     * 测试 contains 时对非法键（null 或空字符串）的处理
     * 预期抛出 InvalidArgumentException 异常
     */
    public function testContainsWithNullKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->trie->contains(null);
    }

    /**
     * 测试 contains 空字符串时的异常处理
     */
    public function testContainsWithEmptyKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->trie->contains("");
    }

    /**
     * 测试 remove 时对非法键（null 或空字符串）的处理
     * 预期抛出 InvalidArgumentException 异常
     */
    public function testRemoveWithNullKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->trie->remove(null);
    }

    /**
     * 测试 remove 空字符串时的异常处理
     */
    public function testRemoveWithEmptyKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->trie->remove("");
    }

    /**
     * 测试 startsWith 时对非法键（null）的处理
     * 预期抛出 InvalidArgumentException 异常
     */
    public function testStartsWithWithNullKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->trie->startsWith(null);
    }
}
