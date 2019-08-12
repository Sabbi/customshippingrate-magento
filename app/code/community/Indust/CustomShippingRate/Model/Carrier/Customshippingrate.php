<?php
/**
 * Admin Custom Shipping Rate
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to jeffk@industrialtechware.com so we can send you a copy immediately.
 *
 * @category   Indust
 * @package    Indust_CustomShippingRate
 * @author     Jeff Kieke <jeffk@industrialtechware.com>
 * @copyright  Copyright (c) 2011, Jeff Kieke
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Indust_CustomShippingRate_Model_Carrier_Customshippingrate
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{

    CONST BASE_SHIPPING_AMOUNT = 'BASE_SHIPPING_AMOUNT_REGISTRY_KEY';
    CONST SHIPPING_AMOUNT = 'SHIPPING_AMOUNT_REGISTRY_KEY';
    CONST SHIPPING_DESCRIPTION = 'SHIPPING_DESCRIPTION_REGISTRY_KEY';

    protected $_code = 'customshippingrate';
    protected $_isFixed = true;

    /**
     * Admin Custom Shipping Rates Collector
     *
     * @param Mage_Shipping_Model_Rate_Request $data
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $method = Mage::getModel('shipping/rate_result_method');

        $method->setCarrier($this->_code);
        $method->setCarrierTitle(Mage::helper('shipping')->__('Custom Carrier Title'));

        $method->setMethod($this->_code);
        $method->setMethodTitle(Mage::helper('shipping')->__('Custom Method Title'));

        if (Mage::registry(self::SHIPPING_DESCRIPTION)) {
            $method->setCarrierTitle(Mage::helper('shipping')->__(''));
            $method->setMethodTitle(Mage::registry(self::SHIPPING_DESCRIPTION));
        }

        if (Mage::registry(self::BASE_SHIPPING_AMOUNT)) {
            $method->setPrice(Mage::registry(self::BASE_SHIPPING_AMOUNT));
        } else {
            $method->setPrice(0);
        }
        $method->setCost(0);

        $result = Mage::getModel('shipping/rate_result');
        $result->append($method);

        return $result;
    }

    /**
     * Get allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return array('customshippingrate' => Mage::helper('shipping')->__('Custom Shipping Rate'));
    }

}