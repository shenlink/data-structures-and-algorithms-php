<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use Shenlink\Algorithms\Lists\SingleCircleLinkedList;

/**
 * 单向循环链表测试类
 * 测试单向循环链表实现的线性表功能
 */
class SingleCircleLinkedListTest extends AbstractListTest
{
    /**
     * 创建测试用的单向循环链表实例
     */
    public function setUp(): void
    {
        $this->list = new SingleCircleLinkedList();
    }

    /**
     * 测试 toString 方法
     * 验证单向循环链表内部的正确性
     */
    public function testToString(): void
    {
        $this->assertEquals("head: null, size: 0, elements: []", $this->list->toString());
        $this->list->add(0);
        $this->assertEquals("head: (0, 0), size: 1, elements: [(0, 0)]", $this->list->toString());
        $this->list->add(1);
        $this->assertEquals("head: (0, 1), size: 2, elements: [(0, 1), (1, 0)]", $this->list->toString());
        $this->list->add(2);
        $this->assertEquals("head: (0, 1), size: 3, elements: [(0, 1), (1, 2), (2, 0)]", $this->list->toString());
    }
}
