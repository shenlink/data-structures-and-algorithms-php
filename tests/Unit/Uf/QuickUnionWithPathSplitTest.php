<?php

declare(strict_types=1);

namespace Tests\Unit\Uf;

use Shenlink\Algorithms\Uf\QuickUnionWithPathSplit;

/**
 * QuickUnionWithPathSplit 测试类
 */
final class QuickUnionWithPathSplitTest extends UnionFindTest
{
    /**
     * 初始化一个新的 QuickUnionWithPathSplit 实例
     */
    public function setUp(): void
    {
        $this->uf = new QuickUnionWithPathSplit($this->capacity);
    }
}
