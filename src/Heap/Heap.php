<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Heap;

/**
 * 堆接口，定义了堆的基本操作
 */
interface Heap
{
    /**
     * 清空堆
     */
    public function clear(): void;

    /**
     * 获取堆大小
     *
     * @return int 堆中元素的数量
     */
    public function size(): int;

    /**
     * 堆是否为空
     *
     * @return bool 如果堆为空则返回 true
     */
    public function isEmpty(): bool;

    /**
     * 添加元素到堆中
     *
     * @param int $element 要添加的元素
     */
    public function add(int $element): void;

    /**
     * 获取堆顶元素
     *
     * @return ?int 堆顶元素，如果堆为空返回 null
     */
    public function get(): ?int;

    /**
     * 删除堆顶元素并返回该元素
     *
     * @return ?int 被删除的堆顶元素，如果堆为空返回 null
     */
    public function remove(): ?int;

    /**
     * 修改堆顶元素并返回该元素
     * 如果此时堆内没有元素，则添加该元素并返回 null
     *
     * @param int $element 新的堆顶元素
     * @return ?int 原来的堆顶元素，或当堆为空时返回 null
     */
    public function replace(int $element): ?int;
}
