<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Uf;

use InvalidArgumentException;

/**
 * 并查集抽象类，提供并查集的基本操作定义
 */
abstract class UnionFind
{
    /**
     * 存储每个节点的父节点索引数组，索引表示节点，值表示该节点的父节点索引
     * 
     * @var array<int>
     */
    protected array $parents;

    /**
     * 构造函数，初始化并查集
     *
     * @param int $capacity 并查集的容量
     * @throws InvalidArgumentException 如果$capacity小于0则抛出异常
     */
    public function __construct(int $capacity)
    {
        if ($capacity < 0) {
            throw new InvalidArgumentException("capacity must be >= 1");
        }
        $this->parents = array_fill(0, $capacity, 0);
        for ($i = 0; $i < $capacity; $i++) {
            $this->parents[$i] = $i;
        }
    }

    /**
     * 查找指定元素所在集合的根节点（代表元）
     *
     * @param int $v 要查找的元素
     * @return int 根节点的索引
     */
    abstract public function find(int $v): int;

    /**
     * 合并两个元素所属的集合
     *
     * @param int $v1 第一个元素
     * @param int $v2 第二个元素
     */
    abstract public function union(int $v1, int $v2): void;

    /**
     * 判断两个元素是否属于同一个集合
     *
     * @param int $v1 第一个元素
     * @param int $v2 第二个元素
     * @return bool 如果两个元素在同一个集合中返回true，否则返回false
     */
    public function isConnected(int $v1, int $v2): bool
    {
        return $this->find($v1) === $this->find($v2);
    }

    /**
     * 验证给定的索引是否在有效范围内
     *
     * @param int $v 要验证的索引
     * @throws InvalidArgumentException 如果$v不在有效范围内则抛出异常
     */
    protected function validate(int $v): void
    {
        if ($v < 0 || $v >= count($this->parents)) {
            throw new InvalidArgumentException("v must between 0 and " . (count($this->parents) - 1));
        }
    }
}
