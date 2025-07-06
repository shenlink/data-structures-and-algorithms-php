<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Set;

use Shenlink\Algorithms\Tree\BinaryTree;
use Shenlink\Algorithms\Tree\RedBlackTree;

/**
 * 基于红黑树实现的集合。
 * 特点是遍历时能够按照元素的自然顺序进行访问。
 */
class TreeSet implements Set
{
    /**
     * 内部使用的红黑树，用于存储集合元素并保持有序
     * @var RedBlackTree<int>
     */
    private RedBlackTree $tree;

    public function __construct()
    {
        $this->tree = new RedBlackTree();
    }

    /**
     * 清空集合中的所有元素。
     */
    public function clear(): void
    {
        $this->tree->clear();
    }

    /**
     * 获取当前集合中元素的数量。
     *
     * @return int 集合中元素的个数
     */
    public function size(): int
    {
        return $this->tree->size();
    }

    /**
     * 检查集合是否为空。
     *
     * @return bool 如果集合没有元素则返回 true
     */
    public function isEmpty(): bool
    {
        return $this->tree->isEmpty();
    }

    /**
     * 判断集合中是否包含指定元素。
     *
     * @param int $element 要查找的元素
     * @return bool 如果集合中存在该元素则返回 true
     */
    public function contains(int $element): bool
    {
        return $this->tree->contains($element);
    }

    /**
     * 向集合中添加一个元素。
     *
     * @param int $element 要添加的元素
     */
    public function add(int $element): void
    {
        $this->tree->add($element);
    }

    /**
     * 从集合中删除指定的元素。
     *
     * @param int $element 要删除的元素
     */
    public function remove(int $element): void
    {
        $this->tree->remove($element);
    }

    /**
     * 遍历集合中的所有元素。
     * 使用内部红黑树的中序遍历方式处理每个元素。
     * 注意：这个顺序不是添加的顺序，而是元素比较的顺序。
     *
     * @param Visitor<int> $visitor 访问器
     */
    public function traversal(Visitor $visitor): void
    {
        if ($visitor === null) {
            return;
        }

        $this->tree->inOrder(new class($visitor) extends BinaryTreeVisitor {
            public function visit(int $element): bool
            {
                if ($this->visitor->visit($element) || $this->visitor->stop) {
                    return true;
                }
                return false;
            }
        });
    }
}
