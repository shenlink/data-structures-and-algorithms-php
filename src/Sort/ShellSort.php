<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Sort;

/**
 * 希尔排序实现类
 *
 * 希尔排序是插入排序的一种高效率的改进版本，它通过比较相距一定步长的元素来工作，
 * 经过多次步长比较，最终步长降为1，进行常规的插入排序，从而使得数组有序。
 * 该算法在处理大规模乱序数据时，相较于简单的插入排序有显著的性能提升。
 */
class ShellSort extends Sort
{
    /**
     * 对数组进行希尔排序
     *
     * 该方法通过生成一个步长序列（getStepSequence），然后依次使用每个步长对数组进行分组排序。
     * 每次排序根据当前步长将数组划分为多个子序列，并对每个子序列执行插入排序。
     * 随着步长逐渐减小，最后一步会使用步长为1的插入排序完成整体排序。
     */
    protected function sortInternal(): void
    {
        foreach ($this->getStepSequence() as $step) {
            $this->shellSort($step);
        }
    }

    /**
     * 使用希尔排序算法对数组进行排序
     * 
     * 希尔排序的核心思想是：将原本大量移动插入排序操作分解为多个小规模插入排序，
     * 每次排序间隔一定的步长，逐步减小步长，直到步长为1时完成最后的插入排序。
     * 
     * @param int $step 步长值
     */
    private function shellSort(int $step): void
    {
        for ($col = 0; $col < $step; $col++) {
            for ($begin = $col + $step; $begin < count($this->elements); $begin += $step) {
                $current = $begin;
                $v = $this->elements[$begin];

                while ($current > $col && $v < $this->elements[$current - $step]) {
                    $this->elements[$current] = $this->elements[$current - $step];
                    $current -= $step;
                }

                $this->elements[$current] = $v;
            }
        }
    }

    /**
     * 获取步长序列（从大到小）。
     * 步长序列的选择会影响希尔排序的效率。本方法使用的是最基础的二分法生成步长序列：
     * 即每次将数组长度除以2，直到步长为1。
     *
     * @return array<int> 步长序列
     */
    private function getStepSequence(): array
    {
        $steps = [];
        $step = (int)(count($this->elements) >> 1);

        while ($step > 0) {
            $steps[] = $step;
            $step >>= 1;
        }

        return $steps;
    }
}
