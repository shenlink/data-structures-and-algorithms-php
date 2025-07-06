<?php

declare(strict_types=1);

namespace Tests\Unit\Set;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Set\Set;
use Shenlink\Algorithms\Set\Visitor;

/**
 * 集合测试类，用于测试不同实现的 Set 接口功能
 * 提供了标准的单元测试方法验证集合的基本操作
 */
abstract class SetTest extends TestCase
{
    /**
     * 集合实例
     */
    protected Set $set;

    /**
     * 测试清空集合功能
     */
    public function testClear(): void
    {
        $this->assertTrue($this->set->isEmpty());
        $this->set->add(1);
        $this->set->add(2);
        $this->set->clear();
        $this->assertTrue($this->set->isEmpty());
    }

    /**
     * 测试获取集合大小功能
     */
    public function testSize(): void
    {
        $this->assertEquals(0, $this->set->size());
        $this->set->add(1);
        $this->assertEquals(1, $this->set->size());
        $this->set->add(2);
        $this->assertEquals(2, $this->set->size());
    }

    /**
     * 测试判断集合是否为空的功能
     */
    public function testIsEmpty(): void
    {
        $this->assertTrue($this->set->isEmpty());
        $this->set->add(1);
        $this->assertFalse($this->set->isEmpty());
    }

    /**
     * 测试判断集合是否包含指定元素的功能
     */
    public function testContains(): void
    {
        $this->assertFalse($this->set->contains(1));
        $this->set->add(1);
        $this->assertTrue($this->set->contains(1));
    }

    /**
     * 测试向集合添加元素的功能
     */
    public function testAdd(): void
    {
        $this->assertTrue($this->set->isEmpty());
        $this->assertFalse($this->set->contains(1));
        $this->set->add(1);
        $this->assertTrue($this->set->contains(1));
        $this->set->add(2);
        $this->assertTrue($this->set->contains(2));
        $this->set->add(2);
        $this->assertTrue($this->set->contains(2));
        $this->assertEquals(2, $this->set->size());
    }

    /**
     * 测试从集合中移除元素的功能
     */
    public function testRemove(): void
    {
        $this->set->add(1);
        $this->set->add(2);
        $this->set->remove(1);
        $this->assertFalse($this->set->contains(1));
        $this->assertTrue($this->set->contains(2));
    }

    /**
     * 测试遍历集合元素的功能
     */
    public function testTraversal(): void
    {
        $this->set->add(1);
        $this->set->add(2);
        $this->set->add(3);

        $visitor = new class extends Visitor {
            public function visit(int $element): bool
            {
                $this->results[] = $element;
                return false;
            }
        };
        $this->set->traversal($visitor);
        $results = $visitor->getResults();
        $this->assertCount(3, $results);
        $this->assertTrue(in_array(1, $results, true));
        $this->assertTrue(in_array(2, $results, true));
        $this->assertTrue(in_array(3, $results, true));
    }
}
