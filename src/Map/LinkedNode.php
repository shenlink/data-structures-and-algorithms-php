<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Map;

/**
 * 表示 LinkedHashMap 中的节点，继承自 HashNode，
 * 并增加指向前一个和后一个节点的引用。
 */
class LinkedNode extends HashNode
{
    /**
     * 指向前一个节点
     */
    public ?LinkedNode $prev = null;

    /**
     * 指向后一个节点
     */
    public ?LinkedNode $next = null;

    /**
     * 构造一个新的 LinkedNode 节点。
     *
     * @param int $key 键
     * @param ?string $value 值
     * @param ?HashNode $parent 父节点（红黑树中的父节点）
     */
    public function __construct(int $key, ?string $value, ?HashNode $parent)
    {
        parent::__construct($key, $value, $parent);
    }
}
