<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Uf;

/**
 * 并查集实现 - 路径减半优化（Path Halving），提升查找效率
 */
class QuickUnionWithPathHalf extends QuickUnionWithRank
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
     * 查找元素 v 所在集合的根节点，并在查找过程中进行路径减半
     * 路径减半使每隔一个节点就指向祖父节点，从而减少树的高度
     *
     * @param int $v 待查找的元素索引
     * @return int 元素 v 所在集合的根节点
     */
    public function find(int $v): int
    {
        while ($v !== $this->parents[$v]) {
            // 当前节点指向祖父节点
            $this->parents[$v] = $this->parents[$this->parents[$v]];
            // 注意：这里跳过v的父节点，v的父节点还是会指向v的祖父节点
            $v = $this->parents[$v];
        }
        return $v;
    }
}
