<?php

declare(strict_types=1);

namespace Tests\Unit\Uf;

use Shenlink\Algorithms\Uf\QuickUnion;

/**
 * QuickUnion 测试类
 */
final class QuickUnionTest extends UnionFindTest
{
    /**
     * 初始化一个新的 QuickUnion 实例
     */
    public function setUp(): void
    {
        $this->uf = new QuickUnion($this->capacity);
    }
}
