<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Map;

use SplQueue;

/**
 * 哈希表实现，基于红黑树处理冲突。
 */
class HashMap implements Map
{
    /**
     * 红色节点标识常量，值为 false。
     * 
     * @var bool
     */
    protected const RED = false;

    /**
     * 黑色节点标识常量，值为 true。
     * 
     * @var bool
     */
    protected const BLACK = true;

    /**
     * table 数组的默认容量，默认为 16。
     * 
     * @var int
     */
    protected const DEFAULT_CAPACITY = 16;

    /**
     * 负载因子，默认值为 0.75。
     * 当元素数量超过负载因子乘以数组长度时，进行扩容。
     * 
     * @var float
     */
    protected const DEFAULT_LOAD_FACTOR = 0.75;

    /**
     * 当前哈希表中键值对的数量
     */
    protected int $size = 0;

    /**
     * 哈希表的桶数组，每个元素指向一个红黑树的根节点
     * @var array<?HashNode>
     */
    protected array $table;

    /**
     * 默认构造函数，使用默认的容量初始化哈希表。
     */
    public function __construct()
    {
        $this->table = array_fill(0, self::DEFAULT_CAPACITY, null);
    }

    /**
     * 清空哈希表中的所有键值对。
     */
    public function clear(): void
    {
        if ($this->size === 0) {
            return;
        }
        // 清空table数组
        for ($i = 0; $i < count($this->table); $i++) {
            $this->table[$i] = null;
        }
        $this->size = 0;
    }

    /**
     * 获取哈希表中键值对的数量。
     *
     * @return int 哈希表中键值对的数量
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * 判断哈希表是否为空。
     *
     * @return bool 如果哈希表中没有键值对则返回 true
     */
    public function isEmpty(): bool
    {
        return $this->size === 0;
    }

    /**
     * 将指定键映射到指定值。
     *
     * @param int $key 要插入的键
     * @param ?string $value 要插入的值
     * @return ?string 与键关联的旧值，如果没有则返回 null
     */
    public function put(int $key, ?string $value): ?string
    {
        // 保证容量
        $this->resize();

        // 计算出key所在的table数组的索引
        $index = $this->indexForKey($key);
        // 获取根节点
        $root = $this->table[$index];
        // 根节点为空，直接添加根节点
        if ($root === null) {
            $this->table[$index] = $this->createNode($key, $value, null);
            $this->size++;
            // 修复红黑树的性质
            $this->fixAfterPut($this->table[$index]);
            return null;
        }

        $parent = $root;
        $node = $root;
        $cmp = 0;
        $k1 = $key;
        $h1 = $this->hash($k1);
        $result = null;
        $searched = false;
        // 在红黑树中寻找合适节点的流程：
        do {
            $parent = $node;
            $k2 = $node->key;
            $h2 = $node->hash;
            if ($h1 > $h2) {
                $cmp = 1;
            } elseif ($h1 < $h2) {
                $cmp = -1;
            } elseif ($k1 === $k2) {
                $cmp = 0;
            } elseif ($cmp = $k1 <=> $k2) {
                // 整数直接比较
            } elseif ($searched) {
                $cmp = $k1 - $k2; // 整数直接相减
            } else {
                if (($node->left !== null && ($result = $this->findNode($node->left, $k1)) !== null) ||
                    ($node->right !== null && ($result = $this->findNode($node->right, $k1)) !== null)
                ) {
                    $node = $result;
                    $cmp = 0;
                } else {
                    $searched = true;
                    $cmp = $k1 - $k2; // 整数直接相减
                }
            }

            if ($cmp > 0) {
                $node = $node->right;
            } elseif ($cmp < 0) {
                $node = $node->left;
            } else {
                $oldValue = $node->value;
                $node->key = $key;
                $node->hash = $h1;
                $node->value = $value;
                return $oldValue;
            }
        } while ($node !== null);

        $newNode = new HashNode($key, $value, $parent);
        if ($cmp > 0) {
            $parent->right = $newNode;
        } else {
            $parent->left = $newNode;
        }
        $this->size++;

        $this->fixAfterPut($newNode);
        return null;
    }

