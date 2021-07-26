<?php

namespace Freinir\ContentChecker\Tests;

use Freinir\ContentChecker\Services\WordsCacheService;
use PHPUnit\Framework\TestCase;

class CacheProviderServiceTest extends TestCase
{
    public function testStemCache()
    {
        $service = new WordsCacheService('googleBadWords.json', '');
        $service->getStems();
        $this->assertFileExists(WordsCacheService::CACHE_DIR . 'googleBadWords.json');
    }
}