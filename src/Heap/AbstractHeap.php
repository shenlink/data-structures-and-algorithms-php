<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Heap;

use Shenlink\Algorithms\Utils\Comparator;

/**
 * 抽象的堆实现，提供堆操作的基础功能
 */
abstract class AbstractHeap implements Heap
{
    /**
     * 堆里面元素的个数
     */
    protected int $size = 0;

    /**
     * 元素比较器，默认为null，此时使用元素的自然顺序进行比较
     */
    protected ?Comparator $comparator = null;

    /**
     * 使用指定比较器构造一个抽象堆
     *
     * @param ?Comparator $comparator 用于比较堆中元素的比较器
     */
    public function __construct(?Comparator $comparator = null)
    {
        $this->comparator = $comparator;
    }

    /**
     * 获取堆中的元素数量
     *
     * @return int 堆中元素的数量
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * 判断堆是否为空
     *
     * @return bool 如果堆为空则返回 true，否则返回 false
     */
    public function isEmpty(): bool
    {
        return $this->size === 0;
    }

    /**
     * 比较两个元素的顺序
     *
     * @param int $e1 第一个元素
     * @param int $e2 第二个元素
     * @return int 比较结果：负值表示 e1 小于 e2，零表示相等，正值表示 e1 大于 e2
     */
    protected function compare(int $e1, int $e2): int
    {
        if ($this->comparator !== null) {
            return $this->comparator->compare($e1, $e2);
        }
        return $e1 <=> $e2;
    }
}
