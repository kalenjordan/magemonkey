<?php
/**
 * Author : Ebizmarts <info@ebizmarts.com>
 * Date   : 8/21/13
 * Time   : 1:50 AM
 * File   : EventObserver.php
 * Module : Ebizmarts_Magemonkey
 */
class Ebizmarts_AbandonedCart_Model_EventObserver
{
    public function saveConfig(Varien_Event_Observer $o)
    {
        if(Mage::app()->getRequest()->getParam('store')) {
            $scope = 'store';
        }
        elseif(Mage::app()->getRequest()->getParam('website')) {
            $scope = 'website';
        }
        else {
            $scope = 'default';
        }

        $store  = is_null($o->getEvent()->getStore()) ? Mage::app()->getDefaultStoreView()->getCode(): $o->getEvent()->getStore();
        if(!Mage::helper('mandrill')->useTransactionalService()) {
            $config =  new Mage_Core_Model_Config();
            $config->saveConfig(Ebizmarts_AbandonedCart_Model_Config::ACTIVE,false,$scope,$store);
            Mage::getConfig()->cleanCache();
        }

    }
}