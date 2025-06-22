<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

/**
 * Stack 栈数据结构测试接口 - 定义了栈实现的基本测试方法
 */
interface StackTest
{
    /**
     * 测试入栈操作的方法
     */
    public function testPush(): void;

    /**
     * 测试出栈操作的方法
     */
    public function testPop(): void;

    /**
     * 测试获取栈顶元素的方法
     */
    public function testTop(): void;

    /**
     * 测试清空栈的方法
     */
    public function testClear(): void;

    /**
     * 测试获取栈中元素数量的方法
     */
    public function testSize(): void;

    /**
     * 测试判断栈是否为空的方法
     */
    public function testIsEmpty(): void;
}
