<?php

namespace Freinir\ContentChecker\Tests;

use Freinir\ContentChecker\Services\WordsCacheService;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/config.php';

class CacheProviderServiceTest extends TestCase
{
    public function testStemCache()
    {
        $service = new WordsCacheService('googleBadWords.json', GOOGLE_BAD_WORDS_API);
        $service->getStems();
        $this->assertFileExists(WordsCacheService::CACHE_DIR . 'googleBadWords.json');
    }

    public function testFlushCache()
    {
        WordsCacheService::flushCache();
        $empty = (count(scandir(WordsCacheService::CACHE_DIR)) == 2);
        $this->assertTrue($empty);
    }
}