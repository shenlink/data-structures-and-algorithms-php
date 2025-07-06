<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Map;

/**
 * 映射接口
 */
interface Map
{
    /**
     * 清空 map
     */
    public function clear(): void;

    /**
     * 返回 map 中键值对的数量
     *
     * @return int 键值对数量
     */
    public function size(): int;

    /**
     * map 是否为空
     *
     * @return bool 如果 map 没有键值对则返回 true
     */
    public function isEmpty(): bool;

    /**
     * 添加键值对
     *
     * @param int $key 要添加的键
     * @param ?string $value 要添加的值
     * @return string 之前与该键关联的值，如果没有则返回 null
     */
    public function put(int $key, ?string $value): ?string;

    /**
     * 根据 key 获取 value
     *
     * @param int $key 要查找的键
     * @return ?string 与键关联的值，如果不存在则返回 null
     */
    public function get(int $key): ?string;

    /**
     * 删除键值对，返回 key 对应的 value
     *
     * @param int $key 要删除的键
     * @return ?string 与键关联的值，如果不存在则返回 null
     */
    public function remove(int $key): ?string;

    /**
     * 是否包含 key
     *
     * @param int $key 要查找的键
     * @return bool 如果map包含指定键则返回 true
     */
    public function containsKey(int $key): bool;

    /**
     * 是否包含 value
     *
     * @param ?string $value 要查找的值
     * @return bool 如果 map 包含指定值则返回 true
     */
    public function containsValue(?string $value): bool;

    /**
     * 遍历 map
     *
     * @param Visitor $visitor 遍历访问者
     */
    public function traversal(Visitor $visitor): void;
}
