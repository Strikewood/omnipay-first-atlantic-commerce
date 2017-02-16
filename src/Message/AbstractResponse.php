<?php

namespace Omnipay\FirstAtlanticCommerce\Message;

use Omnipay\Common\Message\AbstractResponse as BaseAbstractResponse;
use SimpleXMLElement;

abstract class AbstractResponse extends BaseAbstractResponse
{
    /**
     * Seserializes XML to an array
     *
     * @param \SimpleXMLElement|string $xml SimpleXMLElement object or a well formed xml string.
     *
     * @return array data
     */
    protected function xmlDeserialize($xml)
    {
        $array = [];

        if (!$xml instanceof SimpleXMLElement)
        {
            $xml = new SimpleXMLElement($xml);
        }

        foreach ($xml->children() as $key => $child)
        {
            $value = (string) $child;
            $_children = $this->xmlDeserialize($child);
            $_push = ( $_hasChild = ( count($_children) > 0 ) ) ? $_children : $value;

            if ( $_hasChild && !empty($value) && $value !== '' )
            {
                $_push[] = $value;
            }

            $array[$key] = $_push;
        }

        return $array;
    }
}
