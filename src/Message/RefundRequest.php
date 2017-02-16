<?php

namespace Omnipay\FirstAtlanticCommerce\Message;


/**
 * FACPG2 Refund Request
 */
class RefundRequest extends AbstractTransactionModificationRequest
{
    /**
     * Flag as a refund
     *
     * @var int;
     */
    protected $modificationType = 2;
}
