<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 跳表节点类
 */
class SkipListNode
{
    /**
     * 节点的键
     */
    public int $key;

    /**
     * 节点的值
     */
    public string $value;

    /**
     * 指向各层下一个节点的指针数组
     * @var array<int, ?SkipListNode>
     */
    public array $nexts = [];

    /**
     * 创建一个新的跳表节点
     *
     * @param int $key   节点的键
     * @param string $value 节点的值
     * @param int $level 节点的层数
     */
    public function __construct(int $key, string $value, int $level)
    {
        $this->key = $key;
        $this->value = $value;
        for ($i = 0; $i < $level; $i++) {
            $this->nexts[$i] = null;
        }
    }
}
