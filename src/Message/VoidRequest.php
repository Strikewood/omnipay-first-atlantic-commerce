<?php

namespace Omnipay\FirstAtlanticCommerce\Message;

/**
 * FACPG2 Reversal Request
 */
class VoidRequest extends AbstractTransactionModificationRequest
{
    /**
     * Flag as a reversal
     *
     * @var int;
     */
    protected $modificationType = 3;
}
