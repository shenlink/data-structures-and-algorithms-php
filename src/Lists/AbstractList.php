<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

use OutOfBoundsException;
use Shenlink\Algorithms\Lists\IList;

/**
 * 抽取线性表重复的操作，为具体的线性表实现类提供基础功能的通用实现。
 */
abstract class AbstractList implements IList
{
    /**
     * 找不到元素返回的索引值。
     *
     * @var int
     */
    protected const ELEMENT_NOT_FOUND = -1;

    /**
     * 元素数量。
     *
     * @var int
     */
    protected int $size = 0;

    /**
     * 返回当前元素的数量。
     *
     * @return int 元素个数
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * 检查线性表是否为空。
     *
     * @return bool 如果线性表没有元素则返回 true
     */
    public function isEmpty(): bool
    {
        return $this->size === 0;
    }

    /**
     * 判断线性表中是否包含指定元素。
     *
     * @param int $element 要查找的元素
     * @return bool 如果找到元素则返回 true
     */
    public function contains(int $element): bool
    {
        return $this->indexOf($element) !== self::ELEMENT_NOT_FOUND;
    }

    /**
     * 将元素添加到线性表尾部。
     *
     * @param int $element 要添加的元素
     */
    public function add(int $element): void
    {
        $this->addAt($this->size, $element);
    }

    /**
     * 确认索引没有越界。
     *
     * @param int $index 要检查的索引位置
     * @throws OutOfBoundsException 如果索引超出有效范围
     */
    protected function checkIndex(int $index): void
    {
        if ($index < 0 || $index >= $this->size) {
            $this->outOfBounds($index);
        }
    }

    /**
     * 针对添加操作，确认索引没有越界，添加操作可以在线性表的最后位置添加元素。
     *
     * @param int $index 要检查的索引位置
     * @throws OutOfBoundsException 如果索引超出有效范围
     */
    protected function checkIndexForAdd(int $index): void
    {
        if ($index < 0 || $index > $this->size) {
            $this->outOfBounds($index);
        }
    }

    /**
     * 抛出索引越界异常。
     *
     * @param int $index 请求访问的位置
     * @throws OutOfBoundsException 带有详细信息的异常
     */
    protected function outOfBounds(int $index): void
    {
        throw new OutOfBoundsException("Index: {$index}, Size: {$this->size}");
    }
}
