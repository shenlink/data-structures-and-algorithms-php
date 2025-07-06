<?php

declare(strict_types=1);

namespace Tests\Unit\Uf;

use Shenlink\Algorithms\Uf\QuickUnionWithPathHalf;

/**
 * QuickUnionWithPathHalf 测试类
 */
final class QuickUnionWithPathHalfTest extends UnionFindTest
{
    /**
     * 初始化一个新的 QuickUnionWithPathHalf 实例
     */
    public function setUp(): void
    {
        $this->uf = new QuickUnionWithPathHalf($this->capacity);
    }
}
