<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Map;

use InvalidArgumentException;

/**
 * 基于树的Map，底层使用红黑树实现
 */
class TreeMap implements Map
{
    /**
     * 红色节点标识
     */
    private const RED = false;

    /**
     * 黑色节点标识
     */
    private const BLACK = true;

    /**
     * 映射键值对的数量
     */
    private int $size = 0;

    /**
     * 红黑树的根节点
     */
    private ?TreeNode $root = null;

    /**
     * 清空映射中的所有键值对
     */
    public function clear(): void
    {
        $this->root = null;
        $this->size = 0;
    }

    /**
     * 获取映射中键值对的数量
     *
     * @return int 键值对数量
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * 判断映射是否为空
     *
     * @return bool 如果映射为空返回true，否则返回false
     */
    public function isEmpty(): bool
    {
        return $this->size === 0;
    }

    /**
     * 添加键值对到映射中
     *
     * @param int $key   要添加的键，不能为空
     * @param ?string $value 要添加的值
     * @return ?string 与键关联的旧值，如果没有则返回null
     */
    public function put(int $key, ?string $value): ?string
    {
        // key不能为空
        $this->checkKey($key);

        // 添加第一个节点
        if ($this->root === null) {
            // 创建根节点
            $this->root = new TreeNode($key, $value, null);
            $this->size++;

            // 新添加节点之后的处理
            // 修复红黑树的性质
            $this->afterPut($this->root);
            return null;
        }

        // 添加的不是第一个节点
        // 找到父节点
        // 默认父节点根节点
        $parent = $this->root;
        $node = $this->root;
        $cmp = 0;
        do {
            // 比较结果
            $cmp = $this->compare($key, $node->key);
            // 保存当前节点为父节点，除了要添加的节点已经在树中的情况，
            // 另外两种情况，添加的时候需要获取到加节点的父节点，在最后
            // 一次循环的时候，newNode = node.right或newNode = node.left，
            // 此时newNode == null，此时，在node = node.right或node = node.left
            // 之前就保存下来的node就是这个newNode的父节点
            $parent = $node;
            if ($cmp > 0) {
                $node = $node->right;
            } elseif ($cmp < 0) {
                $node = $node->left;
            } else { // 相等
                $node->key = $key;
                $oldValue = $node->value;
                $node->value = $value;
                return $oldValue;
            }
        } while ($node !== null);

        // 看看插入到父节点的哪个位置
        $newNode = new TreeNode($key, $value, $parent);
        if ($cmp > 0) {
            $parent->right = $newNode;
        } else {
            $parent->left = $newNode;
        }
        $this->size++;

        // 新添加节点之后的处理
        // 修复红黑树的性质
        $this->afterPut($newNode);
        return null;
    }

    /**
     * 根据键获取对应的值
     *
     * @param int $key 要查找的键
     * @return ?string 与键关联的值，如果不存在则返回null
     */
    public function get(int $key): ?string
    {
        $node = $this->node($key);
        return $node !== null ? $node->value : null;
    }

    /**
     * 删除指定键的键值对
     *
     * @param int $key 要删除的键
     * @return ?string 被删除的值，如果不存在则返回null
     */
    public function remove(int $key): ?string
    {
        return $this->removeNode($this->node($key));
    }

    /**
     * 判断映射是否包含指定的键
     *
     * @param int $key 要检查的键
     * @return bool 如果映射包含该键则返回true，否则返回false
     */
    public function containsKey(int $key): bool
    {
        return $this->node($key) !== null;
    }

    /**
     * 判断映射是否包含指定的值
     *
     * @param ?string $value 要检查的值
     * @return bool 如果映射包含该值则返回true，否则返回false
     */
    public function containsValue(?string $value): bool
    {
        if ($this->root === null) {
            return false;
        }

        $queue = new \SplQueue();
        $queue->enqueue($this->root);

        while (!$queue->isEmpty()) {
            $node = $queue->dequeue();
            if ($value === $node->value) {
                return true;
            }

            if ($node->left !== null) {
                $queue->enqueue($node->left);
            }

            if ($node->right !== null) {
                $queue->enqueue($node->right);
            }
        }

        return false;
    }

