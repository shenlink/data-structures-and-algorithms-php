<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 栈数据结构的抽象实现类
 * 提供基于线性表的栈操作的默认实现，适用于基于不同线性表结构构建的栈
 * 作为栈接口的基础适配器，为具体实现类提供复用逻辑
 */
abstract class AbstractStack implements Stack
{
    /**
     * 栈的底层数据结构-线性表
     */
    protected IList $list;

    /**
     * 入栈操作
     *
     * @param int $element 要入栈的元素
     */
    public function push(int $element): void
    {
        $this->list->add($element);
    }

    /**
     * 出栈操作
     *
     * @return int 栈顶元素
     */
    public function pop(): int
    {
        return $this->list->remove($this->list->size() - 1);
    }

    /**
     * 获取栈顶元素
     *
     * @return int 栈顶元素
     */
    public function top(): int
    {
        return $this->list->get($this->list->size() - 1);
    }

    /**
     * 清空栈
     */
    public function clear(): void
    {
        $this->list->clear();
    }

    /**
     * 获取栈中元素的数量
     *
     * @return int 元素数量
     */
    public function size(): int
    {
        return $this->list->size();
    }

    /**
     * 检查栈是否为空
     *
     * @return bool 如果栈为空则返回 true，否则返回 false
     */
    public function isEmpty(): bool
    {
        return $this->list->isEmpty();
    }
}
