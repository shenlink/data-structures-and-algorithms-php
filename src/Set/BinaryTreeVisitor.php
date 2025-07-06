<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Set;

/**
 * 二叉树访问器类
 *
 * 该类继承自 Visitor 类，用于实现在 BinaryTree 实现的集合中的遍历操作。
 */
abstract class BinaryTreeVisitor extends \Shenlink\Algorithms\Tree\Visitor
{
    /**
     * 访问器实例
     *
     * @var Visitor $visitor 用于遍历集合的访问器对象
     */
    public Visitor $visitor;

    /**
     * 构造函数
     *
     * 初始化一个新的 BinaryTreeVisitor 实例，并传入一个访问器对象。
     *
     * @param Visitor $visitor 用于遍历集合的访问器对象
     */
    public function __construct(Visitor $visitor)
    {
        $this->visitor = $visitor;
    }
}
