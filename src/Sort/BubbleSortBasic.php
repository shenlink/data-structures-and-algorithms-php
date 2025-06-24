<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 冒泡排序实现类
 * 该排序算法通过重复遍历要排序的列表，比较相邻元素并交换位置以达到排序目的。
 */
class BubbleSortBasic extends Sort
{
    /**
     * 执行冒泡排序的具体逻辑。
     * 每一轮将最大的元素“冒泡”到数组末尾。
     *
     * 排序过程：
     * - 控制每轮比较的结束位置，初始为数组最后一个索引，之后每次减少一个索引
     * - 从索引 1 开始，依次与前一个元素比较，若顺序错误则交换位置
     */
    public function sortInternal(): void
    {
        // 冒泡排序是执行n - 1轮，每轮将最大的元素放在最后
        // 这里确定每一轮的最后一次交换位置
        // 第一轮是elements.length - 1，之后每轮的交换位置减1
        for ($end = count($this->elements) - 1; $end > 0; $end--) {
            // 从 1 到 end 进行比较，如果前一个元素大于后一个元素，则交换位置
            for ($begin = 1; $begin <= $end; $begin++) {
                if ($this->compareByIndex($begin, $begin - 1) < 0) {
                    $this->swap($begin, $begin - 1);
                }
            }
        }
    }
}
