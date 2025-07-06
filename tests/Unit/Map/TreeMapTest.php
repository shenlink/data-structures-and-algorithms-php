<?php

declare(strict_types=1);

namespace Tests\Unit\Map;

use Shenlink\Algorithms\Map\TreeMap;

/**
 * TreeMap 测试类，继承自 MapTest
 * 用于验证 TreeMap 实现类的基本功能和正确性
 */
class TreeMapTest extends MapTest
{
    /**
     * 创建 TreeMap 实例
     */
    public function setUp(): void
    {
        $this->map = new TreeMap();
    }
}
