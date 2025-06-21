<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use Shenlink\Algorithms\Lists\SingleLinkedList;

/**
 * 单向链表测试类
 * 测试单向链表实现的线性表功能
 */
class SingleLinkedListTest extends AbstractListTest
{
    /**
     * 创建测试用的单向链表实例
     */
    public function setUp(): void
    {
        $this->list = new SingleLinkedList();
    }

    /**
     * 测试 toString 方法
     * 验证单向链表内部的正确性
     */
    public function testToString(): void
    {
        $this->assertEquals("head: null, size: 0, elements: []", $this->list->toString());
        $this->list->add(0);
        $this->assertEquals("head: (0, null), size: 1, elements: [(0, null)]", $this->list->toString());
        $this->list->add(1);
        $this->assertEquals("head: (0, 1), size: 2, elements: [(0, 1), (1, null)]", $this->list->toString());
        $this->list->add(2);
        $this->assertEquals("head: (0, 1), size: 3, elements: [(0, 1), (1, 2), (2, null)]", $this->list->toString());
    }
}
