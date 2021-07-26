<?php
namespace Freinir\ContentChecker;

use Freinir\ContentChecker\Services\LangService;
use Freinir\ContentChecker\Services\WordsCacheService;

/**
 * Проверка по стопсловам для отображения рекламы адсенса
 * Class GoogleBadWordsChecker
 */
class ContentBadWordsChecker extends AbstractBadWordChecker {

    /**
     * @var array
     */
    private static $badWordStems = [];
    private static $badPhrasesStems = [];

    public static $find = [];
    public function __construct($apiUrl)
    {
        $cacheService = new WordsCacheService('contentBadWords.json', $apiUrl);

        $stems =  $cacheService->getStems();
        self::$badWordStems = $stems['words'] ?? [];
        self::$badPhrasesStems = $stems['phrases'] ?? [];
    }
}