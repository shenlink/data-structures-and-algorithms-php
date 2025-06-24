<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 选择排序实现类
 * 每轮将最大的元素放在最后
 */
class SelectionSort extends Sort
{
    /**
     * 执行选择排序的具体逻辑。
     *
     * 排序过程分为以下几个步骤：
     * 1. 控制每轮比较的结束位置，初始为数组最后一个索引，之后每次减少一个索引；
     * 2. 每轮找出当前未排序部分的最大元素并将其放置在正确位置；
     * 3. 使用 maxIndex 变量记录最大元素的位置，通过交换操作完成排序。
     */
    protected function sortInternal(): void
    {
        for ($end = count($this->elements) - 1; $end > 0; $end--) {
            $maxIndex = 0;

            for ($begin = 0; $begin <= $end; $begin++) {
                if ($this->compareByIndex($maxIndex, $begin) < 0) {
                    $maxIndex = $begin;
                }
            }

            $this->swap($maxIndex, $end);
        }
    }
}
