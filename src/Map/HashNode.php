<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Map;

/**
 * 哈希表节点类
 */
class HashNode
{
    /**
     * 键的哈希码
     */
    public int $hash;

    /**
     * 存储的键
     */
    public int $key;

    /**
     * 存储的值
     */
    public ?string $value;

    /**
     * 节点的颜色（RED 或 BLACK）
     */
    public bool $color = false; // RED=false

    /**
     * 左子节点
     */
    public ?HashNode $left = null;

    /**
     * 右子节点
     */
    public ?HashNode $right = null;

    /**
     * 父节点
     */
    public ?HashNode $parent = null;

    /**
     * 构造一个新的节点。
     *
     * @param int $key 键
     * @param ?string $value 值
     * @param ?HashNode $parent 父节点
     */
    public function __construct(int $key, ?string $value, ?HashNode $parent)
    {
        $this->key = $key;
        $this->hash = $this->calculateHash($key);
        $this->value = $value;
        $this->parent = $parent;
    }

    /**
     * 计算键的哈希值
     *
     * @param int $key 键
     * @return int 哈希值
     */
    private function calculateHash(int $key): int
    {
        $hash = $key;
        return $hash ^ ($hash >> 16);
    }

    /**
     * 判断该节点是否有两个子节点。
     *
     * @return bool 如果左右子节点都存在则返回 true，否则返回 false
     */
    public function hasTwoChildren(): bool
    {
        return $this->left !== null && $this->right !== null;
    }

    /**
     * 判断该节点是否是左子节点。
     *
     * @return bool 如果当前节点是其父节点的左子节点则返回 true，否则返回 false
     */
    public function isLeftChild(): bool
    {
        return $this->parent !== null && $this === $this->parent->left;
    }

    /**
     * 判断该节点是否是右子节点。
     *
     * @return bool 如果当前节点是其父节点的右子节点则返回 true，否则返回 false
     */
    public function isRightChild(): bool
    {
        return $this->parent !== null && $this === $this->parent->right;
    }

    /**
     * 获取兄弟节点。
     *
     * @return HashNode|null 当前节点的兄弟节点
     */
    public function sibling(): ?HashNode
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
     * 返回节点的字符串表示。
     *
     * @return string 节点的字符串形式，格式为 "key-value"
     */
    public function toString(): string
    {
        return $this->key . '-' . $this->value;
    }
}
