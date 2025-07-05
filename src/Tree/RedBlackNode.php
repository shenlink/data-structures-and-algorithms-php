<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Tree;

/**
 * 红黑树实现类
 * 红黑树是一种自平衡的二叉搜索树，保证了树的高度大约在 2log(n) 以内，
 * 提供了高效的插入、删除和查找操作。
 *
 * 特性：
 * 1. 每个节点要么是红色，要么是黑色
 * 2. 根节点是黑色
 * 3. 每个叶子节点（NIL 节点）是黑色
 * 4. 如果一个节点是红色，则它的两个子节点都是黑色
 * 红色节点的父节点都是黑色节点
 * 从根节点到叶子节点的所有路径上不能有2个连续的红色节点
 * 5. 从任一节点到其每个叶子的所有路径都包含相同的黑色节点
 */
class RedBlackNode extends Node
{
    /**
     * 节点的颜色：红色
     */
    public const RED = false;

    /**
     * 节点的颜色：黑色
     */
    public const BLACK = true;

    /**
     * 节点的颜色
     * 默认是红色
     * @var bool
     */
    public bool $color = self::RED;

    /**
     * 构造函数
     *
     * @param int $element 节点元素
     * @param ?Node $parent 父节点
     */
    public function __construct(int $element, ?Node $parent)
    {
        parent::__construct($element, $parent);
    }
}
