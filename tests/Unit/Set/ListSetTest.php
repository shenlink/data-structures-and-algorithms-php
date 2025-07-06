<?php

declare(strict_types=1);

namespace Tests\Unit\Set;

use Shenlink\Algorithms\Set\ListSet;

/**
 * ListSet 测试类，继承自 SetTest
 */
final class ListSetTest extends SetTest
{
    /**
     * 初始化测试所需的集合实例
     */
    public function setUp(): void
    {
        $this->set = new ListSet();
    }
}
