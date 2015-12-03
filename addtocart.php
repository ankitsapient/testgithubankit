<?php

require_once('app/Mage.php'); //Path to Magento
umask(0);
Mage::app();

$id = '554'; // Replace id with your product id
$qty = '1'; // Replace qty with your qty
$_product = Mage::getModel('catalog/product')->load($id);
$cart = Mage::getModel('checkout/cart');
$cart->init();
$cart->addProduct($_product, array('qty' => $qty));
$cart->save();
echo 'added successfully ';
Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
?>