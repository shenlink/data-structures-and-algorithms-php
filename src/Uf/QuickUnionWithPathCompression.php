<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Uf;

/**
 * 并查集实现 - 路径压缩优化（递归实现），提升查找效率
 */
class QuickUnionWithPathCompression extends QuickUnionWithRank
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
     * 查找元素 v 所在集合的根节点，并在查找过程中进行路径压缩
     * 路径压缩使得查找路径上的所有节点都直接指向根节点，降低树的高度
     *
     * @param int $v 待查找的元素索引
     * @return int 元素 v 所在集合的根节点
     */
    public function find(int $v): int
    {
        $this->validate($v);
        while ($v !== $this->parents[$v]) {
            $v = $this->find($this->parents[$v]);
        }

        return $this->parents[$v];
    }
}
