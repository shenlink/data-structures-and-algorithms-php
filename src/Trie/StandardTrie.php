<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Trie;

use InvalidArgumentException;

/**
 * 字典树（Trie）实现，也称为前缀树。
 * 用于高效存储和检索键值对，特别适合处理字符串集合的操作。
 */
class StandardTrie
{
    /**
     * 字典树中节点的总数量
     */
    private int $size = 0;

    /**
     * 字典树的根节点
     */
    private ?StandardTrieNode $root = null;

    /**
     * 清空字典树的所有数据。
     */
    public function clear(): void
    {
        $this->size = 0;
        $this->root = null;
    }

    /**
     * 获取字典树中存储的节点总数。
     *
     * @return int 节点数量
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * 判断字典树是否为空。
     *
     * @return bool 如果字典树为空则返回 true，否则返回 false
     */
    public function isEmpty(): bool
    {
        return $this->size === 0;
    }

    /**
     * 根据指定的键获取对应的值。
     *
     * @param ?string $key 键
     * @return string|null 对应的值，如果键不存在或不是一个完整单词，则返回 null
     */
    public function get(?string $key): ?string
    {
        $node = $this->node($key);
        return $node !== null && $node->isWord ? $node->value : null;
    }

    /**
     * 检查字典树中是否包含指定的键。
     *
     * @param ?string $key 键
     * @return bool 如果包含该键且其是一个完整单词则返回 true，否则返回 false
     */
    public function contains(?string $key): bool
    {
        $node = $this->node($key);
        return $node !== null && $node->isWord;
    }

    /**
     * 向字典树中添加一个键值对。
     *
     * @param ?string $key 键
     * @param string $value 值
     * @return string|null 如果键已存在，则返回旧值；否则返回 null
     */
    public function add(?string $key, string $value): ?string
    {
        $this->checkKey($key);

        if ($this->root === null) {
            $this->root = new StandardTrieNode(null);
        }

        $node = $this->root;
        $len = strlen($key);

        for ($i = 0; $i < $len; $i++) {
            $c = $key[$i];
            $childrenIsEmpty = $node->children === null;
            $childNode = $childrenIsEmpty ? null : ($node->children[$c] ?? null);

            if ($childNode === null) {
                $childNode = new StandardTrieNode($node);
                $childNode->character = $c;
                $node->children = $childrenIsEmpty ? [] : $node->children;
                $node->children[$c] = $childNode;
            }

            $node = $childNode;
        }

        if ($node->isWord) {
            $oldValue = $node->value;
            $node->value = $value;
            return $oldValue;
        }

        $node->isWord = true;
        $node->value = $value;
        $this->size++;
        return null;
    }

    /**
     * 从字典树中删除指定的键。
     *
     * @param ?string $key 键
     * @return string|null 如果键存在，则返回其对应的值；否则返回 null
     */
    public function remove(?string $key): ?string
    {
        $node = $this->node($key);

        if ($node === null || !$node->isWord) {
            return null;
        }

        $this->size--;
        $oldValue = $node->value;

        if ($node->children !== null && !empty($node->children)) {
            $node->value = null;
            $node->isWord = false;
            return $oldValue;
        }

        $parent = null;

        while (($parent = $node->parent) !== null) {
            unset($parent->children[$node->character]);

            if (!empty($parent->children) || $parent->isWord) {
                break;
            }

            $node = $parent;
        }

        return $oldValue;
    }

    /**
     * 判断字典树中是否存在以指定前缀开头的键。
     *
     * @param ?string $prefix 前缀
     * @return bool 如果存在以该前缀开头的键则返回 true，否则返回 false
     */
    public function startsWith(?string $prefix): bool
    {
        return $this->node($prefix) !== null;
    }

    /**
     * 查找与给定键匹配的最后一个节点。
     *
     * @param ?string $key 键
     * @return ?StandardTrieNode 匹配的节点，如果没有找到则返回 null
     */
    private function node(?string $key): ?StandardTrieNode
    {
        $this->checkKey($key);
        $node = $this->root;
        $len = strlen($key);

        for ($i = 0; $i < $len; $i++) {
            if ($node === null || $node->children === null || empty($node->children)) {
                return null;
            }

            $c = $key[$i];
            $node = $node->children[$c] ?? null;
        }

        return $node;
    }

    /**
     * 检查键是否有效（非空且非空字符串）。
     *
     * @param ?string $key 要检查的键
     * @throws InvalidArgumentException 如果键无效
     */
    private function checkKey(?string $key): void
    {
        if ($key === null || $key === "") {
            throw new InvalidArgumentException("key must not be empty");
        }
    }
}
