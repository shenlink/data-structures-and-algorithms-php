<?php

declare(strict_types=1);

namespace Tests\Unit\Strings;

use Shenlink\Algorithms\Strings\BruteForceMatchBasic;

/**
 * 暴力匹配算法第一种实现测试类
 * 用于验证 BruteForceMatchBasic 算法的正确性
 */
class BruteForceMatchBasicTest extends AbstractMatchTest
{
    /**
     * 初始化 BruteForceMatchBasic 实例
     */
    public function setUp(): void
    {
        $this->match = new BruteForceMatchBasic();
    }
}