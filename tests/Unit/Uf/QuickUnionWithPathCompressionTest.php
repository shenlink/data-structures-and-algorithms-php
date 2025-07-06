<?php

declare(strict_types=1);

namespace Tests\Unit\Uf;

use Shenlink\Algorithms\Uf\QuickUnionWithPathCompression;

/**
 * QuickUnionWithPathCompression 测试类
 */
final class QuickUnionWithPathCompressionTest extends UnionFindTest
{
    /**
     * 初始化一个新的 QuickUnionWithPathCompression 实例
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->uf = new QuickUnionWithPathCompression($this->capacity);
    }
}
