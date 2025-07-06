<?php

declare(strict_types=1);

namespace Tests\Unit\Uf;

use Shenlink\Algorithms\Uf\QuickUnionWithRank;

/**
 * QuickUnionWithRank 测试类
 */
final class QuickUnionWithRankTest extends UnionFindTest
{
    /**
     * 初始化一个新的 QuickUnionWithRank 实例
     */
    public function setUp(): void
    {
        $this->uf = new QuickUnionWithRank($this->capacity);
    }
}
