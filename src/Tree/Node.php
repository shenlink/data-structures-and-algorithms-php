<?php

namespace Shenlink\Algorithms\Tree;

/**
 * 二叉树节点类
 *
 * @package Shenlink\Algorithms\Tree
 */
class Node
{
    /**
     * 二叉树的节点的元素
     */
    public ?int $element;

    /**
     * 二叉树的节点的左子节点
     */
    public ?Node $left;

    /**
     * 二叉树的节点的右子节点
     */
    public ?Node $right;

    /**
     * 二叉树的节点的父节点
     */
    public ?Node $parent;

    /**
     * 构造一个新的节点
     *
     * @param ?int $element 节点中存储的元素
     * @param ?Node $parent 父节点
     */
    public function __construct(?int $element, ?Node $parent)
    {
        $this->element = $element;
        $this->parent = $parent;
        $this->left = null;
        $this->right = null;
    }

    /**
     * 判断该节点是否是叶子节点
     *
     * @return bool 如果是叶子节点返回 true，否则返回 false
     */
    public function isLeaf(): bool
    {
        return $this->left === null && $this->right === null;
    }

    /**
     * 判断该节点是否有两个子节点
     *
     * @return bool 如果有左右两个子节点返回 true，否则返回 false
     */
    public function hasTwoChildren(): bool
    {
        return $this->left !== null && $this->right !== null;
    }

    /**
     * 判断该节点是否是左子节点
     *
     * @return bool 如果是左子节点返回 true，否则返回 false
     */
    public function isLeftChild(): bool
    {
        return $this->parent !== null && $this === $this->parent->left;
    }

    /**
     * 判断该节点是否是右子节点
     *
     * @return bool 如果是右子节点返回 true，否则返回 false
     */
    public function isRightChild(): bool
    {
        return $this->parent !== null && $this === $this->parent->right;
    }

    /**
     * 获取该节点的兄弟节点
     *
     * @return ?Node 如果存在兄弟节点则返回兄弟节点，否则返回 null
     */
    public function sibling(): ?Node
    {
        if ($this->isLeftChild()) {
            return $this->parent->right;
        }

        if ($this->isRightChild()) {
            return $this->parent->left;
        }

        return null;
    }
}
