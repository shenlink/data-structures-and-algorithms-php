<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Set;

/**
 * 集合接口，定义了集合的基本操作方法。
 * 该接口为不同的集合实现提供了统一的 API 规范。
 */
interface Set
{
    /**
     * 清空集合中的所有元素。
     */
    public function clear(): void;

    /**
     * 返回当前集合中元素的数量。
     *
     * @return int 元素个数
     */
    public function size(): int;

    /**
     * 检查集合是否为空。
     *
     * @return bool 如果集合没有元素则返回 true
     */
    public function isEmpty(): bool;

    /**
     * 判断集合中是否包含指定元素。
     *
     * @param int $element 要查找的元素
     * @return bool 如果找到元素则返回 true
     */
    public function contains(int $element): bool;

    /**
     * 向集合中添加一个元素。
     *
     * @param int $element 要添加的元素
     */
    public function add(int $element): void;

    /**
     * 从集合中删除指定的元素。
     *
     * @param int $element 要删除的元素
     */
    public function remove(int $element): void;

    /**
     * 遍历集合中的所有元素。
     *
     * @param Visitor $visitor 访问器，用于处理每个元素
     */
    public function traversal(Visitor $visitor): void;
}
