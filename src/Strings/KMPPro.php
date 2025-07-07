<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Strings;

/**
 * 优化的 KMP 算法实现
 * 在基础 KMP 算法上进一步优化 next 数组的计算，避免相同字符的无效跳转
 */
class KMPPro implements IMatch
{
    /**
     * 使用优化的KMP算法查找模式字符串在文本字符串中的首次出现位置
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
     * 计算优化的 KMP 算法中的 next 数组
     * next 数组记录了模式串中每个位置之前的子串的最长公共前后缀的长度
     * 此方法进行了优化，避免相同字符的无效跳转
     *
     * @param string $pattern 模式串
     * @return array<int> 返回 pattern 对应的优化后的 next 数组
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
                if ($pattern[$i] !== $pattern[$n]) {
                    $next[$i] = $next[$n];
                } else {
                    $next[$i] = $n;
                }
            } else {
                $n = $next[$n];
            }
        }

        return $next;
    }
}
