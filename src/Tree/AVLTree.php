<?php

namespace Shenlink\Algorithms\Tree;

/**
 * AVL 树实现类
 * 每次插入或删除节点后，都会检查并修复树的平衡性，以确保查找、插入和删除的时间复杂度为 O(log n)。
 * 通过四种旋转操作（LL、LR、RR、RL）维持树的平衡
 */
class AVLTree extends BalancedBinarySearchTree
{
    /**
     * 添加新元素后的平衡操作。
     * 插入一个新节点后，从该节点向上检查祖先节点是否失衡，若失衡则进行旋转操作恢复平衡。
     * 添加之后的操作导致的失衡有4种情况，分别是 LL, LR，RR, RL。
     *
     * @param Node $node 新添加的节点
     */
    protected function afterAdd(Node $node): void
    {
        // 向上查看节点$node的父节点，看一下$node的父节点和所有祖先节点是否平衡，
        // 1. 不平衡的话，通过旋转需要修复，直到平衡为止，
        // 2. 平衡的话，那也需要更新每个节点的高度
        // 注意：插入一个节点$node后，$node的父节点不可能失衡
        while (($node = $node->parent) !== null) {
            if ($this->isBalanced($node)) {
                $this->updateHeight($node);
            } else {
                $this->rebalance($node);
                break;
            }
        }
    }

    /**
     * 删除节点后的平衡操作。
     * 删除一个节点后，从该节点向上检查祖先节点是否失衡，若失衡则进行旋转操作恢复平衡。
     *
     * @param Node $node 被删除的节点
     */
    protected function afterRemove(Node $node): void
    {
        while (($node = $node->parent) !== null) {
            if ($this->isBalanced($node)) {
                $this->updateHeight($node);
            } else {
                $this->rebalance($node);
            }
        }
    }

    /**
     * 创建新的 AVL 树节点。
     *
     * @param int $element 节点元素
     * @param Node|null $parent 节点的父节点
     * @return Node 创建的新节点
     */
    protected function createNode(int $element, ?Node $parent): Node
    {
        return new AVLNode($element, $parent);
    }

    /**
     * 恢复指定节点的平衡。
     * 插入操作后，插入的节点$node的父节点不可能失衡，只有祖父节点及之上的节点可能失衡，
     * 删除操作后，会导致父节点或祖先节点失衡，但是只会有一个节点失衡。
     * 失衡的节点的高度绝对值是2，必然有一个parent节点和child节点，所以可以放心地获取parent和node。
     * 失衡后的旋转包括四种基本旋转类型：LL、LR、RR、RL。
     *
     * @param Node $grand 失衡的祖父节点
     */
    private function rebalance(Node $grand): void
    {
        $parent = $grand instanceof AVLNode ? $grand->tallerChild() : null;
        $node = $parent->tallerChild();
        // L
        if ($parent->isLeftChild()) {
            // LL
            // 需要右旋转
            if ($node->isLeftChild()) {
                $this->rotateRight($grand);
            } else {
                // LR
                // 需要先对$parent进行左旋转
                // 然后对$grand进行右旋转
                $this->rotateLeft($parent);
                $this->rotateRight($grand);
            }
        } else { // R
            // RL
            // 需要先对$parent进行右旋转
            // 再对$grand进行左旋转
            if ($node->isLeftChild()) {
                $this->rotateRight($parent);
                $this->rotateLeft($grand);
            } else {
                // RR
                // 需要进行左旋转
                $this->rotateLeft($grand);
            }
        }
    }

    /**
     * 旋转后的处理，包括更新节点父子关系和高度。
     *
     * @param Node $grand 原始祖父节点
     * @param Node $parent 旋转后的父节点
     * @param Node|null $child 旋转过程中涉及的子节点，可能为 null
     */
    protected function afterRotate(Node $grand, Node $parent, ?Node $child): void
    {
        // 更新$grand，$parent，和$child的父子关系
        parent::afterRotate($grand, $parent, $child);
        // 更新高度
        $this->updateHeight($grand);
        $this->updateHeight($parent);
    }

    /**
     * 判断一个节点是否平衡。
     *
     * @param Node $node 需要判断的节点
     * @return bool 如果平衡返回 true，否则返回 false
     */
    private function isBalanced(Node $node): bool
    {
        if ($node instanceof AVLNode) {
            return abs($node->balanceFactor()) <= 1;
        }
        return true;
    }

    /**
     * 更新指定节点的高度。
     *
     * @param Node $node 需要更新高度的节点
     */
    private function updateHeight(Node $node): void
    {
        if ($node instanceof AVLNode) {
            $node->updateHeight();
        }
    }
}
