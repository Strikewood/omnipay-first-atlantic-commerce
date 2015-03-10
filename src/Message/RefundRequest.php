<?php

namespace Omnipay\FirstAtlanticCommerce\Message;

use Omnipay\FirstAtlanticCommerce\Message\TransactionModificationRequest;

/**
 * FACPG2 Refund Request
 */
class RefundRequest extends TransactionModificationRequest
{
    /**
     * Flag as a refund
     *
     * @var int;
     */
    protected $modificationType = 2;
}
