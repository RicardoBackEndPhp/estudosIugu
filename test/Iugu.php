<?php

if (file_exists(dirname(__FILE__).'/../vendor/simpletest/simpletest/autorun.php')) { 
  include_once dirname(__FILE__).'/../vendor/simpletest/simpletest/autorun.php'; 
} 
if (file_exists(dirname(__FILE__).'/../../../../vendor/simpletest/simpletest/autorun.php')) { 
  include_once dirname(__FILE__).'/../../../../vendor/simpletest/simpletest/autorun.php'; 
} 

error_reporting(E_ALL | E_STRICT);

echo "Running iugu PHP Test Suite\r\n";

$apiKey = getenv('e13a52d09b9130be7f47819b2df54b8d');

if (!$apiKey) {
    echo 'MISSING IUGU_API_KEY in Environment. $ export IUGU_API_KEY=<{IUGU_API_KEY}>.';
    exit(1);
}

include_once dirname(__FILE__).'/../lib/Iugu.php';

include_once dirname(__FILE__).'/Iugu/TestCase.php';
include_once dirname(__FILE__).'/Iugu/CustomerTest.php';
include_once dirname(__FILE__).'/Iugu/PaymentMethodTest.php';
include_once dirname(__FILE__).'/Iugu/PaymentTokenTest.php';
include_once dirname(__FILE__).'/Iugu/ChargeTest.php';
include_once dirname(__FILE__).'/Iugu/SubscriptionTest.php';
include_once dirname(__FILE__).'/Iugu/PlanTest.php';
