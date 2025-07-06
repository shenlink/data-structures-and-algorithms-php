<?php

declare(strict_types=1);

namespace Tests\Unit\Uf;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Uf\UnionFind;

/**
 * UnionFindTest 是一个抽象基类，用于测试各种 UnionFind 实现。
 */
abstract class UnionFindTest extends TestCase
{
    /**
     * 测试使用的默认容量
     */
    protected int $capacity = 11;

    /**
     * 被测试的 UnionFind 实例
     */
    protected UnionFind $uf;

    /**
     * 测试 find 方法
     */
    public function testFind(): void
    {
        $this->uf->union(0, 1);
        $this->uf->union(0, 3);
        $this->uf->union(0, 4);
        $this->uf->union(2, 3);
        $this->uf->union(2, 5);
        $this->uf->union(6, 7);
        $this->uf->union(8, 10);
        $this->uf->union(9, 10);
        self::assertFalse($this->uf->isConnected(2, 7));
        $this->uf->union(4, 6);
        self::assertTrue($this->uf->isConnected(2, 7));
    }

    /**
     * 测试 union 方法
     */
    public function testUnion(): void
    {
        $this->uf->union(0, 1);
        $this->uf->union(0, 3);
        $this->uf->union(0, 4);
        $this->uf->union(2, 3);
        $this->uf->union(2, 5);
        $this->uf->union(6, 7);
        $this->uf->union(8, 10);
        $this->uf->union(9, 10);
        self::assertFalse($this->uf->isConnected(2, 7));
        $this->uf->union(4, 6);
        self::assertTrue($this->uf->isConnected(2, 7));
    }

    /**
     * 测试 isConnected 方法
     */
    public function testIsConnected(): void
    {
        $this->uf->union(0, 1);
        $this->uf->union(0, 3);
        $this->uf->union(0, 4);
        $this->uf->union(2, 3);
        $this->uf->union(2, 5);
        $this->uf->union(6, 7);
        $this->uf->union(8, 10);
        $this->uf->union(9, 10);
        self::assertFalse($this->uf->isConnected(2, 7));
        $this->uf->union(4, 6);
        self::assertTrue($this->uf->isConnected(2, 7));
    }
}
