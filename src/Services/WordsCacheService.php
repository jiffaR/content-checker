<?php

namespace Freinir\ContentChecker\Services;

class WordsCacheService {
    public const CACHE_DIR = __DIR__ . '/../Cache/';
    private const EXPIRE_TIME = 60 * 60 * 24;

    private $wordStems = [];
    private $file;
    private $sourceUrl;

    public function __construct(string $cacheFileName, string $sourceUrl)
    {
        $this->file = self::CACHE_DIR . $cacheFileName;
        $this->sourceUrl = $sourceUrl;
    }

    /**
     * @return array|mixed
     */
    public function getStems()
    {
        $cache = $this->getCache();
        if($cache) {
            $this->wordStems = json_decode($cache, true);
            return $this->wordStems;
        }

        $this->wordStems = $this->prepareStems($this->getApiData());
        $this->setCache();

        return $this->wordStems;
    }

    private function prepareStems($stopWords)
    {
        $result = [
            'words' => [],
            'phrases' => []
        ];

        foreach ($stopWords as $word) {
            if(count(LangService::split($word)) > 1) {
                $result['phrases'][] = LangService::getStems($word, true);
            } else {
                $result['words'][] = LangService::getStem($word, true);
            }
        }

        return $result;
    }

    private function setCache()
    {
        file_put_contents($this->file, json_encode($this->wordStems));
    }

    /**
     * @return bool|false|string
     */
    private function getCache()
    {
        if(!file_exists($this->file) || filemtime($this->file) < time() - self::EXPIRE_TIME) {
            return false;
        } else {
            return file_get_contents($this->file);
        }
    }

    /**
     * Возвращает массив стоп слов из API
     * @return string
     */
    private function getApiData()
    {
        $request = CurlService::getInstance()->get($this->sourceUrl);
        return json_decode($request->getBody(), true);
    }

    public static function flushCache()
    {
        $files = glob(self::CACHE_DIR . '*');
        foreach($files as $file) {
            if(is_file($file)) {
                unlink($file);
            }
        }
    }
}