    /**
     * 通过键获取对应的值。
     *
     * @param int $key 要查找的键
     * @return ?string 对应的值，如果没有找到则返回 null
     */
    public function get(int $key): ?string
    {
        $node = $this->node($key);
        return $node !== null ? $node->value : null;
    }

    /**
     * 删除指定键对应的键值对。
     *
     * @param int $key 要删除的键
     * @return ?string 与键关联的值，如果没有找到则返回 null
     */
    public function remove(int $key): ?string
    {
        return $this->removeNode($this->node($key));
    }

    /**
     * 判断哈希表是否包含指定的键。
     *
     * @param int $key 要检查的键
     * @return bool 如果哈希表包含该键则返回 true
     */
    public function containsKey(int $key): bool
    {
        return $this->node($key) !== null;
    }

    /**
     * 判断哈希表是否包含指定的值。
     *
     * @param ?string $value 要检查的值
     * @return bool 如果哈希表包含该值则返回 true
     */
    public function containsValue(?string $value): bool
    {
        if ($this->size === 0) {
            return false;
        }

        // 对table数组中的所有的红黑树进行层序遍历
        $queue = new SplQueue();

        for ($i = 0; $i < count($this->table); $i++) {
            if ($this->table[$i] === null) {
                continue;
            }

            $queue->enqueue($this->table[$i]);
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
        }
        return false;
    }

    /**
     * 遍历哈希表中的所有键值对。
     * 使用层序遍历的方式输出每个节点的信息。
     *
     * @param Visitor $visitor 访问者对象
     */
    public function traversal(Visitor $visitor): void
    {
        if ($this->size === 0 || $visitor === null) {
            return;
        }
        for ($i = 0; $i < count($this->table); $i++) {
            if ($this->table[$i] === null) {
                continue;
            }

            $queue = new SplQueue();
            $queue->enqueue($this->table[$i]);
            while (!$queue->isEmpty()) {
                $node = $queue->dequeue();
                if ($visitor->visit($node->key, $node->value) || $visitor->stop) {
                    return;
                }

                if ($node->left !== null) {
                    $queue->enqueue($node->left);
                }
                if ($node->right !== null) {
                    $queue->enqueue($node->right);
                }
            }
        }
    }

    /**
     * 创建一个新的节点
     *
     * @param int $key 要存储的键
     * @param ?string $value 要存储的值
     * @param ?HashNode $parent 父节点
     * @return HashNode 新创建的节点
     */
    protected function createNode(int $key, ?string $value, ?HashNode $parent): HashNode
    {
        return new HashNode($key, $value, $parent);
    }

    /**
     * 移除节点后的调整操作
     *
     * @param ?HashNode $replaceNode 原先被删除的节点，因为度为2，使用后继节点来替代
     * @param ?HashNode $removedNode 实际被删除的节点
     */
    protected function afterRemove(?HashNode $replaceNode, ?HashNode $removedNode): void {}

    /**
     * 扩容方法，当元素数量超过负载因子乘以数组长度时调用。
     * 该方法会创建一个新的两倍大小的桶数组，
     * 并将原有桶数组中的所有节点重新分布到新的桶数组中。
     */
    private function resize(): void
    {
        if ((float)$this->size / count($this->table) <= self::DEFAULT_LOAD_FACTOR) {
            return;
        }

        $oldTable = $this->table;
        $this->table = array_fill(0, count($oldTable) << 1, null);
        $queue = new SplQueue();
        for ($i = 0; $i < count($oldTable); $i++) {
            if ($oldTable[$i] === null) {
                continue;
            }
            $queue->enqueue($oldTable[$i]);
            while (!$queue->isEmpty()) {
                $node = $queue->dequeue();
                if ($node->left !== null) {
                    $queue->enqueue($node->left);
                }
                if ($node->right !== null) {
                    $queue->enqueue($node->right);
                }
                $this->moveNode($node);
            }
        }
    }

