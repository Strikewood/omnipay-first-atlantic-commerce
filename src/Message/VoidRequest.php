<?php

namespace Omnipay\FirstAtlanticCommerce\Message;

use Omnipay\FirstAtlanticCommerce\Message\TransactionModificationRequest;

/**
 * FACPG2 Reversal Request
 */
class VoidRequest extends TransactionModificationRequest
{
    /**
     * Flag as a reversal
     *
     * @var int;
     */
    protected $modificationType = 3;
}
