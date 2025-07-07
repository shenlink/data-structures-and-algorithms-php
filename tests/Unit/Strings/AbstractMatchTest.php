<?php

declare(strict_types=1);

namespace Tests\Unit\Strings;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Strings\IMatch;

/**
 * 字符串匹配算法测试基类 - 定义了通用的字符串匹配测试框架和验证方法
 */
abstract class AbstractMatchTest extends TestCase
{
    /**
     * 被测试的字符串匹配实现对象
     */
    protected IMatch $match;

    /**
     * 测试 indexOf 方法的正确性
     * 包含多种边界情况和常规情况的测试用例
     */
    public function testIndexOf(): void
    {
        $this->assertEquals(-1, $this->match->indexOf("", ""));
        $this->assertEquals(-1, $this->match->indexOf("", "a"));
        $this->assertEquals(-1, $this->match->indexOf("a", ""));
        $this->assertEquals(0, $this->match->indexOf("a", "a"));
        $this->assertEquals(0, $this->match->indexOf("ab", "ab"));
        $this->assertEquals(0, $this->match->indexOf("abc", "abc"));
        $this->assertEquals(1, $this->match->indexOf("abc", "bc"));
        $this->assertEquals(2, $this->match->indexOf("abc", "c"));
    }
}
