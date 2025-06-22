<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use Shenlink\Algorithms\Lists\ArrayStack;

/**
 * ArrayStack 单元测试类
 * 针对基于动态数组实现的栈结构进行功能验证
 * 继承自 AbstractStackTest，提供具体的栈实例创建逻辑
 */
class ArrayStackTest extends AbstractStackTest
{
    /**
     * 创建一个 ArrayStack 实例
     */
    protected function setUp(): void
    {
        $this->stack = new ArrayStack();
    }
}
