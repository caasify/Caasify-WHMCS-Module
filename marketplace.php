<?php

use WHMCS\Authentication\CurrentUser;
use WHMCS\ClientArea;
use WHMCS\Database\Capsule;

define('CLIENTAREA', true);
require __DIR__ . '/init.php';

$ca = new ClientArea();
$ca->setPageTitle('Marketplace');
$ca->addToBreadCrumb('index.php', Lang::trans('globalsystemname'));
$ca->addToBreadCrumb('marketplace.php', 'Marketplace');
$ca->initPage();

# Define the template filename to be used without the .tpl extension
$ca->setTemplate('vpspricing');
$ca->output();
