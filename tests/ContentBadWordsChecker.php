<?php

namespace Freinir\ContentChecker\Tests;

use Freinir\ContentChecker\Services\WordsCacheService;
use PHPUnit\Framework\TestCase;

class ContentBadWordsChecker extends TestCase
{
    public function testAdSensePhrases()
    {
        $service = new WordsCacheService('googleBadWords.json', );
        $service->getStems();
        $this->assertFileExists(WordsCacheService::CACHE_DIR . 'googleBadWords.json');
    }
}