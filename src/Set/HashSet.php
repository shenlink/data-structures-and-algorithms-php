<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Set;

use Shenlink\Algorithms\Map\HashMap;
use Shenlink\Algorithms\Map\Map;
use Shenlink\Algorithms\Set\Visitor;

/**
 * 哈希集合实现类。
 * 该集合基于 HashMap 实现，仅使用键存储元素，值为占位对象。
 *
 * @template E
 */
class HashSet implements Set
{
    /**
     * 内部使用的哈希映射，键用于存储集合元素，值为占位对象。
     */
    private Map $map;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->map = new HashMap();
    }

    /**
     * 清空集合中的所有元素。
     */
    public function clear(): void
    {
        $this->map->clear();
    }

    /**
     * 返回当前集合中元素的数量。
     *
     * @return int 集合中元素的数量
     */
    public function size(): int
    {
        return $this->map->size();
    }

    /**
     * 检查集合是否为空。
     *
     * @return bool 如果集合没有元素则返回 true
     */
    public function isEmpty(): bool
    {
        return $this->map->isEmpty();
    }

    /**
     * 判断集合中是否包含指定元素。
     *
     * @param int $element 要查找的元素
     * @return bool 如果集合中存在该元素则返回 true
     */
    public function contains(int $element): bool
    {
        return $this->map->containsKey($element);
    }

    /**
     * 向集合中添加一个元素。
     *
     * @param int $element 要添加的元素
     */
    public function add(int $element): void
    {
        $this->map->put($element, null);
    }

    /**
     * 从集合中删除指定的元素。
     *
     * @param int $element 要删除的元素
     */
    public function remove(int $element): void
    {
        $this->map->remove($element);
    }

    /**
     * 遍历集合中的所有元素。
     *
     * @param Visitor $visitor 访问器，用于处理每个元素
     */
    public function traversal(Visitor $visitor): void
    {
        if ($visitor === null) {
            return;
        }

        $this->map->traversal(new class($visitor) extends MapVisitor {
            public function visit(int $key, ?string $value): bool
            {
                if ($this->visitor->visit($key) || $this->visitor->stop) {
                    return true;
                }
                return false;
            }
        });
    }
}
