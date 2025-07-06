<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Set;

use Shenlink\Algorithms\Lists\SingleLinkedList;
use Shenlink\Algorithms\Lists\IList;

/**
 * 基于线性表实现的集合。
 * 可以保证遍历时按照元素添加的顺序进行访问。
 */
class ListSet implements Set
{
    /**
     * 内部使用的线性表，用于存储集合元素。
     */
    private IList $list;

    /**
     * ListSet constructor.
     */
    public function __construct()
    {
        $this->list = new SingleLinkedList();
    }

    /**
     * 清空集合中的所有元素。
     */
    public function clear(): void
    {
        $this->list->clear();
    }

    /**
     * 获取集合中元素的数量。
     *
     * @return int 当前集合中元素的数量
     */
    public function size(): int
    {
        return $this->list->size();
    }

    /**
     * 判断集合是否为空。
     *
     * @return bool 如果集合没有元素则返回 true
     */
    public function isEmpty(): bool
    {
        return $this->list->isEmpty();
    }

    /**
     * 判断集合是否包含指定元素。
     *
     * @param int $element 要查找的元素
     * @return bool 如果集合中存在该元素则返回 true
     */
    public function contains(int $element): bool
    {
        return $this->list->contains($element);
    }

    /**
     * 向集合中添加一个元素。
     * 如果元素已存在，则更新该元素的值；否则将新元素添加到列表末尾。
     *
     * @param int $element 要添加的元素
     */
    public function add(int $element): void
    {
        if ($this->list->contains($element)) {
            $this->list->set($this->list->indexOf($element), $element);
        } else {
            $this->list->add($element);
        }
    }

    /**
     * 删除集合中的指定元素。
     *
     * @param int $element 要删除的元素
     */
    public function remove(int $element): void
    {
        if ($this->list->contains($element)) {
            $this->list->remove($this->list->indexOf($element));
        }
    }

    /**
     * 遍历集合中的所有元素。
     * 按照插入顺序依次处理每个元素，并打印到控制台。
     *
     * @param Visitor<int> $visitor 访问者对象
     */
    public function traversal(Visitor $visitor): void
    {
        if ($visitor === null) {
            return;
        }

        for ($i = 0; $i < $this->list->size(); $i++) {
            $element = $this->list->get($i);
            if ($visitor->visit($element) || $visitor->stop) {
                return;
            }
        }
    }
}