    /**
     * 遍历映射中的所有元素
     */
    public function traversal(Visitor $visitor): void
    {
        $this->doTraversal($this->root, $visitor);
    }

    /**
     * 使用中序遍历访问红黑树节点
     * 通常我们期望通过TreeMap获取按顺序排列的元素
     *
     * @param ?TreeNode $node 当前访问的节点
     */
    private function doTraversal(?TreeNode $node, Visitor $visitor): void
    {
        if ($node === null || $visitor->stop) {
            return;
        }

        $this->doTraversal($node->left, $visitor);
        if ($visitor->stop) {
            return;
        }
        $visitor->stop = $visitor->visit($node->key, $node->value);
        $this->doTraversal($node->right, $visitor);
    }

    /**
     * 删除红黑树节点
     *
     * @param ?TreeNode $node 要删除的节点
     * @return ?string 删除节点关联的值
     */
    private function removeNode(?TreeNode $node): ?string
    {
        if ($node === null) {
            return null;
        }

        $this->size--;

        $oldValue = $node->value;

        if ($node->hasTwoChildren()) { // 度为2的节点
            // 找到后继节点
            $s = $this->successor($node);
            // 用后继节点的值覆盖度为2的节点的值
            $node->key = $s->key;
            $node->value = $s->value;
            // 删除后继节点
            $node = $s;
        }

        // 删除node节点（node的度必然是1或者0）
        $replacement = $node->left ?? $node->right;

        if ($replacement !== null) { // node是度为1的节点
            // 更改parent
            $replacement->parent = $node->parent;
            // 更改parent的left、right的指向
            if ($node->parent === null) { // node是度为1的节点并且是根节点
                $this->root = $replacement;
            } else if ($node === $node->parent->left) {
                $node->parent->left = $replacement;
            } else { // node == node->parent->right
                $node->parent->right = $replacement;
            }

            // 删除节点之后的处理
            $this->afterRemove($replacement);
        } else if ($node->parent === null) { // node是叶子节点并且是根节点
            $this->root = null;
        } else { // node是叶子节点，但不是根节点
            if ($node === $node->parent->left) {
                $node->parent->left = null;
            } else { // node == node->parent->right
                $node->parent->right = null;
            }

            // 删除节点之后的处理
            $this->afterRemove($node);
        }

        return $oldValue;
    }

    /**
     * 删除节点后，修复红黑树的性质
     *
     * @param TreeNode $node 删除或替换后的当前节点
     */
    private function afterRemove(TreeNode $node): void
    {
        // 如果删除的节点是红色
        // 或者 用以取代删除节点的子节点是红色
        if ($this->isRed($node)) {
            $this->black($node);
            return;
        }

        $parent = $node->parent;
        if ($parent === null) {
            return;
        }

        // 删除的是黑色叶子节点【下溢】
        // 判断被删除的node是左还是右
        $left = $parent->left === null || $node->isLeftChild();
        $sibling = $left ? $parent->right : $parent->left;
        if ($left) { // 被删除的节点在左边，兄弟节点在右边
            if ($this->isRed($sibling)) { // 兄弟节点是红色
                $this->black($sibling);
                $this->red($parent);
                $this->rotateLeft($parent);
                // 更换兄弟
                $sibling = $parent->right;
            }

            // 兄弟节点必然是黑色
            if (!$this->isRed($sibling->left) && !$this->isRed($sibling->right)) {
                // 兄弟节点没有1个红色子节点，父节点要向下跟兄弟节点合并
                $parentBlack = $this->isBlack($parent);
                $this->black($parent);
                $this->red($sibling);
                if ($parentBlack) {
                    $this->afterRemove($parent);
                }
            } else { // 兄弟节点至少有1个红色子节点，向兄弟节点借元素
                // 兄弟节点的左边是黑色，兄弟要先旋转
                if (!$this->isRed($sibling->right)) {
                    $this->rotateRight($sibling);
                    $sibling = $parent->right;
                }

                $this->color($sibling, $this->colorOf($parent));
                $this->black($sibling->right);
                $this->black($parent);
                $this->rotateLeft($parent);
            }
        } else { // 被删除的节点在右边，兄弟节点在左边
            if ($this->isRed($sibling)) { // 兄弟节点是红色
                $this->black($sibling);
                $this->red($parent);
                $this->rotateRight($parent);
                // 更换兄弟
                $sibling = $parent->left;
            }

            // 兄弟节点必然是黑色
            if (!$this->isRed($sibling->left) && !$this->isRed($sibling->right)) {
                // 兄弟节点没有1个红色子节点，父节点要向下跟兄弟节点合并
                $parentBlack = $this->isBlack($parent);
                $this->black($parent);
                $this->red($sibling);
                if ($parentBlack) {
                    $this->afterRemove($parent);
                }
            } else { // 兄弟节点至少有1个红色子节点，向兄弟节点借元素
                // 兄弟节点的左边是黑色，兄弟要先旋转
                if (!$this->isRed($sibling->left)) {
                    $this->rotateLeft($sibling);
                    $sibling = $parent->left;
                }

                $this->color($sibling, $this->colorOf($parent));
                $this->black($sibling->left);
                $this->black($parent);
                $this->rotateRight($parent);
            }
        }
    }

