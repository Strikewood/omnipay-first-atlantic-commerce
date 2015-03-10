<?php

namespace Omnipay\FirstAtlanticCommerce\Message;

use Omnipay\FirstAtlanticCommerce\Message\AuthorizeRequest;

/**
 * FACPG2 Purchase Request
 */
class PurchaseRequest extends AuthorizeRequest
{
    /**
     * Transaction code (flag as a single pass transaction – authorization and capture as a single transaction)
     *
     * @var int;
     */
    protected $transactionCode = 8;
}
