<?php

declare(strict_types=1);

namespace Tests\Unit\Map;

use Tests\Unit\Map\MapTest;
use Shenlink\Algorithms\Map\HashMap;
use Shenlink\Algorithms\Map\Visitor;

/**
 * HashMap 测试类，继承自 MapTest
 * 用于验证 HashMap 实现类的基本功能和正确性
 */
final class HashMapTest extends MapTest
{
    /**
     * 初始化 HashMap 实例
     * 在每次测试方法执行前调用，用于准备测试环境
     */
    public function setUp(): void
    {
        $this->map = new HashMap();
    }

    /**
     * 测试遍历映射内容的方法
     */
    public function testTraversal(): void
    {
        $this->map->put(1, "one");
        $this->map->put(2, "two");
        $this->map->put(3, "three");

        $visitor = new class extends Visitor {
            public function visit(int $key, ?string $value): bool
            {
                $this->results[] = "$key-$value";
                return false;
            }
        };

        $this->map->traversal($visitor);

        $results = $visitor->getResults();

        // 检查遍历结果中包含所有的键值对
        $this->assertTrue(in_array("1-one", $results, true));
        $this->assertTrue(in_array("2-two", $results, true));
        $this->assertTrue(in_array("3-three", $results, true));

        // 确保结果大小一致
        self::assertCount(3, $results);
    }
}
