<?php

use WHMCS\Authentication\CurrentUser;
use WHMCS\ClientArea;
use WHMCS\Database\Capsule;

define('CLIENTAREA', true);
require __DIR__ . '/init.php';

$ca = new ClientArea();
$ca->setPageTitle('VPS Pricing');
$ca->addToBreadCrumb('index.php', Lang::trans('globalsystemname'));
$ca->addToBreadCrumb('vpspricing.php', 'VPS Pricing');
$ca->initPage();

# Define the template filename to be used without the .tpl extension
$ca->setTemplate('vpspricing');
$ca->output();