    /**
     * 移动节点，可以当成是添加节点
     *
     * @param HashNode $newNode 要移动的节点
     */
    private function moveNode(HashNode $newNode): void
    {
        $newNode->parent = null;
        $newNode->left = null;
        $newNode->right = null;
        $newNode->color = self::RED;

        $index = $this->indexForNode($newNode);
        $root = $this->table[$index];
        if ($root === null) {
            $root = $newNode;
            $this->table[$index] = $root;
            $this->fixAfterPut($root);
            return;
        }

        $parent = $root;
        $node = $root;
        $cmp = 0;
        $k1 = $newNode->key;
        $h1 = $newNode->hash;
        do {
            $parent = $node;
            $k2 = $node->key;
            $h2 = $node->hash;
            if ($h1 > $h2) {
                $cmp = 1;
            } elseif ($h1 < $h2) {
                $cmp = -1;
            } elseif ($cmp = $k1 <=> $k2) {
                // 整数直接比较
            } else {
                $cmp = $k1 - $k2; // 整数直接相减
            }

            if ($cmp > 0) {
                $node = $node->right;
            } elseif ($cmp < 0) {
                $node = $node->left;
            }
        } while ($node !== null);
        $newNode->parent = $parent;
        if ($cmp > 0) {
            $parent->right = $newNode;
        } else {
            $parent->left = $newNode;
        }
        $this->fixAfterPut($newNode);
    }

    /**
     * 删除节点
     *
     * @param ?HashNode $node 要删除的节点
     * @return ?string 与节点关联的值，如果没有找到则返回 null
     */
    protected function removeNode(?HashNode $node): ?string
    {
        if ($node === null) {
            return null;
        }

        $originNode = $node;
        $this->size--;
        $oldValue = $node->value;
        if ($node->hasTwoChildren()) {
            $s = $this->successor($node);
            $node->key = $s->key;
            $node->value = $s->value;
            $node->hash = $s->hash;
            $node = $s;
        }

        $replacement = $node->left !== null ? $node->left : $node->right;
        $index = $this->indexForNode($node);
        if ($replacement !== null) {
            $replacement->parent = $node->parent;
            if ($node->parent === null) {
                $this->table[$index] = $replacement;
            } elseif ($node === $node->parent->left) {
                $node->parent->left = $replacement;
            } else {
                $node->parent->right = $replacement;
            }

            $this->fixAfterRemove($replacement);
        } elseif ($node->parent === null) {
            $this->table[$index] = null;
        } else {
            if ($node->parent->left === $node) {
                $node->parent->left = null;
            } else {
                $node->parent->right = null;
            }
            $this->fixAfterRemove($node);
        }

        $this->afterRemove($originNode, $node);

        return $oldValue;
    }

    /**
     * 查找指定节点的后继节点。
     * 后继节点定义为红黑树中大于当前节点的最小节点。
     * 如果当前节点有右子节点，则后继节点是右子树中最左边的节点；
     * 如果没有右子树，则从父节点向上查找，直到当前节点是其父节点的左子节点。
     *
     * @param HashNode $node 要查找后继节点的节点
     * @return ?HashNode 指定节点的后继节点
     */
    private function successor(HashNode $node): ?HashNode
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
     * 根据给定的键获取对应的节点
     * 此方法用于在散列表中查找特定的节点，如果找到则返回该节点，否则返回null
     * 它首先通过计算键的索引来定位散列表中的位置，然后调用内部方法node递归地搜索匹配的节点
     * 
     * @param int $key 要查找的键，用于定位节点
     * @return ?HashNode 返回找到的节点，如果未找到则返回null
     */
    private function node(int $key): ?HashNode
    {
        // 通过键获取散列表中的索引
        $root = $this->table[$this->indexForKey($key)];
        // 如果root为null，说明散列表中该索引处没有节点，返回null
        return $root === null ? null : $this->findNode($root, $key);
    }

