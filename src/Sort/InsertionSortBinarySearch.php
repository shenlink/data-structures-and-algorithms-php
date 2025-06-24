<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 插入排序优化版
 * 使用二分查找确定插入位置以减少比较次数，同时采用赋值操作代替交换操作以提高性能
 */
class InsertionSortBinarySearch extends Sort
{
    /**
     * 对数组进行排序，采用双重优化插入排序算法。
     * 每轮将当前元素向前移动到合适位置，通过二分查找确定插入位置，
     * 减少不必要的比较操作，并采用赋值方式替代交换操作提升效率。
     */
    protected function sortInternal(): void
    {
        for ($begin = 1; $begin < count($this->elements); $begin++) {
            $this->insert($begin, $this->search($begin));
        }
    }

    /**
     * 将指定索引处的元素插入到目标索引位置。
     * 索引dest之后的元素都向后移动一位，在dest位置插入element。
     *
     * @param int $source 要插入的元素原始索引
     * @param int $dest   目标插入位置
     */
    private function insert(int $source, int $dest): void
    {
        $element = $this->elements[$source];

        for ($i = $source; $i > $dest; $i--) {
            $this->elements[$i] = $this->elements[$i - 1];
        }

        $this->elements[$dest] = $element;
    }

    /**
     * 二分搜索找到索引index所在元素的待插入位置。
     * 返回应该插入的位置索引。
     *
     * @param int $index 当前要插入的元素索引
     * @return int 待插入位置索引
     */
    private function search(int $index): int
    {
        $begin = 0;
        $end = $index;

        while ($begin < $end) {
            $mid = ($begin + $end) >> 1;

            if ($this->compareByIndex($index, $mid) < 0) {
                $end = $mid;
            } else {
                $begin = $mid + 1;
            }
        }

        return $begin;
    }
}