    /**
     * 获取红黑树的前驱节点
     *
     * @param TreeNode $node 当前节点
     * @return ?TreeNode 返回前驱节点
     */
    private function predecessor(TreeNode $node): ?TreeNode
    {
        if ($node === null) {
            return null;
        }

        // 前驱节点在左子树当中（left.right.right.right....）
        $p = $node->left;
        if ($p !== null) {
            while ($p->right !== null) {
                $p = $p->right;
            }
            return $p;
        }

        // 从父节点、祖父节点中寻找前驱节点
        while ($node->parent !== null && $node === $node->parent->left) {
            $node = $node->parent;
        }

        // node.parent == null
        // node == node.parent.right
        return $node->parent;
    }

    /**
     * 获取红黑树后继节点
     *
     * @param TreeNode $node 当前节点
     * @return ?TreeNode 返回后继节点
     */
    private function successor(TreeNode $node): ?TreeNode
    {
        if ($node === null) {
            return null;
        }

        // 前驱节点在左子树当中（right.left.left.left....）
        $p = $node->right;
        if ($p !== null) {
            while ($p->left !== null) {
                $p = $p->left;
            }
            return $p;
        }

        // 从父节点、祖父节点中寻找前驱节点
        while ($node->parent !== null && $node === $node->parent->right) {
            $node = $node->parent;
        }

        return $node->parent;
    }

    /**
     * 根据key获取到红黑树的节点
     *
     * @param int $key 要查找的键
     * @return ?TreeNode 返回红黑树的节点
     */
    private function node(int $key): ?TreeNode
    {
        $node = $this->root;
        while ($node !== null) {
            $cmp = $this->compare($key, $node->key);
            if ($cmp === 0) {
                return $node;
            }
            if ($cmp > 0) {
                $node = $node->right;
            } else { // cmp < 0
                $node = $node->left;
            }
        }
        return null;
    }

    /**
     * 添加之后的操作，修复红黑树的性质
     *
     * @param TreeNode $node 新添加的节点
     */
    private function afterPut(TreeNode $node): void
    {
        $parent = $node->parent;

        // 添加的是根节点 或者 上溢到达了根节点
        if ($parent === null) {
            $this->black($node);
            return;
        }

        // 如果父节点是黑色，直接返回
        if ($this->isBlack($parent)) {
            return;
        }

        // 叔父节点
        $uncle = $parent->sibling();
        // 祖父节点
        $grand = $this->red($parent->parent);
        if ($this->isRed($uncle)) { // 叔父节点是红色【B树节点上溢】
            $this->black($parent);
            $this->black($uncle);
            // 把祖父节点当做是新添加的节点
            $this->afterPut($grand);
            return;
        }

        // 叔父节点不是红色
        if ($parent->isLeftChild()) { // L
            if ($node->isLeftChild()) { // LL
                $this->black($parent);
            } else { // LR
                $this->black($node);
                $this->rotateLeft($parent);
            }
            $this->rotateRight($grand);
        } else { // R
            if ($node->isLeftChild()) { // RL
                $this->black($node);
                $this->rotateRight($parent);
            } else { // RR
                $this->black($parent);
            }
            $this->rotateLeft($grand);
        }
    }

