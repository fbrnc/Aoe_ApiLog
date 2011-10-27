<?php

$client = new SoapClient('http://yourdomain/api/?wsdl');
$session = $client->login('api_user', 'key');
$result = $client->call($session, 'sales_order.list');
