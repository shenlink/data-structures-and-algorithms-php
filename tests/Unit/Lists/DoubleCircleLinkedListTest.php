<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use Shenlink\Algorithms\Lists\DoubleCircleLinkedList;

/**
 * 双向循环链表测试类
 * 测试双向循环链表实现的线性表功能
 */
class DoubleCircleLinkedListTest extends AbstractListTest
{
    /**
     * 创建测试用的双向循环链表实例
     */
    protected function setUp(): void
    {
        $this->list = new DoubleCircleLinkedList();
    }

    /**
     * 测试 toString 方法
     * 验证双向循环链表内部的正确性
     */
    public function testToString(): void
    {
        $this->assertEquals("head: null, tail: null, size: 0, elements: []", $this->list->toString());
        $this->list->add(0);
        $this->assertEquals("head: (0, 0, 0), tail: (0, 0, 0), " .
            "size: 1, elements: [(0, 0, 0)]", $this->list->toString());
        $this->list->add(1);
        $this->assertEquals("head: (1, 0, 1), tail: (0, 1, 0), size: 2," .
            " elements: [(1, 0, 1), (0, 1, 0)]", $this->list->toString());
        $this->list->add(2);
        $this->assertEquals("head: (2, 0, 1), tail: (1, 2, 0), size: 3," .
            " elements: [(2, 0, 1), (0, 1, 2), (1," .
            " 2, 0)]", $this->list->toString());
    }
}
