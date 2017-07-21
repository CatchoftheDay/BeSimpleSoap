<?php

namespace Fixtures;

use Fixtures\Attachment\MessageWithAttachmentsTrait;

class DummyServiceResponseWithAttachments
{
    use MessageWithAttachmentsTrait;

    /**
     * @var bool $status
     */
    public $status;
}
