<?php

declare(strict_types=1);

namespace Tests\Unit\Uf;

use Shenlink\Algorithms\Uf\QuickUnionWithSize;

/**
 * QuickUnionWithSize 测试类
 */
final class QuickUnionWithSizeTest extends UnionFindTest
{
    /**
     * 初始化一个新的 QuickUnionWithSize 实例
     */
    public function setUp(): void
    {
        $this->uf = new QuickUnionWithSize($this->capacity);
    }
}
