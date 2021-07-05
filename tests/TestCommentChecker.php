<?php

namespace Freinir\ContentChecker\Tests;

use Freinir\ContentChecker\CommentChecker;
use PHPUnit\Framework\TestCase;

class TestCommentChecker extends TestCase {

    public function testCommentStatus()
    {
        $body = 'Any content';
        $commentChecker = new CommentChecker('your-check-api.com');
        $status = $commentChecker->getCommentStatus($body);

        $this->assertEquals(CommentChecker::STATUS_NOT_FOUND, $status);
    }
}