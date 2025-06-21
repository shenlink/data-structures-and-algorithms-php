<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use Shenlink\Algorithms\Lists\DoubleLinkedList;

/**
 * 双向链表测试类
 * 测试双向链表实现的线性表功能
 */
class DoubleLinkedListTest extends AbstractListTest
{
    /**
     * 创建测试用的双向链表实例
     */
    protected function setUp(): void
    {
        $this->list = new DoubleLinkedList();
    }

    /**
     * 测试 toString 方法
     * 验证双向链表内部的正确性
     */
    public function testToString(): void
    {
        $this->assertEquals("head: null, tail: null, size: 0, elements: []", $this->list->toString());
        $this->list->add(0, 0);
        $this->assertEquals("head: (null, 0, null), tail: (null, 0, null), size: 1, elements: [(null, 0, null)]", $this->list->toString());
        $this->list->add(1, 1);
        $this->assertEquals("head: (null, 0, 1), tail: (0, 1, null), size: 2, elements: [(null, 0, 1), (0, 1, null)]", $this->list->toString());
        $this->list->add(2, 2);
        $this->assertEquals("head: (null, 0, 1), tail: (1, 2, null), size: 3, elements: [(null, 0, 1), (0, 1, 2), (1, 2, null)]", $this->list->toString());
    }
}
