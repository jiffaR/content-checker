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
    public function getCommentStatus(string $text)
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
}