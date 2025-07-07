<?php

declare(strict_types=1);

namespace Tests\Unit\Strings;

use Shenlink\Algorithms\Strings\BruteForceMatchPro;

/**
 * 优化的暴力匹配算法测试类
 * 用于验证 BruteForceMatchPro 算法的正确性
 */
class BruteForceMatchProTest extends AbstractMatchTest
{
    /**
     * 初始化 BruteForceMatchPro 实例
     */
    public function setUp(): void
    {
        $this->match = new BruteForceMatchPro();
    }
}
