<?php

declare(strict_types=1);

namespace Tests\Unit\Strings;

use Shenlink\Algorithms\Strings\KMPPro;

/**
 * KMP 优化算法测试类
 * 用于验证 KMPBasic 算法的正确性
 */
class KMPProTest extends AbstractMatchTest
{
    /**
     * 初始化 KMPBasic 实例
     */
    public function setUp(): void
    {
        $this->match = new KMPPro();
    }
}
