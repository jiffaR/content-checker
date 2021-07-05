<?php

namespace Freinir\ContentChecker;

class CommentChecker extends AbstractChecker {

    public const STATUS_NEW = 'new';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_DELETED = 'deleted';
    public const STATUS_NOT_FOUND = 'not_found';

    /**
     * @param string $text
     */
    private function getCommentStatus(string $text)
    {
        $request = $this->client->post(
            $this->apiUrl,
            \http_build_query(
                [
                    'comment' => $text
                ]
            )
        );

        $result = json_decode($request->getBody(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

        return $result['status'];
    }

    /**
     * @param string $text
     * @return bool
     */
    public function isApprovedComment(string $text): bool
    {
        $status = $this->getCommentStatus($text);
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