    /**
     * 根据键查找对应的节点。
     *
     * @param HashNode $node 当前遍历的根节点
     * @param int $k1 要查找的键
     * @return ?HashNode 查找到的节点，如果不存在则返回 null
     */
    private function findNode(HashNode $node, int $k1): ?HashNode
    {
        $h1 = $this->hash($k1);
        $cmp = 0;
        $result = null;
        while ($node !== null) {
            $k2 = $node->key;
            $h2 = $node->hash;
            if ($h1 > $h2) {
                $node = $node->right;
            } elseif ($h1 < $h2) {
                $node = $node->left;
            } elseif ($k1 === $k2) {
                return $node;
            } elseif ($cmp = $k1 <=> $k2) {
                $node = $cmp > 0 ? $node->right : $node->left;
            } elseif ($node->right !== null && ($result = $this->findNode($node->right, $k1)) !== null) {
                return $result;
            } else {
                $node = $node->left;
            }
        }

        return null;
    }

    /**
     * 根据key生成对应的索引（在桶数组中的位置）
     *
     * @param int $key 要计算索引的键
     * @return int 键对应的索引位置
     */
    private function indexForKey(int $key): int
    {
        return $this->hash($key) & (count($this->table) - 1);
    }

    /**
     * 获取节点在桶数组中的索引位置
     *
     * @param HashNode $node 要计算索引的节点
     * @return int 节点对应的索引位置
     */
    private function indexForNode(HashNode $node): int
    {
        return $node->hash & (count($this->table) - 1);
    }

    /**
     * 计算键的哈希值
     *
     * @param int $key 要计算哈希值的键
     * @return int 键的哈希值
     */
    private function hash(int $key): int
    {
        $hash = $key;
        return $hash ^ ($hash >> 16);
    }

