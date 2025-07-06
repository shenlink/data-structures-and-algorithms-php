<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Uf;

/**
 * 并查集-快速合并-基于size的优化
 * 支持动态合并和查找操作，并通过维护每个集合的大小来优化合并操作。
 */
class QuickUnionWithSize extends QuickUnion
{
    /**
     * 存储每个集合的大小，索引表示根节点，值表示该集合的元素数量
     * 
     * @var array<int>
     */
    private array $sizes;

    /**
     * 构造一个基于 size 优化的并查集实例。
     *
     * @param int $capacity 初始容量
     */
    public function __construct(int $capacity)
    {
        parent::__construct($capacity);
        $this->sizes = array_fill(0, $capacity, 1);
    }

    /**
     * 合并两个元素所属的集合，并根据集合大小决定合并方向以保持较低的树高度。
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

        // 如果v2所在的集合的元素数量更多，则将v1的根节点指向v2的根节点，
        // 然后更新v2所在集合的大小。
        if ($this->sizes[$p1] < $this->sizes[$p2]) {
            $this->parents[$p1] = $p2;
            $this->sizes[$p2] += $this->sizes[$p1];
        } else { // 对称操作
            $this->parents[$p2] = $p1;
            $this->sizes[$p1] += $this->sizes[$p2];
        }
    }
}
