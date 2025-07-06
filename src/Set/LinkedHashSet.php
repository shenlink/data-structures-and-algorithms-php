<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Set;

use Shenlink\Algorithms\Map\LinkedHashMap;
use Shenlink\Algorithms\Map\Map;
use Shenlink\Algorithms\Set\Visitor;

/**
 * 顺序哈希集合实现类。
 * 基于 LinkedHashMap 实现，能够保证遍历顺序与元素插入顺序一致。
 */
class LinkedHashSet implements Set
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
        $this->map = new LinkedHashMap();
    }

    /**
     * 清空集合中的所有元素。
     */
    public function clear(): void
    {
        $this->map->clear();
    }

    /**
     * 获取集合元素个数。
     *
     * @return int 当前集合中元素的数量
     */
    public function size(): int
    {
        return $this->map->size();
    }

    /**
     * 判断集合是否为空。
     *
     * @return bool 如果集合没有元素则返回 true
     */
    public function isEmpty(): bool
    {
        return $this->map->isEmpty();
    }

    /**
     * 是否包含某个元素。
     *
     * @param mixed $element 要查找的元素
     * @return bool 如果集合中存在该元素则返回 true
     */
    public function contains($element): bool
    {
        return $this->map->containsKey($element);
    }

    /**
     * 添加元素到集合中。
     *
     * @param mixed $element 要添加的元素
     */
    public function add($element): void
    {
        $this->map->put($element, null);
    }

    /**
     * 删除集合中的指定元素。
     *
     * @param mixed $element 要删除的元素
     */
    public function remove($element): void
    {
        $this->map->remove($element);
    }

    /**
     * 遍历集合。
     * 使用访问器对集合中的每一个元素进行处理。
     *
     * @param Visitor $visitor 元素访问器
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
