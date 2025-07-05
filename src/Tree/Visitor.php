<?php

namespace Shenlink\Algorithms\Tree;

/**
 * 抽象访问者类，用于遍历二叉树元素
 */
abstract class Visitor
{
    /**
     * 停止遍历标志
     * 当该属性为 true 时，遍历操作应当停止
     */
    public bool $stop = false;
    /**
     * 访问的元素列表
     * @var array<int>
     */
    public array $results = [];

    /**
     * 获取访问的元素列表
     * 
     * @return array<int> 返回访问的元素列表
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * 访问指定元素
     * 
     * @param int $element 要访问的元素
     * @return bool 返回 true 停止遍历，返回 false 则继续遍历
     */
    abstract public function visit(int $element): bool;
}
