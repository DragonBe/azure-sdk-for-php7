<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

$accountName = $config['storage']['name'];
$accountKey = $config['storage']['key'];

$storageService = \Microsoft\Azure\Storage\StorageFactory::create($accountName, $accountKey);
$r = $storageService->listContainers();
$r->rewind();
var_dump($r->current());
var_dump(count($r));
