<?php

namespace Freinir\ContentChecker\Tests;

use Freinir\ContentChecker\ContentBadWordsChecker;
use Freinir\ContentChecker\GoogleBadWordsChecker;
use Freinir\ContentChecker\Services\WordsCacheService;
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/config.php';

class ContentBadWordsCheckerTest extends TestCase
{
    public function testAdSensePhrases()
    {
        $checker = new GoogleBadWordsChecker(GOOGLE_BAD_WORDS_API);
        
        $test1 = 'Табачная фабрика';
        $test2 = 'Продажа табака';
        $test3 = 'Автомойка, продажа запчастей и тортов';
        $test4 = 'Экзотические фрукты оптом';
        $test5 = 'Экзотический массаж';

        
        $this->assertTrue($checker->isBadContent($test1));
        $this->assertTrue($checker->isBadContent($test2));
        $this->assertTrue($checker->isBadContent($test5));
        $this->assertFalse($checker->isBadContent($test3));
        $this->assertFalse($checker->isBadContent($test4));
    }

    public function testContentPhrases()
    {
        $checker = new ContentBadWordsChecker(CONTENT_BAD_WORDS_API);
    
        $test0 = 'Доставка алкоголя круглосуточно У нас
можно купить алкоголь ночью с доставкой на дом, доставка алкоголя производится в течение 15-30 минут';
        $test1 = 'Фабрика электроудочек!';
        $test2 = 'Гашиш';
        $test3 = 'Продажа алкоголя';
        $test4 = 'Доставка алкоголя круглосуточно';
    
        $this->assertTrue($checker->isBadContent($test0));
        $this->assertTrue($checker->isBadContent($test1));
        $this->assertTrue($checker->isBadContent($test2));
        $this->assertFalse($checker->isBadContent($test3));
        $this->assertTrue($checker->isBadContent($test4));
    }

    public function testFindWords()
    {
        $checker = new ContentBadWordsChecker(CONTENT_BAD_WORDS_API);
        $test = 'Доставка алкоголя круглосуточно';
        $this->assertTrue($checker->isBadContent($test));
        $find = $checker::$find;
        $this->assertIsArray($find);
    }

}