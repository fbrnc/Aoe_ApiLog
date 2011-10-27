<?php

/**
 * Observer
 *
 * @author Fabrizio Branca
 */
class Aoe_ApiLog_Model_Observer {

	/**
	 * Log api actions
	 *
	 * @param Varien_Event_Observer $observer
	 */
	public function controller_action_predispatch_api(Varien_Event_Observer $observer) {

		$enable = Mage::getStoreConfig('dev/aoe_apilog/enablelogging');
		if (!$enable) {
			return;
		}

		$controllerAction = $observer->getControllerAction(); /* @var $controllerAction Mage_Api_IndexController */

		$logFormat = Mage::getStoreConfig('dev/aoe_apilog/logformat');
		if (empty($logFormat)) {
			$logFormat = 'AOE_APILOG: No logformat configuration found in dev/aoe_apilog/logformat';
		}

		$replace = array(
			'###REQUESTURI###' => $controllerAction->getRequest()->getRequestUri(),
			'###CLIENTIP###' => $controllerAction->getRequest()->getClientIp(),
			'###REQUEST###' => file_get_contents('php://input'),
			'###RESPONSE###' => $controllerAction->getResponse()->getBody()
		);

		$message = str_replace(array_keys($replace), array_values($replace), $logFormat);
		$fileName = Mage::getStoreConfig('dev/aoe_apilog/logfilename');

		Mage::log($message, null, $fileName);
	}

}
