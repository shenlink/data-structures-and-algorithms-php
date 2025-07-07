<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Strings;

/**
 * KMP 算法基础实现
 * 使用 KMP 算法进行字符串匹配，通过 next 数组避免重复比较提高效率
 */
class KMPBasic implements IMatch
{
    /**
     * 使用 KMP 算法查找模式字符串在文本字符串中的首次出现位置
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

        $ti = 0;
        $pi = 0;
        $tiMax = $tlen - $plen;

        $next = $this->next($pattern);

        while ($pi < $plen && $ti - $pi <= $tiMax) {
            if ($pi < 0 || $text[$ti] === $pattern[$pi]) {
                $ti++;
                $pi++;
            } else {
                $pi = $next[$pi];
            }
        }

        return $pi === $plen ? $ti - $pi : -1;
    }

    /**
     * 计算 KMP 算法中的 next 数组
     * next 数组记录了模式串中每个位置之前的子串的最长公共前后缀的长度
     *
     * @param string $pattern 模式串
     * @return array<int> 返回 pattern 对应的 next 数组
     */
    private function next(string $pattern): array
    {
        $len = strlen($pattern);
        $next = array_fill(0, $len, 0);
        $i = 0;
        $n = -1;
        $next[$i] = $n;
        $iMax = $len - 1;

        while ($i < $iMax) {
            if ($n < 0 || $pattern[$i] === $pattern[$n]) {
                $i++;
                $n++;
                $next[$i] = $n;
            } else {
                $n = $next[$n];
            }
        }

        return $next;
    }
}
