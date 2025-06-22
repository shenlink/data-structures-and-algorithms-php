<?php

declare(strict_types=1);

namespace Tests\Unit\Lists;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Lists\SparseArray;
use Shenlink\Algorithms\Lists\SparseArrayEntry;

/**
 * 稀疏数组测试类
 * 测试稀疏数组的二维数据存储与访问功能
 */
class SparseArrayTest extends TestCase
{
    /**
     * 测试用的稀疏数组实例
     */
    private SparseArray $sparseArray;

    /**
     * 测试用的稀疏数组的行数
     * @var int
     */
    private const ROWS = 3;

    /**
     * 测试用的稀疏数组的列数
     * @var int
     */
    private const COLS = 3;

    /**
     * 测试用的稀疏数组的默认值
     * @var int
     */
    private const DEFAULT_VALUE = 0;

    /**
     * 初始化测试用的稀疏数组
     */
    protected function setUp(): void
    {
        $this->sparseArray = new SparseArray(self::ROWS, self::COLS, self::DEFAULT_VALUE);
    }

    /**
     * 测试初始大小
     */
    public function testInitialSize(): void
    {
        $this->assertSame(0, $this->sparseArray->size());
    }

    /**
     * 测试获取默认值的方法
     */
    public function testGetDefaultValue(): void
    {
        $this->assertSame(self::DEFAULT_VALUE, $this->sparseArray->getDefaultValue());
    }

    /**
     * 测试元素存储操作
     */
    public function testPut(): void
    {
        $row = 0;
        $col = 0;
        $value = 5;
        $this->sparseArray->put($row, $col, $value);

        $this->assertSame($value, $this->sparseArray->get($row, $col));
        $this->assertSame(1, $this->sparseArray->size());
    }

    /**
     * 测试元素获取操作
     */
    public function testGet(): void
    {
        $row = 0;
        $col = 0;
        $value = 5;
        $this->sparseArray->put($row, $col, $value);

        $this->assertSame($value, $this->sparseArray->get($row, $col));
        $this->assertSame(1, $this->sparseArray->size());
    }

    /**
     * 测试元素移除操作
     */
    public function testRemove(): void
    {
        $row = 1;
        $col = 1;
        $value = 7;
        $this->sparseArray->put($row, $col, $value);
        $this->sparseArray->remove($row, $col);

        $this->assertSame(self::DEFAULT_VALUE, $this->sparseArray->get($row, $col));
        $this->assertSame(0, $this->sparseArray->size());
    }

    /**
     * 测试清空所有元素操作
     */
    public function testClear(): void
    {
        $this->sparseArray->put(0, 0, 1);
        $this->sparseArray->put(1, 1, 2);
        $this->sparseArray->clear();

        $this->assertSame(0, $this->sparseArray->size());
        $this->assertSame(self::DEFAULT_VALUE, $this->sparseArray->get(0, 0));
    }

    /**
     * 测试检查键是否存在操作
     */
    public function testContainsKey(): void
    {
        $row = 2;
        $col = 2;
        $value = 9;
        $this->assertFalse($this->sparseArray->containsKey($row, $col));

        $this->sparseArray->put($row, $col, $value);
        $this->assertTrue($this->sparseArray->containsKey($row, $col));

        $this->sparseArray->remove($row, $col);
        $this->assertFalse($this->sparseArray->containsKey($row, $col));
    }

    /**
     * 测试获取所有键值对集合操作
     */
    public function testEntrySet(): void
    {
        $expectedEntries = [
            new SparseArrayEntry(0, 0, 1),
            new SparseArrayEntry(1, 1, 2),
            new SparseArrayEntry(2, 2, 3)
        ];

        foreach ($expectedEntries as $entry) {
            $this->sparseArray->put($entry->getRow(), $entry->getCol(), $entry->getValue());
        }

        $actualEntries = [];
        foreach ($this->sparseArray->entrySet() as $entry) {
            $actualEntries[] = $entry;
        }

        // 按照行和列排序
        usort($expectedEntries, function ($a, $b) {
            if ($a->getRow() === $b->getRow()) {
                return $a->getCol() <=> $b->getCol();
            }
            return $a->getRow() <=> $b->getRow();
        });

        usort($actualEntries, function ($a, $b) {
            if ($a->getRow() === $b->getRow()) {
                return $a->getCol() <=> $b->getCol();
            }
            return $a->getRow() <=> $b->getRow();
        });

        $this->assertEquals($expectedEntries, $actualEntries);
    }

    /**
     * 测试转换为稀疏数组格式操作
     */
    public function testToSparseArrayFormat(): void
    {
        $expected = [
            [self::ROWS, self::COLS, 2],
            [0, 0, 1],
            [1, 1, 2]
        ];

        $this->sparseArray->put(0, 0, 1);
        $this->sparseArray->put(1, 1, 2);

        $result = $this->sparseArray->toSparseArrayFormat();

        $this->assertNotNull($result);
        $this->assertCount(count($expected), $result);

        for ($i = 0; $i < count($expected); $i++) {
            $this->assertSame($expected[$i], $result[$i]);
        }
    }

    /**
     * 测试从稀疏数组格式恢复操作
     */
    public function testFromSparseArrayFormat(): void
    {
        $input = [
            [3, 3, 2],
            [0, 0, 10],
            [2, 2, 20]
        ];

        $this->sparseArray->fromSparseArrayFormat($input);

        $this->assertSame(3, $this->sparseArray->rows());
        $this->assertSame(3, $this->sparseArray->cols());
        $this->assertSame(2, $this->sparseArray->size());
        $this->assertSame(10, $this->sparseArray->get(0, 0));
        $this->assertSame(20, $this->sparseArray->get(2, 2));
        $this->assertSame(self::DEFAULT_VALUE, $this->sparseArray->get(1, 1));
    }

    /**
     * 测试获取行数操作
     */
    public function testRows(): void
    {
        $this->assertSame(self::ROWS, $this->sparseArray->rows());
    }

    /**
     * 测试获取列数操作
     */
    public function testCols(): void
    {
        $this->assertSame(self::COLS, $this->sparseArray->cols());
    }

    /**
     * 测试无效行索引访问异常处理
     */
    public function testInvalidRowAccess(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->sparseArray->get(-1, -1);
    }

    /**
     * 测试无效列索引访问异常处理
     */
    public function testInvalidColAccess(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->sparseArray->get(4, 4);
    }
}
