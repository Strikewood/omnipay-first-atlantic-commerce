<?php

namespace Omnipay\FirstAtlanticCommerce\Message;

use Omnipay\FirstAtlanticCommerce\Message\TransactionModificationRequest;

/**
 * FACPG2 Capture Request
 */
class CaptureRequest extends TransactionModificationRequest
{
    /**
     * Flag as a capture
     *
     * @var int;
     */
    protected $modificationType = 1;
}
