<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 排序抽象类，定义排序的基本操作和通用方法。
 * 子类需实现具体的排序算法。
 */
abstract class Sort
{
    /**
     * 待排序的整数数组
     *
     * @var array<int>
     */
    protected array $elements;

    /**
     * 对指定的元素数组进行排序。
     * 如果数组为 null 或长度小于 2，则无需排序直接返回。
     *
     * @param array<int> $elements 待排序的整数数组
     */
    public function sort(array &$elements): void
    {
        if (empty($elements) || count($elements) < 2) {
            return;
        }
        $this->elements = $elements;
        $this->sortInternal();
        $elements = $this->elements;
    }

    /**
     * 抽象排序方法，子类必须实现具体的排序逻辑。
     */
    abstract protected function sortInternal(): void;

    /**
     * 交换两个指定索引位置的元素。
     *
     * @param int $i 第一个元素的索引
     * @param int $j 第二个元素的索引
     */
    protected function swap(int $i, int $j): void
    {
        $temp = $this->elements[$i];
        $this->elements[$i] = $this->elements[$j];
        $this->elements[$j] = $temp;
    }

    /**
     * 比较两个索引位置上的元素。
     *
     * @param int $i1 第一个元素的索引
     * @param int $i2 第二个元素的索引
     * @return int 比较结果：-1 表示 i1 处元素小于 i2 处元素，0 表示相等，1 表示大于
     */
    protected function compareByIndex(int $i1, int $i2): int
    {
        return $this->elements[$i1] <=> $this->elements[$i2];
    }

    /**
     * 比较两个元素的大小。
     *
     * @param int $e1 第一个元素
     * @param int $e2 第二个元素
     * @return int 比较结果：-1 表示 e1 小于 e2，0 表示相等，1 表示大于
     */
    protected function compare(int $e1, int $e2): int
    {
        return $e1 <=> $e2;
    }
}
