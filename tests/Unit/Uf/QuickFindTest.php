<?php

declare(strict_types=1);

namespace Tests\Unit\Uf;

use Shenlink\Algorithms\Uf\QuickFind;

/**
 * QuickFind 测试类
 */
final class QuickFindTest extends UnionFindTest
{
    /**
     * 初始化一个新的 QuickFind 实例
     */
    public function setUp(): void
    {
        $this->uf = new QuickFind($this->capacity);
    }
}
