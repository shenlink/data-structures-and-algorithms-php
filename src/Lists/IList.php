<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 定义线性表相关操作的接口，包含基本的数据结构操作方法。
 * 该接口为各种线性表实现提供了统一的 API 规范。
 */
interface IList
{
    /**
     * 清空所有元素。
     */
    public function clear(): void;

    /**
     * 返回当前元素的数量。
     *
     * @return int 元素个数
     */
    public function size(): int;

    /**
     * 检查线性表是否为空。
     *
     * @return bool 如果线性表没有元素则返回 true
     */
    public function isEmpty(): bool;

    /**
     * 判断线性表中是否包含指定元素。
     *
     * @param int $element 要查找的元素
     * @return bool 如果找到元素则返回 true
     */
    public function contains(int $element): bool;

    /**
     * 将元素添加到线性表尾部。
     *
     * @param int $element 要添加的元素
     */
    public function add(int $element): void;

    /**
     * 获取指定位置的元素。
     *
     * @param int $index 要获取的元素位置，必须在 [0, size()) 范围内
     * @return int 位于指定索引处的元素
     */
    public function get(int $index): int;

    /**
     * 替换指定位置的元素。
     *
     * @param int   $index   要替换的位置，必须在 [0, size()) 范围内
     * @param int $element 新元素
     * @return int 被替换的旧元素
     */
    public function set(int $index, int $element): int;

    /**
     * 在指定位置插入一个元素。
     *
     * @param int   $index   插入位置，必须在 [0, size()] 范围内
     * @param int $element 要插入的元素
     */
    public function addAt(int $index, int $element): void;

    /**
     * 删除指定位置的元素。
     *
     * @param int $index 要删除的位置，必须在 [0, size()) 范围内
     * @return int 被删除的元素
     */
    public function remove(int $index): int;

    /**
     * 查找指定元素第一次出现的位置。
     *
     * @param int $element 要查找的元素
     * @return int 元素首次出现的索引位置，如果未找到则返回 -1
     */
    public function indexOf(int $element): int;

    /**
     * 返回动态数组的字符串表示。
     *
     * @return string 表示动态数组内容的字符串
     */
    public function toString(): string;
}
