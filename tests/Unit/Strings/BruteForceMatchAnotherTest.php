<?php

declare(strict_types=1);

namespace Tests\Unit\Strings;

use Shenlink\Algorithms\Strings\BruteForceMatchAnother;

/**
 * 暴力匹配算法第二种实现测试类
 * 用于验证 BruteForceMatchAnother 算法的正确性
 */
class BruteForceMatchAnotherTest extends AbstractMatchTest
{
    /**
     * 初始化 BruteForceMatchAnother 实例
     */
    public function setUp(): void
    {
        $this->match = new BruteForceMatchAnother();
    }
}