    /**
     * 左旋转
     *
     * @param TreeNode $grand 需要左旋的节点的祖父节点
     */
    private function rotateLeft(TreeNode $grand): void
    {
        $parent = $grand->right;
        $child = $parent->left;
        $grand->right = $child;
        $parent->left = $grand;
        $this->afterRotate($grand, $parent, $child);
    }

    /**
     * 右旋转
     *
     * @param TreeNode $grand 需要右旋的节点的祖父节点
     */
    private function rotateRight(TreeNode $grand): void
    {
        $parent = $grand->left;
        $child = $parent->right;
        $grand->left = $child;
        $parent->right = $grand;
        $this->afterRotate($grand, $parent, $child);
    }

    /**
     * 旋转之后的处理
     * 修复grand，parent，child之间的父子关系
     *
     * @param TreeNode $grand  旋转前的祖父节点
     * @param TreeNode $parent 旋转后的子树根节点
     * @param TreeNode $child  子节点
     */
    private function afterRotate(TreeNode $grand, TreeNode $parent, ?TreeNode $child): void
    {
        // 让parent称为子树的根节点
        $parent->parent = $grand->parent;
        if ($grand->isLeftChild()) {
            $grand->parent->left = $parent;
        } else if ($grand->isRightChild()) {
            $grand->parent->right = $parent;
        } else { // grand是root节点
            $this->root = $parent;
        }

        // 更新child的parent
        if ($child !== null) {
            $child->parent = $grand;
        }

        // 更新grand的parent
        $grand->parent = $parent;
    }

    /**
     * 设置节点颜色
     *
     * @param TreeNode $node  节点
     * @param bool $color 颜色
     * @return TreeNode 返回设置颜色后的节点
     */
    private function color(TreeNode $node, bool $color): TreeNode
    {
        $node->color = $color;
        return $node;
    }

    /**
     * 将节点设为红色
     *
     * @param TreeNode $node 节点
     * @return TreeNode 返回红色的节点
     */
    private function red(TreeNode $node): TreeNode
    {
        return $this->color($node, self::RED);
    }

    /**
     * 将节点设为黑色
     *
     * @param TreeNode $node 节点
     * @return TreeNode 返回黑色的节点
     */
    private function black(TreeNode $node): TreeNode
    {
        return $this->color($node, self::BLACK);
    }

    /**
     * 获取节点的颜色
     *
     * @param ?TreeNode $node 节点
     * @return bool 返回节点的颜色
     */
    private function colorOf(?TreeNode $node): bool
    {
        return $node === null ? self::BLACK : $node->color;
    }

    /**
     * 判断节点是否为黑色
     *
     * @param ?TreeNode $node 节点
     * @return bool 如果节点为黑色返回true，否则返回false
     */
    private function isBlack(?TreeNode $node): bool
    {
        return $this->colorOf($node) === self::BLACK;
    }

    /**
     * 判断节点是否为红色
     *
     * @param ?TreeNode $node 节点
     * @return bool 如果节点为红色返回true，否则返回false
     */
    private function isRed(?TreeNode $node): bool
    {
        return $this->colorOf($node) === self::RED;
    }

    /**
     * 比较两个键的大小
     *
     * @param int $e1 第一个键
     * @param int $e2 第二个键
     * @return int 返回e1和e2比较的结果
     */
    private function compare(int $e1, int $e2): int
    {
        return $e1 <=> $e2;
    }

    /**
     * 检查键是否为空
     *
     * @param int $key 键
     */
    private function checkKey(int $key): void
    {
        if ($key === null) {
            throw new InvalidArgumentException("key must not be null");
        }
    }
}
