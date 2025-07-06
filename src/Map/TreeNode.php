<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Map;

/**
 * 红黑树节点类，表示红黑树中的一个键值对节点
 */
class TreeNode
{
    /**
     * 键值对的键
     */
    public int $key;

    /**
     * 键值对的值
     */
    public string $value;

    /**
     * 节点的颜色，RED表示红色，BLACK表示黑色
     */
    public bool $color = false;

    /**
     * 左子节点
     */
    public ?TreeNode $left = null;

    /**
     * 右子节点
     */
    public ?TreeNode $right = null;

    /**
     * 父节点
     */
    public ?TreeNode $parent = null;

    /**
     * 构造方法
     *
     * @param int $key          节点的键
     * @param string $value     节点的值
     * @param ?TreeNode $parent 父节点
     */
    public function __construct(int $key, string $value, ?TreeNode $parent)
    {
        $this->key = $key;
        $this->value = $value;
        $this->parent = $parent;
    }

    /**
     * 判断当前节点是否有两个子节点
     *
     * @return bool 如果左右子节点都存在返回true，否则返回false
     */
    public function hasTwoChildren(): bool
    {
        return $this->left !== null && $this->right !== null;
    }

    /**
     * 判断当前节点是否是父节点的左子节点
     *
     * @return bool 如果当前节点是父节点的左子节点返回true，否则返回false
     */
    public function isLeftChild(): bool
    {
        return $this->parent !== null && $this === $this->parent->left;
    }

    /**
     * 判断当前节点是否是父节点的右子节点
     *
     * @return bool 如果当前节点是父节点的右子节点返回true，否则返回false
     */
    public function isRightChild(): bool
    {
        return $this->parent !== null && $this === $this->parent->right;
    }

    /**
     * 获取当前节点的兄弟节点
     *
     * @return TreeNode|null 返回兄弟节点，如果没有父节点或没有兄弟节点则返回null
     */
    public function sibling(): ?TreeNode
    {
        if ($this->isLeftChild()) {
            return $this->parent->right;
        }

        if ($this->isRightChild()) {
            return $this->parent->left;
        }

        return null;
    }

    /**
     * 获取节点的字符串表示
     *
     * @return string 返回节点的字符串表示
     */
    public function toString(): string
    {
        return $this->key . '-' . $this->value;
    }
}
