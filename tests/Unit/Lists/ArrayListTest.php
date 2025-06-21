<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use Shenlink\Algorithms\Lists\ArrayList;

/**
 * ArrayList 动态数组测试类，继承自 AbstractListTest
 */
class ArrayListTest extends AbstractListTest
{
    /**
     * 创建 ArrayList 实例
     */
    public function setUp(): void
    {
        $this->list = new ArrayList();
    }

    /**
     * 测试 toString 方法验证内部状态
     */
    public function testToString(): void
    {
        $this->assertEquals("size: 0, elements: []", $this->list->toString());
        $this->list->add(0);
        $this->assertEquals("size: 1, elements: [0]", $this->list->toString());
        $this->list->add(1);
        $this->assertEquals("size: 2, elements: [0, 1]", $this->list->toString());
        $this->list->add(2);
        $this->assertEquals("size: 3, elements: [0, 1, 2]", $this->list->toString());
    }
}
