<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Uf;

/**
 * 并查集实现 - 快速查找（Quick Find），牺牲合并性能换取查找性能
 */
class QuickFind extends UnionFind
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
     * 查找元素 v 所在集合的根节点
     * 在 QuickFind 实现中，每个元素直接存储其根节点
     *
     * @param int $v 待查找的元素索引
     * @return int 元素 v 所在集合的根节点
     */
    public function find(int $v): int
    {
        $this->validate($v);
        return $this->parents[$v];
    }

    /**
     * 合并两个集合，即将所有与 v1 同属一个集合的元素的根节点设为 v2 的根节点
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

        foreach ($this->parents as $i => $parent) {
            if ($parent === $p1) {
                $this->parents[$i] = $p2;
            }
        }
    }
}
