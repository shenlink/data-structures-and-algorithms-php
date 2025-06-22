<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

use InvalidArgumentException;

/**
 * 稀疏数组实现
 * 用于存储大部分元素为默认值的二维数组
 */
class SparseArray
{
    /**
     * 存储数据的二维数组
     * @var int[][]
     */
    private array $data;

    /**
     * 行数
     */
    private int $rows;

    /**
     * 列数
     */
    private int $cols;

    /**
     * 默认值
     */
    private int $defaultValue;

    /**
     * 非默认值的数量
     */
    private int $size;

    /**
     * 创建一个新的稀疏数组
     *
     * @param int $rows 行数
     * @param int $cols 列数
     * @param int $defaultValue 默认值
     */
    public function __construct(int $rows, int $cols, int $defaultValue)
    {
        $this->rows = $rows;
        $this->cols = $cols;
        $this->defaultValue = $defaultValue;
        $this->data = [];

        // 初始化二维数组并填充默认值
        for ($i = 0; $i < $rows; $i++) {
            $row = [];
            for ($j = 0; $j < $cols; $j++) {
                $row[] = $defaultValue;
            }
            $this->data[] = $row;
        }

        $this->size = 0;
    }

    /**
     * 设置指定位置的值
     *
     * @param int $row 行索引
     * @param int $col 列索引
     * @param int $value 要设置的值
     */
    public function put(int $row, int $col, int $value): void
    {
        $this->validate($row, $col);

        if ($this->data[$row][$col] === $this->defaultValue) {
            $this->size++;
        }

        $this->data[$row][$col] = $value;
    }

    /**
     * 获取指定位置的值
     *
     * @param int $row 行索引
     * @param int $col 列索引
     * @return int 指定位置的值
     */
    public function get(int $row, int $col): int
    {
        $this->validate($row, $col);
        return $this->data[$row][$col];
    }

    /**
     * 删除指定位置的值（设置为默认值）
     *
     * @param int $row 行索引
     * @param int $col 列索引
     */
    public function remove(int $row, int $col): void
    {
        $this->validate($row, $col);

        if ($this->data[$row][$col] !== $this->defaultValue) {
            $this->size--;
        }

        $this->data[$row][$col] = $this->defaultValue;
    }

    /**
     * 清空所有非默认值
     */
    public function clear(): void
    {
        $this->data = [];

        for ($i = 0; $i < $this->rows; $i++) {
            $row = [];
            for ($j = 0; $j < $this->cols; $j++) {
                $row[] = $this->defaultValue;
            }
            $this->data[] = $row;
        }

        $this->size = 0;
    }

    /**
     * 获取当前存储的非默认值的数量
     *
     * @return int 非默认值的数量
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * 获取稀疏数组的默认值
     *
     * @return int 默认值
     */
    public function getDefaultValue(): int
    {
        return $this->defaultValue;
    }

    /**
     * 检查指定位置是否存储了非默认值
     *
     * @param int $row 行索引
     * @param int $col 列索引
     * @return bool 如果存储了非默认值则返回 true
     */
    public function containsKey(int $row, int $col): bool
    {
        $this->validate($row, $col);
        return $this->data[$row][$col] !== $this->defaultValue;
    }

    /**
     * 获取所有非默认值的键值对集合
     *
     * @return iterable<SparseArrayEntry> 所有非默认值的键值对集合
     */
    public function entrySet(): iterable
    {
        $result = [];

        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                if ($this->data[$i][$j] !== $this->defaultValue) {
                    $result[] = new SparseArrayEntry($i, $j, $this->data[$i][$j]);
                }
            }
        }

        return $result;
    }

    /**
     * 将稀疏数组转换为三元组格式
     *
     * @return int[][] 三元组格式的二维数组
     */
    public function toSparseArrayFormat(): array
    {
        $sparseArray = [[0, 0, 0]];

        // 在三元组二维数组第一行存储稀疏数组的行数、列数和非默认值的数量
        $sparseArray[0][0] = $this->rows;
        $sparseArray[0][1] = $this->cols;
        $sparseArray[0][2] = $this->size;

        $count = 1;

        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                // 如果不是默认值，存储该值所在的行、列和值
                if ($this->data[$i][$j] !== $this->defaultValue) {
                    $sparseArray[$count][0] = $i;
                    $sparseArray[$count][1] = $j;
                    $sparseArray[$count][2] = $this->data[$i][$j];
                    $count++;
                }
            }
        }

        return $sparseArray;
    }

    /**
     * 从三元组格式恢复稀疏数组
     *
     * @param int[][] $sparseArray 三元组格式的二维数组
     */
    public function fromSparseArrayFormat(array $sparseArray): void
    {
        // 三元组二维数组的第一行存储的是稀疏数组的行数、列数和非默认值的数量
        $this->rows = $sparseArray[0][0];
        $this->cols = $sparseArray[0][1];
        $this->size = $sparseArray[0][2];

        $this->data = [];

        for ($i = 0; $i < $this->rows; $i++) {
            $row = [];
            for ($j = 0; $j < $this->cols; $j++) {
                $row[] = $this->defaultValue;
            }
            $this->data[] = $row;
        }

        for ($i = 1; $i < count($sparseArray); $i++) {
            $this->data[$sparseArray[$i][0]][$sparseArray[$i][1]] = $sparseArray[$i][2];
        }
    }

    /**
     * 获取逻辑上的行数
     *
     * @return int 逻辑上的行数
     */
    public function rows(): int
    {
        return $this->rows;
    }

    /**
     * 获取逻辑上的列数
     *
     * @return int 逻辑上的列数
     */
    public function cols(): int
    {
        return $this->cols;
    }

    /**
     * 验证行和列索引
     *
     * @param int $row 行索引
     * @param int $col 列索引
     */
    private function validate(int $row, int $col): void
    {
        $this->validateRow($row);
        $this->validateCol($col);
    }

    /**
     * 验证行索引
     *
     * @param int $row 行索引
     */
    private function validateRow(int $row): void
    {
        if ($row < 0 || $row >= $this->rows) {
            throw new InvalidArgumentException("Invalid rows: " . $row);
        }
    }

    /**
     * 验证列索引
     *
     * @param int $col 列索引
     */
    private function validateCol(int $col): void
    {
        if ($col < 0 || $col >= $this->cols) {
            throw new InvalidArgumentException("Invalid cols: " . $col);
        }
    }
}
