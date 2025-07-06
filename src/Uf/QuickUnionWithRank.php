<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Uf;

/**
 * 并查集实现 - 基于树高度（rank）优化的快速合并
 */
class QuickUnionWithRank extends QuickUnion
{
    /**
     * 存储每个集合的树高，索引表示根节点，值表示该集合的树高
     * 
     * @var array<int>
     */
    private array $ranks;

    /**
     * 构造函数
     *
     * @param int $capacity 容量
     */
    public function __construct(int $capacity)
    {
        parent::__construct($capacity);
        $this->ranks = array_fill(0, $capacity, 1);
    }

    /**
     * 合并两个集合，合并时考虑两棵树的高度（rank）
     * 高度较小的树合并到高度较大的树上，以避免树的高度增长过快
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

        if ($this->ranks[$p1] < $this->ranks[$p2]) {
            $this->parents[$p1] = $p2;
        } else if ($this->ranks[$p1] > $this->ranks[$p2]) {
            $this->parents[$p2] = $p1;
        } else {
            // 两个集合的树高一样，随便让一个集合合并到另一个集合，并将合并后的树高度加1
            $this->parents[$p1] = $p2;
            $this->ranks[$p2] += 1;
        }
    }
}
