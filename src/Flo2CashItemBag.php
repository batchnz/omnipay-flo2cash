<?php
/**
 * Flo2Cash Item bag
 */

namespace Omnipay\Flo2Cash;

use Omnipay\Common\ItemBag;
use Omnipay\Common\ItemInterface;

/**
 * Class Flo2CashItemBag
 *
 * @package Omnipay\Flo2Cash
 */
class Flo2CashItemBag extends ItemBag
{
    /**
     * Add an item to the bag
     *
     * @see Item
     *
     * @param ItemInterface|array $item An existing item, or associative array of item parameters
     */
    public function add($item)
    {
        if ($item instanceof ItemInterface) {
            $this->items[] = $item;
        } else {
            $this->items[] = new Flo2CashItem($item);
        }
    }
}
