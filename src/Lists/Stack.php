<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 栈数据结构接口
 * 定义栈的基本操作
 */
interface Stack
{
    /**
     * 入栈操作
     *
     * @param int $element 要入栈的元素
     */
    public function push(int $element): void;

    /**
     * 出栈操作
     *
     * @return int 栈顶元素
     */
    public function pop(): int;

    /**
     * 获取栈顶元素
     *
     * @return int 栈顶元素
     */
    public function top(): int;

    /**
     * 清空栈
     */
    public function clear(): void;

    /**
     * 获取栈中元素的数量
     *
     * @return int 元素数量
     */
    public function size(): int;

    /**
     * 检查栈是否为空
     *
     * @return bool 如果栈为空则返回 true，否则返回 false
     */
    public function isEmpty(): bool;
}
