<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Strings;

/**
 * 蛮力算法的另一种实现
 * 该实现采用固定文本位置逐个比较的方式进行字符串匹配
 */
class BruteForceMatchAnother implements IMatch
{
    /**
     * 使用蛮力算法查找模式字符串在文本字符串中的首次出现位置
     *
     * @param string $text    被搜索的文本字符串
     * @param string $pattern 需要查找的模式字符串
     * @return int 如果找到模式字符串，则返回其在文本字符串中首次出现的索引，如果未找到，则返回-1
     */
    public function indexOf(string $text, string $pattern): int
    {
        if ($text === null || $pattern === null) {
            return -1;
        }

        $tlen = strlen($text);
        $plen = strlen($pattern);

        if ($plen === 0 || $tlen < $plen) {
            return -1;
        }

        $tiMax = $tlen - $plen;

        for ($ti = 0; $ti <= $tiMax; $ti++) {
            $pi = 0;
            for (; $pi < $plen; $pi++) {
                if ($text[$ti + $pi] !== $pattern[$pi]) {
                    break;
                }
            }

            if ($pi === $plen) {
                return $ti;
            }
        }

        return -1;
    }
}
