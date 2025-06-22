<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 键值对条目类
 */
class SparseArrayEntry
{
    /**
     * @var int 行索引
     */
    private int $row;

    /**
     * @var int 列索引
     */
    private int $col;

    /**
     * @var int 存储的值
     */
    private int $value;

    /**
     * 创建一个新的条目
     *
     * @param int $row 行索引
     * @param int $col 列索引
     * @param int $value 存储的值
     */
    public function __construct(int $row, int $col, int $value)
    {
        $this->row = $row;
        $this->col = $col;
        $this->value = $value;
    }

    /**
     * 获取行索引
     *
     * @return int 行索引
     */
    public function getRow(): int
    {
        return $this->row;
    }

    /**
     * 获取列索引
     *
     * @return int 列索引
     */
    public function getCol(): int
    {
        return $this->col;
    }

    /**
     * 获取存储的值
     *
     * @return int 存储的值
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * 重写 equals 方法，用于比较两个对象是否相等
     * 此方法重写了Object类的equals方法，目的是比较两个SparseArrayEntry对象的row、col和value属性是否完全相等
     *
     * @param mixed $o 被比较的对象
     * @return bool 如果两个对象相等则返回true，否则返回false
     */
    public function equals($o): bool
    {
        // 如果是同一个对象，返回true
        if ($this === $o) {
            return true;
        }

        // 如果传入的对象不是SparseArrayEntry类型，则返回false
        if (!($o instanceof SparseArrayEntry)) {
            return false;
        }

        // 将传入的对象转换为SparseArrayEntry类型，并进行属性值的比较
        $entry = $o;

        // 比较两个SparseArrayEntry对象的row、col和value属性是否相等
        return $this->row === $entry->row && $this->col === $entry->col && $this->value === $entry->value;
    }

    /**
     * 重写hashCode方法，用于生成对象的哈希码
     * 这对于在哈希集合中（如HashMap, HashSet）使用对象作为键时尤为重要
     *
     * @return int 对象的哈希码，由row, col和value的哈希值组成
     */
    public function hashCode(): int
    {
        return crc32(json_encode([$this->row, $this->col, $this->value]));
    }

    /**
     * 返回稀疏数组的字符串表示
     *
     * @return string 包含稀疏数组的行(row)、列(col)和值(value)信息的字符串
     */
    public function toString(): string
    {
        // 返回一个字符串，格式为"(行, 列, 值)"
        return "(" . $this->row . ", " . $this->col . ", " . $this->value . ")";
    }
}
