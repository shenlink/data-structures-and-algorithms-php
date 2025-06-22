<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use Shenlink\Algorithms\Lists\LinkedListStack;

/**
 * LinkedListStack 单元测试类
 * 针对基于单向链表实现的栈结构进行功能验证
 * 继承自 AbstractStackTest，提供具体的栈实例创建逻辑
 */
class LinkedListStackTest extends AbstractStackTest
{
    /**
     * 创建一个 LinkedListStack 实例
     */
    protected function setUp(): void
    {
        $this->stack = new LinkedListStack();
    }
}
