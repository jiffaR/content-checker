<?php
namespace Freinir\ContentChecker;

use Freinir\ContentChecker\Services\LangService;
use Freinir\ContentChecker\Services\WordsCacheService;

/**
 * Проверка по стопсловам для отображения рекламы адсенса
 * Class GoogleBadWordsChecker
 */
class GoogleBadWordsChecker extends AbstractBadWordChecker {

    public function __construct($apiUrl)
    {
        $cacheService = new WordsCacheService('googleBadWords.json', $apiUrl);

        $stems =  $cacheService->getStems();
        self::$badWordStems = $stems['words'] ?? [];
        self::$badPhrasesStems = $stems['phrases'] ?? [];
    }
}