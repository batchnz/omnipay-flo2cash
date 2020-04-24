<?php
/**
 * Paypal Item
 */

namespace Omnipay\Flo2Cash;

use Omnipay\Common\Item;

/**
 * Class Flo2CashItem
 *
 * @package Omnipay\Flo2Cash
 */
class Flo2CashItem extends Item
{
    /**
     * {@inheritDoc}
     */
    public function getCode()
    {
        return $this->getParameter('code');
    }

    /**
     * Set the item code
     */
    public function setCode($value)
    {
        return $this->setParameter('code', $value);
    }
}
