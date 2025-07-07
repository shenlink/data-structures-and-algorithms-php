<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Trie;

/**
 * 表示字典树中的一个节点。
 */
class StandardTrieNode
{
    /**
     * 父节点
     */
    public ?StandardTrieNode $parent;

    /**
     * 子节点映射：字符 -> 节点
     *
     * @var array<string, StandardTrieNode>
     */
    public array $children = [];

    /**
     * 当前节点对应的字符
     */
    public ?string $character = null;

    /**
     * 当前节点存储的值
     */
    public ?string $value = null;

    /**
     * 标记当前节点是否为一个完整单词的结尾
     */
    public bool $isWord = false;

    /**
     * 构造一个新的节点。
     *
     * @param ?StandardTrieNode $parent 父节点
     */
    public function __construct(?StandardTrieNode $parent)
    {
        $this->parent = $parent;
    }
}
