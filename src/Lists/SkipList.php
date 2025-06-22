<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

use InvalidArgumentException;

/**
 * 跳表实现
 * 提供了基于跳表的数据存储结构
 */
class SkipList
{
    /**
     * 默认的最大层数
     * @var int
     */
    private const DEFAULT_MAX_LEVEL = 32;

    /**
     * 默认的概率，用于生成随机层数
     * @var float
     */
    private const DEFAULT_PROBABILITY = 0.5;

    /**
     * 跳表中的节点数量
     */
    private int $size = 0;

    /**
     * 跳表的有效层数
     */
    private int $level = 0;

    /**
     * 跳表的头节点
     */
    private ?SkipListNode $head;

    /**
     * 构造函数，初始化跳表
     */
    public function __construct()
    {
        // 默认给头节点最大层数
        $this->head = new SkipListNode(0, "", self::DEFAULT_MAX_LEVEL);
    }

    /**
     * 清空跳表所有元素
     */
    public function clear(): void
    {
        $this->head = null;
        $this->size = 0;
        $this->level = 0;
    }

    /**
     * 获取跳表中存储的元素数量
     *
     * @return int 元素数量
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * 检查跳表是否为空
     *
     * @return bool 如果跳表没有元素则返回 true，否则返回 false
     */
    public function isEmpty(): bool
    {
        return $this->size === 0;
    }

    /**
     * 根据键获取对应的值
     *
     * @param int $key 要查找的键
     * @return ?string 对应的值，如果不存在则返回 null
     * @throws InvalidArgumentException 如果键为 null
     */
    public function get(int $key): ?string
    {
        // 需要返回的节点，初始值是 head
        $node = $this->head;
        // 比较结果
        $cmp = -1;
        // 注意：需要从有效层数开始往下比较，因为层数是从1开始计算的，但是实际的编码中最低层的层数是0，
        // 所以要从 level - 1 层开始遍历
        for ($i = $this->level - 1; $i >= 0; $i--) {
            // 默认比较结果
            $cmp = -1;
            // 如果下一个节点不为 null，且 key 大于下一个节点，则更新 node 为下一个节点
            while ($node->nexts[$i] !== null && ($cmp = $this->compare($key, $node->nexts[$i]->key)) > 0) {
                // 更新 node 为下一个节点
                $node = $node->nexts[$i];
            }
            // 注意：此时不能返回 node.value，因为上面比较的是 key 与 node.nexts[i].key 的值，
            // 所以 cmp == 0 时，要返回 node.nexts[i].value
            // 如果 key == 下一个节点的值，则返回下一个节点的值
            if ($cmp === 0) {
                return $node->nexts[$i]->value;
            }
        }
        return null;
    }

