<?php
require_once('../app/Mage.php');
ini_set("display_errors", 1);
set_time_limit(0);
umask(0);
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

class Checkstatus
{
	
	public function setBackOutStock()
	{
		//$outQty = Mage::getStoreConfig('cataloginventory/item/options_min_qty');	
	    $collection = Mage::getResourceModel('cataloginventory/stock_item_collection');
	    $collection->addFieldToFilter('qty', array('lt' => 4));
	    $collection->addFieldToFilter('is_in_stock', 1);

	    /*foreach($collection as $item) {
	        $item->setData('is_in_stock', 0);
	    }
	    $collection->save();
	    */
	    return $collection;
	}
	public function setBackInStock()
	{
		//$outQty = Mage::getStoreConfig('cataloginventory/item/options_min_qty');
	    $collection = Mage::getResourceModel('cataloginventory/stock_item_collection');
	    $collection->addFieldToFilter('qty', array('gt' => $outQty));
	    $collection->addFieldToFilter('is_in_stock', 0);

	    /*
	    foreach($collection as $item) {
	        $item->setData('is_in_stock', 1);
	    }
	    $collection->save();
	    */
	    return $collection;
	}
	public function main()
	{
		$configCollection = $this->setBackOutStock();
		foreach($configCollection as $confProd)
		{
			echo "Id: ".$confProd->getProductId()." - Qty: ".$confProd->getQty()."\n\r";
		}
		echo "\r\n*********************\r\n";
		$configCollectionIn = $this->setBackInStock();
		foreach($configCollectionIn as $confProdIn)
		{
			echo "Id- ".$confProdIn->getProductId()." : Qty- ".$confProdIn->getQty()."\n\r";
		}

	}
}

$obj = new Checkstatus();
$obj->main();
?>