    /**
     * 删除后操作，修复红黑树的性质
     *
     * @param ?HashNode $node 被删除的节点
     */
    private function fixAfterRemove(?HashNode $node): void
    {
        if ($node === null) {
            return;
        }

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
            if ($this->isBlack($sibling?->left) && $this->isBlack($sibling?->right)) {
                // 兄弟节点没有1个红色子节点，父节点要向下跟兄弟节点合并
                $parentBlack = $this->isBlack($parent);
                $this->black($parent);
                $this->red($sibling);
                if ($parentBlack) {
                    $this->fixAfterRemove($parent);
                }
            } else { // 兄弟节点至少有1个红色子节点，向兄弟节点借元素
                // 兄弟节点的左边是黑色，兄弟要先旋转
                if ($this->isBlack($sibling->right)) {
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
            if ($this->isBlack($sibling?->left) && $this->isBlack($sibling?->right)) {
                // 兄弟节点没有1个红色子节点，父节点要向下跟兄弟节点合并
                $parentBlack = $this->isBlack($parent);
                $this->black($parent);
                $this->red($sibling);
                if ($parentBlack) {
                    $this->fixAfterRemove($parent);
                }
            } else { // 兄弟节点至少有1个红色子节点，向兄弟节点借元素
                // 兄弟节点的左边是黑色，兄弟要先旋转
                if ($this->isBlack($sibling->left)) {
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
     * 添加后操作，修复红黑树的性质
     *
     * @param HashNode $node 新添加的节点
     */
    private function fixAfterPut(HashNode $node): void
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
        if ($uncle !== null && $this->isRed($uncle)) { // 叔父节点是红色【B树节点上溢】
            $this->black($parent);
            $this->black($uncle);
            // 把祖父节点当做是新添加的节点
            $this->fixAfterPut($grand);
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
     * 左旋转操作。
     * 左旋转是指以某个节点作为旋转点，将其右子节点提升为新的父节点，
     * 原来的父节点变为新父节点的左子节点。
     * 该操作用于维护红黑树的平衡性。
     *
     * @param HashNode $grand 需要进行左旋转的原始父节点（祖父节点）
     */
    private function rotateLeft(HashNode $grand): void
    {
        // 获取原始父节点的右子节点，这是新的父节点
        $parent = $grand->right;
        // 获取新父节点的左子节点，这将是旧父节点的右子节点
        $child = $parent->left;

        // 将新父节点的左子节点赋予旧父节点的右子节点位置
        $grand->right = $child;
        // 将旧父节点设置为新父节点的左子节点
        $parent->left = $grand;

        // 调用afterRotate方法更新各个节点的父节点关系
        $this->afterRotate($grand, $parent, $child);
    }

    /**
     * 右旋转操作。
     * 右旋转是指以某个节点作为旋转点，将其左子节点提升为新的父节点，
     * 原来的父节点变为新父节点的右子节点。
     * 该操作用于维护红黑树的平衡性。
     *
     * @param HashNode $grand 需要进行右旋转的原始父节点（祖父节点）
     */
    private function rotateRight(HashNode $grand): void
    {
        // 获取原始父节点的左子节点，这是新的父节点
        $parent = $grand->left;
        // 获取新父节点的右子节点，这将是旧父节点的左子节点
        $child = $parent->right;

        // 将新父节点的右子节点赋予旧父节点的左子节点位置
        $grand->left = $child;
        // 将旧父节点设置为新父节点的右子节点
        $parent->right = $grand;

        // 调用afterRotate方法更新各个节点的父节点关系
        $this->afterRotate($grand, $parent, $child);
    }

    /**
     * 旋转后修复节点的父子关系。
     * 此方法处理旋转之后的节点连接，包括更新父节点与子节点的引用。
     *
     * @param HashNode $grand 原始祖父节点，在旋转后将成为子树的一部分
     * @param HashNode $parent 在旋转中成为新的父节点
     * @param ?HashNode $child 旋转过程中涉及的子节点，可能为 null
     */
    private function afterRotate(HashNode $grand, HashNode $parent, ?HashNode $child): void
    {
        // 让parent成为子树的根节点
        $parent->parent = $grand->parent;
        if ($grand->isLeftChild()) {
            $grand->parent->left = $parent;
        } elseif ($grand->isRightChild()) {
            $grand->parent->right = $parent;
        } else { // grand是root节点
            $this->table[$this->indexForNode($grand)] = $parent;
        }

        // 更新child的parent
        if ($child !== null) {
            $child->parent = $grand;
        }

        // 更新grand的parent
        $grand->parent = $parent;
    }

    /**
     * 设置节点的颜色
     * 
     * @param ?HashNode $node 待设置颜色的节点
     * @param bool $color 节点的新颜色
     * @return ?HashNode 返回颜色被设置颜色后的节点
     */
    private function color(?HashNode $node, bool $color): ?HashNode
    {
        if ($node === null) {
            return null;
        }
        $node->color = $color;
        return $node;
    }

    /**
     * 将节点设置为红色
     *
     * @param ?HashNode $node 要设置颜色的节点
     * @return ?HashNode 设置为红色后的节点
     */
    private function red(?HashNode $node): ?HashNode
    {
        return $this->color($node, self::RED);
    }

    /**
     * 将节点设置为黑色
     *
     * @param ?HashNode $node 要设置颜色的节点
     * @return ?HashNode 设置为黑色后的节点
     */
    private function black(?HashNode $node): ?HashNode
    {
        return $this->color($node, self::BLACK);
    }

    /**
     * 获取节点的颜色
     *
     * @param ?HashNode $node 要获取颜色的节点
     * @return bool 节点的颜色，如果节点为null则返回黑色
     */
    private function colorOf(?HashNode $node): bool
    {
        return $node === null ? self::BLACK : $node->color;
    }

    /**
     * 判断节点是否是黑色
     *
     * @param ?HashNode $node 要判断颜色的节点
     * @return bool 如果节点是黑色或null则返回true，否则返回false
     */
    private function isBlack(?HashNode $node): bool
    {
        return $this->colorOf($node) === self::BLACK;
    }

    /**
     * 判断节点是否是红色
     *
     * @param ?HashNode $node 要判断颜色的节点
     * @return bool 如果节点是红色则返回true，否则返回false
     */
    private function isRed(?HashNode $node): bool
    {
        return $this->colorOf($node) === self::RED;
    }
}
