<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 冒泡排序基础版的另一种实现
 * 该实现同样完成基本冒泡排序功能，但采用了不同的内部逻辑。
 */
class BubbleSortBasicAlt extends Sort
{
    /**
     * 使用另一种方式实现基础冒泡排序。
     * 每轮遍历将最大的元素“冒泡”到数组末尾。
     */
    protected function sortInternal(): void
    {
        for ($i = 0; $i < count($this->elements) - 1; $i++) {
            // 每次遍历减少一个元素，因为最后一个元素已经到位
            for ($j = 0; $j < count($this->elements) - 1 - $i; $j++) {
                if ($this->compareByIndex($j, $j + 1) > 0) {
                    $this->swap($j, $j + 1);
                }
            }
        }
    }
}
