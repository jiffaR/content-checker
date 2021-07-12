<?php

namespace Freinir\ContentChecker;

class CommentChecker extends AbstractChecker {

    public const STATUS_NEW = 'new';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_DELETED = 'deleted';
    public const STATUS_NOT_FOUND = 'not_found';

    /**
     * @param string $text
     * @param array $options
     * @return mixed
     */
    public function getCommentStatus(string $text, array $options = [])
    {
        $options['comment'] = $text;
        try {
            $request = $this->client->post($this->apiUrl, \http_build_query($options));
            $result = json_decode($request->getBody(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

            return $result['status'];
        } catch (\Exception $exception) {
            return self::STATUS_NOT_FOUND;
        }
    }
}