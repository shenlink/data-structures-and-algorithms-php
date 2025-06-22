<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 基于单向链表实现的栈数据结构
 * 该类利用 {@link SingleLinkedList} 作为底层容器，提供高效的栈操作实现
 * 支持常见的栈操作
 */
class LinkedListStack extends AbstractStack
{
    public function __construct()
    {
        $this->list = new SingleLinkedList();
    }
}
