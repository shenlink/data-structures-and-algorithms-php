<?php

declare(strict_types=1);

namespace Tests\Unit\Strings;

use Shenlink\Algorithms\Strings\KMPBasic;

/**
 * KMP 算法实现测试类
 * 用于验证 KMPBasic 算法的正确性
 */
class KMPBasicTest extends AbstractMatchTest
{
    /**
     * 初始化 KMPBasic 实例
     */
    public function setUp(): void
    {
        $this->match = new KMPBasic();
    }
}
