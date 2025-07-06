<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Set;

/**
 * Map访问器类
 *
 * 该类继承自 Map 的 Visitor 类，用于在 Map 实现的集合中的遍历操作。
 */
abstract class MapVisitor extends \Shenlink\Algorithms\Map\Visitor
{
    /**
     * 访问器实例
     *
     * @var Visitor $visitor 用于遍历 Map 的访问器对象
     */
    public Visitor $visitor;

    /**
     * 构造函数
     *
     * 初始化一个新的 MapVisitor 实例，并传入一个访问器对象。
     *
     * @param Visitor $visitor 用于遍历 Map 的访问器对象
     */
    public function __construct(Visitor $visitor)
    {
        $this->visitor = $visitor;
    }
}
