<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Tree;

/**
 * AVL 树的节点类，继承自 {@link Node}，增加了高度属性用于平衡判断。
 */
class AVLNode extends Node
{
    /**
     * 每个节点的高度，默认为 1。
     * 即使是根节点，其高度也为 1。
     */
    public int $height = 1;

    /**
     * 创建一个 AVLNode 节点
     *
     * @param int $element 节点元素
     * @param ?Node $parent 节点的父节点
     */
    public function __construct(int $element, ?Node $parent)
    {
        parent::__construct($element, $parent);
    }

    /**
     * 获取当前节点的平衡因子。
     * 一个节点的平衡因为是左子树高度减去右子树高度
     * 当节点的左子节点为空时，那左边的高度就是0，否则就是获取左子节点的高度
     * 当节点的右子节点为空时，那右边的高度就是0，否则就是获取右子节点的高度
     * 节点的高度 = 左子节点的高度 - 右子节点的高度
     *
     * @return int 平衡因子，等于左子树高度减去右子树高度
     */
    public function balanceFactor(): int
    {
        $leftHeight = $this->getLeftHeight();
        $rightHeight = $this->getRightHeight();
        return $leftHeight - $rightHeight;
    }

    /**
     * 更新当前节点的高度。
     * 高度为左子节点和右子节点中的最大高度加 1。
     */
    public function updateHeight(): void
    {
        $leftHeight = $this->getLeftHeight();
        $rightHeight = $this->getRightHeight();
        $this->height = 1 + max($leftHeight, $rightHeight);
    }

    /**
     * 获取高度更高的子节点。
     * 如果左右子节点高度相同，是左子节点的话就返回左子节点，否则返回右子节点
     *
     * @return AVLNode 返回高度更高的子节点
     */
    public function tallerChild(): AVLNode
    {
        $leftHeight = $this->getLeftHeight();
        $rightHeight = $this->getRightHeight();
        if ($leftHeight > $rightHeight) {
            return $this->left;
        }
        if ($leftHeight < $rightHeight) {
            return $this->right;
        }
        return $this->isLeftChild() ? $this->left : $this->right;
    }

    /**
     * 获取该节点的左子节点的高度
     *
     * @return int 返回该节点的左子节点的高度
     */
    private function getLeftHeight(): int
    {
        return $this->left === null ? 0 : ($this->left instanceof AVLNode ? $this->left->height : 0);
    }

    /**
     * 获取该节点的右子节点的高度
     *
     * @return int 返回该节点的右子节点的高度
     */
    private function getRightHeight(): int
    {
        return $this->right === null ? 0 : ($this->right instanceof AVLNode ? $this->right->height : 0);
    }
}
