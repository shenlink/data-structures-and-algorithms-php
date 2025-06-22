<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Lists\Stack;

/**
 * 抽象栈数据结构测试类，实现了 StackTest 接口定义的基础测试方法
 */
abstract class AbstractStackTest extends TestCase implements StackTest
{
    /**
     * 栈实例
     */
    protected Stack $stack;

    /**
     * 测试入栈操作的方法
     * 验证栈在添加元素后是否正确维护其内部状态
     */
    public function testPush(): void
    {
        $this->stack->push(1);
        $this->stack->push(2);
        $this->assertEquals(2, $this->stack->size());
        $this->assertEquals(2, $this->stack->top());
    }

    /**
     * 测试出栈操作的方法
     * 验证栈在移除元素后是否正确更新栈顶和大小
     */
    public function testPop(): void
    {
        $this->stack->push(1);
        $this->stack->push(2);
        $this->assertEquals(2, $this->stack->pop());
        $this->assertEquals(1, $this->stack->size());
        $this->assertEquals(1, $this->stack->top());
    }

    /**
     * 测试获取栈顶元素的方法
     * 验证 top 方法返回当前栈顶的元素而不移除它
     */
    public function testTop(): void
    {
        $this->stack->push(1);
        $this->stack->push(2);
        $this->assertEquals(2, $this->stack->top());
        $this->assertEquals(2, $this->stack->size());
    }

    /**
     * 测试清空栈的方法
     * 验证 clear 方法调用后栈是否被正确重置为空
     */
    public function testClear(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->stack->push($i);
        }
        $this->stack->clear();
        $this->assertTrue($this->stack->isEmpty());
        $this->assertEquals(0, $this->stack->size());
    }

    /**
     * 测试获取栈中元素数量的方法
     * 验证 size 方法能否准确反映栈当前的大小
     */
    public function testSize(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->stack->push($i);
            $this->assertEquals($i + 1, $this->stack->size());
        }
        $this->stack->clear();
        $this->assertEquals(0, $this->stack->size());
    }

    /**
     * 测试判断栈是否为空的方法
     * 验证 isEmpty 方法能否正确识别空栈与非空栈
     */
    public function testIsEmpty(): void
    {
        $this->assertTrue($this->stack->isEmpty());
        $this->stack->push(0);
        $this->assertFalse($this->stack->isEmpty());
        $this->stack->pop();
        $this->assertTrue($this->stack->isEmpty());
    }
}
