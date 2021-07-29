<?php
namespace Freinir\ContentChecker\Services;

use Exception;
use NXP\Stemmer;

class LangService
{
    private const PRETEXT = ['в', 'без', 'до', 'из', 'к', 'на', 'по', 'о', 'от', 'перед',
        'при', 'через', 'с', 'у', 'за', 'и', 'над', 'об', 'под', 'про', 'для', '-', '/', '|'];

    /**
     * @param $word
     * @param bool $lowercase
     * @return string
     */
    public static function getStem($word, $lowercase = false)
    {
        $stemmer = new Stemmer();
        if ($lowercase) {
            return mb_strtolower($stemmer->getWordBase($word));
        } else {
            return $stemmer->getWordBase($word);
        }
    }

    /**
     * @param $phrase
     * @param bool $lowercase
     * @param bool $sort
     * @return array
     */
    public static function getStems($phrase, $lowercase = false, $sort = true)
    {
        $phrase = str_replace([',', ')', '(', '.', '!', '?', ':', ';', '#', '*', '"', '\''], ' ', $phrase);
        $words = self::split($phrase);
        $stemmer = new Stemmer();
        $result = [];
        foreach ($words as $word) {
            if (self::isAbbr($word)) {
                $result[] = $word;
                continue;
            }

            if (self::isPretext($word)) {
                continue;
            }
            if ($lowercase) {
                $result[] = mb_strtolower($stemmer->getWordBase($word));
            } else {
                $result[] = $stemmer->getWordBase($word);
            }
        }

        if ($sort) {
            sort($result);
        }

        return $result;
    }

    /**
     * @param string $word
     * @return bool
     */
    public static function isAbbr(string $word): bool
    {
        return $word === mb_strtoupper($word);
    }

    /**
     * @param string $word
     * @return bool
     */
    public static function isPretext(string $word): bool
    {
        if (strlen($word) < 2)
            return true;
        return in_array(mb_strtolower($word), self::PRETEXT);
    }

    /**
     * Разбивает строку по дефисам и пробелам
     * @param $phrase
     * @return array
     */
    public static function split($phrase)
    {
        $words = [];
        $defisExplodes = explode('-', $phrase);
        foreach ($defisExplodes as $d) {
            $spaceExplodes = explode(' ', $d);
            foreach ($spaceExplodes as $s) {
                if (strlen(trim($s)) > 0) {
                    $words[] = trim($s);
                }
            }
        }

        return $words;
    }



    /**
     * @param array $stems
     * @param string $string
     * Проверяет вхождение основ $stems в строке
     * @return bool
     */
    public static function containStemIn(array $stems, string $string)
    {
        $stringStems = self::getStems($string, true);
        return self::stemsContain($stringStems, $stems);
    }

    /**
     * Содежатся ли все основы массива2 в массиве1
     * @param array $haystack
     * @param array $needle
     * @return bool
     */
    public static function stemsContain(array $haystack, array $needle)
    {
        $intersect = array_intersect($needle, $haystack);
        return $needle == $intersect;
    }

    /**
     * @param string $string1
     * @param string $string2
     * Проверяет совпадение строк по основам
     * @return bool
     */
    public static function equalByStem(string $string1, string $string2)
    {
        $stringStems1 = self::getStems($string1, true);
        $stringStems2 = self::getStems($string2, true);
        return $stringStems1 == $stringStems2;
    }
}
