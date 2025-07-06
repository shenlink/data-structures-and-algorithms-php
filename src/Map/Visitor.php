<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Map;

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
     * @var array<string>
     */
    public array $results = [];

    /**
     * 获取访问的元素列表
     * 
     * @return array<string> 返回访问的元素列表
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * 访问指定键值对
     *
     * @param int $key 元素对应的键
     * @param string $value 元素对应的值
     * @return bool 返回 true 停止遍历，返回 false 则继续遍历
     */
    abstract public function visit(int $key, string $value): bool;
}
