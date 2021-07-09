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
    private function getCommentStatus(string $text, array $options)
    {
        $options['comment'] = $text;
        $request = $this->client->post($this->apiUrl, \http_build_query($options));

        $result = json_decode($request->getBody(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

        return $result['status'];
    }

    /**
     * @param string $text
     * @param array $options
     * @return bool
     */
    public function isApprovedComment(string $text, $options = []): bool
    {
        $status = $this->getCommentStatus($text, $options);
        try {
            if ($status == self::STATUS_DELETED || $status == self::STATUS_NOT_FOUND) {
                return false;
            }
            return true;

        } catch (\Exception $exception) {
            return false;
        }
    }
}