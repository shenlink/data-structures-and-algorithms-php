<?php

declare(strict_types=1);

namespace Tests\Unit\Map;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Map\Map;
use Shenlink\Algorithms\Map\Visitor;

/**
 * Map 映射测试基类 - 定义了映射实现的基本测试方法
 * 提供了通用的映射功能测试用例，用于验证不同 Map 实现类的正确性
 */
abstract class MapTest extends TestCase
{
    /**
     * 被测试的映射实例
     */
    protected Map $map;

    /**
     * 测试清空映射内容的方法
     */
    public function testClear(): void
    {
        $this->assertTrue($this->map->isEmpty());
        $this->map->put(1, "one");
        $this->map->put(2, "two");
        $this->map->clear();
        $this->assertTrue($this->map->isEmpty());
        $this->assertEquals(0, $this->map->size());
    }

    /**
     * 测试获取映射元素数量的方法
     */
    public function testSize(): void
    {
        $this->assertEquals(0, $this->map->size());
        $this->map->put(1, "one");
        $this->assertEquals(1, $this->map->size());
        $this->map->put(2, "two");
        $this->assertEquals(2, $this->map->size());
    }

    /**
     * 测试判断映射是否为空的方法
     */
    public function testIsEmpty(): void
    {
        $this->assertTrue($this->map->isEmpty());
        $this->map->put(1, "one");
        $this->assertFalse($this->map->isEmpty());
    }

    /**
     * 测试向映射中添加键值对的方法
     */
    public function testPut(): void
    {
        $this->map->put(1, "one");
        $this->map->put(2, "two");
        $this->map->put(3, "three");

        $this->assertEquals("one", $this->map->get(1));
        $this->assertEquals("two", $this->map->get(2));
        $this->assertEquals("three", $this->map->get(3));
        $this->map->put(3, "three");
        $this->assertEquals("three", $this->map->get(3));
        $this->assertNull($this->map->get(4));
    }

    /**
     * 测试从映射中根据键获取值的方法
     */
    public function testGet(): void
    {
        $this->map->put(1, "one");
        $this->map->put(2, "two");
        $this->map->put(3, "three");

        $this->assertEquals("one", $this->map->get(1));
        $this->assertEquals("two", $this->map->get(2));
        $this->assertEquals("three", $this->map->get(3));
        $this->map->put(3, "three");
        $this->assertEquals("three", $this->map->get(3));
        $this->assertNull($this->map->get(4));
    }

    /**
     * 测试从映射中根据键删除键值对的方法
     */
    public function testRemove(): void
    {
        $this->map->put(1, "one");
        $this->map->put(2, "two");
        $this->map->put(3, "three");

        $this->assertEquals("one", $this->map->remove(1));
        $this->assertNull($this->map->get(1));
        $this->assertEquals(2, $this->map->size());

        $this->assertEquals("two", $this->map->remove(2));
        $this->assertNull($this->map->get(2));
        $this->assertEquals(1, $this->map->size());

        $this->assertEquals("three", $this->map->remove(3));
        $this->assertNull($this->map->get(3));
        $this->assertEquals(0, $this->map->size());
    }

    /**
     * 测试判断映射是否包含指定键的方法
     */
    public function testContainsKey(): void
    {
        $this->map->put(1, "one");
        $this->map->put(2, "two");

        $this->assertTrue($this->map->containsKey(1));
        $this->assertTrue($this->map->containsKey(2));
        $this->assertFalse($this->map->containsKey(3));
    }

    /**
     * 测试判断映射是否包含指定值的方法
     */
    public function testContainsValue(): void
    {
        $this->map->put(1, "one");
        $this->map->put(2, "two");

        $this->assertTrue($this->map->containsValue("one"));
        $this->assertTrue($this->map->containsValue("two"));
        $this->assertFalse($this->map->containsValue("three"));
    }

    /**
     * 测试遍历映射内容的方法
     */
    public function testTraversal(): void
    {
        $this->map->put(1, "one");
        $this->map->put(2, "two");
        $this->map->put(3, "three");

        $visitor = new class extends Visitor {
            public function visit(int $key, ?string $value): bool
            {
                $this->results[] = "$key-$value";
                return false;
            }
        };
        $this->map->traversal($visitor);
        $this->assertEquals(['1-one', '2-two', '3-three'], $visitor->getResults());
    }
}
