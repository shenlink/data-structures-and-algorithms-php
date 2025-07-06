<?php

declare(strict_types=1);

namespace Tests\Unit\Set;

use Shenlink\Algorithms\Set\TreeSet;

/**
 * TreeSet 测试类，继承自 SetTest
 */
final class TreeSetTest extends SetTest
{
    /**
     * 初始化测试所需的集合实例
     */
    public function setUp(): void
    {
        $this->set = new TreeSet();
    }
}