    /**
     * 添加或更新跳表节点
     * 如果键已存在则覆盖值，否则插入新节点
     *
     * @param int $key   要添加的键
     * @param string $value 要添加的值
     * @return ?string 如果键已存在返回旧值，否则返回 null
     * @throws InvalidArgumentException 如果键为 null
     */
    public function put(int $key, string $value): ?string
    {
        // 被覆盖的节点
        $node = $this->head;
        // 保存要添加的节点的前驱节点
        $prevs = [];
        // 比较结果
        $cmp = -1;
        // 注意：需要从有效层数开始往下比较，因为层数是从1开始计算的，但是实际的编码中最低层的层数是0，
        // 所以要从 level - 1 层开始遍历
        for ($i = $this->level - 1; $i >= 0; $i--) {
            // 比较结果
            $cmp = -1;
            // 如果下一个节点不为 null，且 key 大于下一个节点，则更新 node 为下一个节点
            while ($node->nexts[$i] !== null && ($cmp = $this->compare($key, $node->nexts[$i]->key)) > 0) {
                // 更新 node 为下一个节点
                $node = $node->nexts[$i];
            }
            // 找到了要添加的 key 所在的节点
            if ($cmp === 0) {
                // 保留该节点的 value，用于返回
                $oldValue = $node->nexts[$i]->value;
                // 更新该节点的 value
                $node->nexts[$i]->value = $value;
                // 返回旧值
                return $oldValue;
            }
            // 来到这里，有 2 种可能：
            // 1. node.nexts[i] == null，说明新创建的节点应该是要插入到跳表的最后，此时的 node 就是最后一个非 null 节点
            // 2. cmp < 0，则说明 node.nexts[i].value 是大于 key 的，那 node 就是在当前层 i 最后一个小于 key 的节点
            // 保存当前层的前驱节点，用于后续链接新节点
            $prevs[$i] = $node;
        }
        // 随机生成层数
        $newLevel = $this->randomLevel();
        // 生成新的节点
        $newSkipListNode = new SkipListNode($key, $value, $newLevel);
        // 生成的层数 newLevel 跟之前的有效层数 level 比较，有 2 种情况：
        // 1. newLevel - 1 >= level，则需要从 newLevel - 1 到 level 层，都需要更新 head 的 nexts[i]
        // 2. newLevel - 1 < level，不需要处理 level 的更新
        for ($i = $newLevel - 1; $i >= 0; $i--) {
            // i 大于等于 level 的这些层数对应的 head.next[i] 之前指向的都是 null，需要更新，改为指向 newSkipListNode
            if ($i >= $this->level) {
                $this->head->nexts[$i] = $newSkipListNode;
            } else {
                // 注意：这里的添加与链表的添加有异曲同工之妙，只是换到跳表这里，需要维护 nexts[i]
                // newSkipListNode 的 next[i] 指向的是 prevs[i].nexts[i]
                $newSkipListNode->nexts[$i] = $prevs[$i]->nexts[$i];
                // prevs[i] 指向的是 newSkipListNode
                $prevs[$i]->nexts[$i] = $newSkipListNode;
            }
        }
        $this->size++;
        // 更新有效层数
        $this->level = max($this->level, $newLevel);
        return null;
    }

    /**
     * 删除指定键的节点
     *
     * @param int $key 要删除的键
     * @return ?string 被删除节点的值，如果键不存在则返回 null
     * @throws InvalidArgumentException 如果键为 null
     */
    public function remove(int $key): ?string
    {
        // 要删除的节点
        $node = $this->head;
        // 保存要删除的节点的前驱节点
        $prevs = [];
        // 要删除的节点是否存在，默认不存在
        $exist = false;
        // 比较结果
        $cmp = -1;
        for ($i = $this->level - 1; $i >= 0; $i--) {
            while ($node->nexts[$i] !== null && ($cmp = $this->compare($key, $node->nexts[$i]->key)) > 0) {
                $node = $node->nexts[$i];
            }
            // 要删除的节点存在
            if ($cmp === 0) {
                $exist = true;
            }
            // 要删除的节点的前驱节点，保存有层数 i
            $prevs[$i] = $node;
        }
        // 要删除的节点不存在，直接返回 null
        if (!$exist) {
            return null;
        }

        // 注意：这里是 node.nexts[0]，因为只有 nexts[0] 是确认不会数组越界的
        $removedSkipListNode = $node->nexts[0];
        $this->size--;
        // 类似于链表的删除，只是这里要维护 nexts[i]
        for ($i = 0; $i < count($removedSkipListNode->nexts); $i++) {
            $prevs[$i]->nexts[$i] = $removedSkipListNode->nexts[$i];
        }
        // 更新有效层数
        $newLevel = $this->level;
        // newLevel - 1 后，如果 head.nexts[newLevel] == null，则说明 newLevel 层已经没有数据了，需要更新 level
        while (--$newLevel >= 0 && $this->head->nexts[$newLevel] === null) {
            $this->level = $newLevel;
        }
        // 返回被删除的节点的 value
        return $removedSkipListNode->value;
    }

    /**
     * 比较两个键的大小
     *
     * @param int $k1 第一个键
     * @param int $k2 第二个键
     * @return int 比较结果，0 表示相等，-1 表示 k1 小于 k2，1 表示 k1 大于 k2
     */
    private function compare(int $k1, int $k2): int
    {
        return $k1 <=> $k2;
    }

    /**
     * 生成随机的层数
     *
     * @return int 随机生成的层数
     */
    private function randomLevel(): int
    {
        $level = 1;
        while (mt_rand(0, 1) < self::DEFAULT_PROBABILITY && $level < self::DEFAULT_MAX_LEVEL) {
            $level++;
        }
        return $level;
    }
}
