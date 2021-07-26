<?php

namespace Freinir\ContentChecker;

use Freinir\ContentChecker\Services\LangService;

class AbstractBadWordChecker {

    /**
     * @var array
     */
    protected static $badWordStems = [];
    protected static $badPhrasesStems = [];

    /**
     * найденные стоп слова
     * @var array
     */
    public static $find = [];

    /**
     * @param string $content
     * @return bool
     */
    public function isBadContent(string $content)
    {
        $stemContent = LangService::getStems($content, true);
        if($this->hasBadWord($stemContent)) {
            return true;
        }

        if($this->hasBadPhrase($stemContent)) {
            return true;
        }

        return false;
    }

    /**
     * Для слов проверяем единственное вхождение основы
     * @param $stemContent
     * @return bool
     */
    protected function hasBadWord($stemContent)
    {
        $intersect = array_intersect($stemContent, self::$badWordStems);
        self::$find = $intersect;

        if(count($intersect)) {
            return true;
        }

        return false;
    }

    /**
     * Для фраз проверяем полное вхождение фразы
     * @param $stemContent
     * @return bool
     */
    protected function hasBadPhrase($stemContent)
    {
        foreach (self::$badPhrasesStems as $phrase) {
            $intersect = array_intersect($stemContent, $phrase);
            if($intersect == $phrase) {
                self::$find = $intersect;
                return true;
            }
        }

        return false;
    }
}