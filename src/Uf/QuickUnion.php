<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Uf;

/**
 * 并查集实现 - 快速合并（Quick Union）
 */
class QuickUnion extends UnionFind
{
    /**
     * 构造函数
     *
     * @param int $capacity 集合容量
     */
    public function __construct(int $capacity)
    {
        parent::__construct($capacity);
    }

    /**
     * 查找元素 v 所在集合的根节点（路径压缩优化可在子类中实现）
     *
     * @param int $v 待查找的元素索引
     * @return int 元素 v 所在集合的根节点
     */
    public function find(int $v): int
    {
        $this->validate($v);
        // 沿着父节点不断向上查找，直到找到根节点
        while ($v !== $this->parents[$v]) {
            $v = $this->parents[$v];
        }
        return $v;
    }

    /**
     * 将两个元素所在的集合合并
     * 合并策略为：将第一个集合的根节点直接指向第二个集合的根节点
     *
     * @param int $v1 第一个元素
     * @param int $v2 第二个元素
     */
    public function union(int $v1, int $v2): void
    {
        $p1 = $this->find($v1);
        $p2 = $this->find($v2);
        if ($p1 === $p2) {
            return;
        }

        $this->parents[$p1] = $p2;
    }
}
