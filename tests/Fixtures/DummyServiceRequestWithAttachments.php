<?php

namespace Fixtures;

use Fixtures\Attachment\MessageWithAttachmentsTrait;

class DummyServiceRequestWithAttachments
{
    use MessageWithAttachmentsTrait;

    /**
     * @var int $dummyAttribute
     */
    public $dummyAttribute;

    /**
     * @var bool $includeAttachments
     */
    public $includeAttachments;
}
