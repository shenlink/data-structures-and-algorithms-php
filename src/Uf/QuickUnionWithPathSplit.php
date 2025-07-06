<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Uf;

/**
 * 并查集实现 - 路径分裂优化（Path Splitting），提升查找效率
 */
class QuickUnionWithPathSplit extends QuickUnionWithRank
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
     * 查找元素 v 所在集合的根节点，并在查找过程中进行路径分裂
     * 路径分裂使每个节点指向其祖父节点，从而减少树的高度
     *
     * @param int $v 待查找的元素索引
     * @return int 元素 v 所在集合的根节点
     */
    public function find(int $v): int
    {
        while ($v !== $this->parents[$v]) {
            $parent = $this->parents[$v];
            $this->parents[$v] = $this->parents[$parent];
            $v = $parent;
        }
        return $v;
    }
}
