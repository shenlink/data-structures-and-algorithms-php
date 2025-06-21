<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Lists;

/**
 * 动态数组实现，基于数组的数据结构，支持自动扩容和缩容。
 */
class ArrayList extends AbstractList
{
    /**
     * 实际存储元素的数组。
     *
     * @var array<int, int>
     */
    private array $elements = [];

    /**
     * 数组的默认容量。
     *
     * @var int
     */
    private const DEFAULT_CAPACITY = 10;

    /**
     * 构造函数。
     *
     * @param int $capacity 初始容量
     */
    public function __construct(int $capacity = self::DEFAULT_CAPACITY)
    {
        // 当容量小于等于默认容量，使用默认容量
        $capacity = max($capacity, self::DEFAULT_CAPACITY);
        $this->elements = array_fill(0, $capacity, null);
    }

    /**
     * 清空数组。
     */
    public function clear(): void
    {
        // 不使用unset()或array_fill()方法，专注于数据结构和算法的思路
        for ($i = 0; $i < count($this->elements); $i++) {
            $this->elements[$i] = null;
        }
        $this->size = 0;
    }

    /**
     * 获取指定索引的元素。
     *
     * @param int $index 要获取的元素索引，必须在 [0, size()) 范围内
     * @return int 位于指定索引处的元素
     */
    public function get(int $index): int
    {
        $this->checkIndex($index);
        return $this->elements[$index];
    }

    /**
     * 修改指定索引的元素，返回索引之前的元素。
     *
     * @param int   $index   要替换的索引，必须在 [0, size()) 范围内
     * @param int $element 新元素
     * @return int 被替换的旧元素
     */
    public function set(int $index, int $element): int
    {
        $this->checkIndex($index);
        $oldElement = $this->elements[$index];
        $this->elements[$index] = $element;
        return $oldElement;
    }

    /**
     * 添加元素到指定索引。
     *
     * @param int     $index   插入索引，必须在 [0, size()] 范围内
     * @param int $element 要插入的元素
     */
    public function addAt(int $index, int $element): void
    {
        $this->checkIndexForAdd($index);
        // 扩容
        $this->expansion($index + 1);
        // 添加时有4种情况：
        // 1. 添加第一个元素，index = 0，直接添加
        // 2. 添加的索引是0，那就要把0到size - 1的元素往后挪动
        // 3. 添加的索引是size，index = size，直接添加
        // 4. 添加的索引是1到size - 1，需要从index开始把元素往后挪动，然后在index出插入新的元素
        // 这4中情况可以进一步归纳成2种情况：
        // 1. index == size，直接添加
        // 2. index < size，从index开始把元素往后挪动，然后在index出插入新的元素
        // 由于 index == size时，for (int i = size; i > index; i--)中，i >
        // index的条件没有成立，
        // 所以这两种情况的代码可以统一
        // 从index + 1开始往后挪动元素，index 的元素覆盖index + 1的元素
        for ($i = $this->size; $i > $index; $i--) {
            $this->elements[$i] = $this->elements[$i - 1];
        }
        $this->elements[$index] = $element;
        $this->size++;
    }

    /**
     * 删除指定索引的元素，返回索引之前的元素。
     *
     * @param int $index 要删除的索引，必须在 [0, size()) 范围内
     * @return int 被删除的元素
     */
    public function remove(int $index): int
    {
        $this->checkIndex($index);
        // 保存索引之前的元素，用于返回
        $oldElement = $this->elements[$index];
        // 删除时有4种情况：
        // 1. 只有一个元素，直接删除
        // 2. 删除的索引是0，那就要把0到size - 1的元素往前挪动
        // 3. 删除的索引是size，index = size，直接删除
        // 4. 删除的索引是1到size - 1，需要从index开始把元素往前挪动
        // 这4中情况可以进一步归纳成2种情况：
        // 1. index == size，直接删除
        // 2. index < size，从index开始把元素往前挪动
        // 由于 index == size时，for (int i = index; i < size - 1; i++)中，i <
        // size的条件没有成立，
        // 所以这两种情况的代码可以统一
        // 从index + 1开始往前挪动元素，index 的元素覆盖index - 1的元素
        for ($i = $index; $i < $this->size - 1; $i++) {
            $this->elements[$i] = $this->elements[$i + 1];
        }
        $this->size--;
        $this->shrinking();
        return $oldElement;
    }

    /**
     * 获取指定元素第一次出现的位置。
     *
     * @param int $element 要查找的元素
     * @return int 元素首次出现的索引位置，如果未找到则返回 -1
     */
    public function indexOf(int $element): int
    {
        if ($element === null) {
            for ($i = 0; $i < $this->size; $i++) {
                if ($this->elements[$i] === null) {
                    return $i;
                }
            }
        } else {
            for ($i = 0; $i < $this->size; $i++) {
                if ($this->elements[$i] === $element) {
                    return $i;
                }
            }
        }
        return self::ELEMENT_NOT_FOUND;
    }

    /**
     * 确认是数组容量是否满足。
     *
     * @param int $capacity 需要确认的容量
     * @return bool 如果当前容量大于等于需要的容量返回 true
     */
    private function checkCapacity(int $capacity): bool
    {
        return count($this->elements) >= $capacity;
    }

    /**
     * 扩容，数组容量不够，扩容加大容量到原始容量的1.5倍。
     *
     * @param int $capacity 需要的最小容量
     */
    private function expansion(int $capacity): void
    {
        if ($this->checkCapacity($capacity)) {
            return;
        }
        $oldCapacity = count($this->elements);
        // 扩容后的容量是旧容量的1.5倍
        $newCapacity = $oldCapacity + ($oldCapacity >> 1);
        $newElements = array_pad($this->elements, $newCapacity, null);
        $this->elements = $newElements;
    }

    /**
     * 缩容，元素数量小于等于数组容量的一半时，缩容到一半。
     */
    private function shrinking(): void
    {
        $oldCapacity = count($this->elements);
        // 缩容后的容量是旧容量的一半
        $newCapacity = $oldCapacity >> 1;
        // 如果当前的元素数量大于新容量或者新容量小于默认容量，不需要缩容
        if ($this->size > $newCapacity || $newCapacity < self::DEFAULT_CAPACITY) {
            return;
        }

        $newElements = [];
        // 注意：不使用array_slice()方法，专注于数据结构和算法的思路
        for ($i = 0; $i < $this->size; $i++) {
            $newElements[$i] = $this->elements[$i];
        }
        // 填充剩余部分为空
        for ($i = $this->size; $i < $newCapacity; $i++) {
            $newElements[$i] = null;
        }
        $this->elements = $newElements;
    }

    /**
     * 返回动态数组的字符串表示。
     *
     * @return string 表示动态数组内容的字符串
     */
    public function toString(): string
    {
        $stringBuilder = "size: {$this->size}, elements: [";
        for ($i = 0; $i < $this->size; $i++) {
            if ($i !== 0) {
                $stringBuilder .= ', ';
            }
            $stringBuilder .= (string) $this->elements[$i];
        }
        return $stringBuilder . ']';
    }
}
