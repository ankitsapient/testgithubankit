<?php
class Excellence_Ship_Model_Carrier_Excellence extends Mage_Shipping_Model_Carrier_Abstract
implements Mage_Shipping_Model_Carrier_Interface {
	protected $_code = 'excellence';

	public function collectRates(Mage_Shipping_Model_Rate_Request $request)
	{
		if (!Mage::getStoreConfig('carriers/'.$this->_code.'/active')) {
			return false;
		}
		
		$quote = Mage::getModel('checkout/session')->getQuote();
		$quoteData= $quote->getData();
		$grandTotal=$quoteData['grand_total'];
		
		//$price = $this->getConfigData('price'); // set a default shipping price maybe 0
		
		$price = Mage::getStoreConfig('carriers/excellence/price');
		$price1 = Mage::getStoreConfig('carriers/excellence/price1');
		$price2 = Mage::getStoreConfig('carriers/excellence/price2');
		
		$gTotal = Mage::getStoreConfig('carriers/excellence/gtotal');
		$gTotal1 = Mage::getStoreConfig('carriers/excellence/gtotal1');
		$gTotal3 = Mage::getStoreConfig('carriers/excellence/gtotal2');
		
	
		if($grandTotal >= $gTotal)
		  $price = $price;
		  elseif($grandTotal >=$gTotal1)
		  $price = $price1;
		  elseif($grandTotal < $gTotal3)
		  $price = $price2;
		
		


		
		

		$handling = Mage::getStoreConfig('carriers/'.$this->_code.'/handling');
		$result = Mage::getModel('shipping/rate_result');
		$show = true;
		if($show){

			$method = Mage::getModel('shipping/rate_result_method');
			$method->setCarrier($this->_code);
			$method->setMethod($this->_code);
			$method->setCarrierTitle($this->getConfigData('title'));
			$method->setMethodTitle($this->getConfigData('name'));
			$method->setPrice($price);
			$method->setCost($price);
			$result->append($method);

		}else{
			$error = Mage::getModel('shipping/rate_result_error');
			$error->setCarrier($this->_code);
			$error->setCarrierTitle($this->getConfigData('name'));
			$error->setErrorMessage($this->getConfigData('specificerrmsg'));
			$result->append($error);
		}
		return $result;
	}
	public function getAllowedMethods()
	{
		return array('excellence'=>$this->getConfigData('name'));
	}
}