<?php

namespace Omnipay\FirstAtlanticCommerce\Message;

/**
 * FACPG2 Capture Request
 */
class CaptureRequest extends AbstractTransactionModificationRequest
{
    /**
     * Flag as a capture
     *
     * @var int;
     */
    protected $modificationType = 1;
}
