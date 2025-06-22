<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Utils;

/**
 * Comparator 接口，用于定义自定义的对象比较逻辑。
 */
interface Comparator
{
    /**
     * 比较两个对象的顺序。
     *
     * @param mixed $o1 第一个要比较的对象。
     * @param mixed $o2 第二个要比较的对象。
     * @return int 返回负整数、零或正整数，分别表示第一个对象小于、等于或大于第二个对象。
     */
    public function compare($o1, $o2): int;
}
