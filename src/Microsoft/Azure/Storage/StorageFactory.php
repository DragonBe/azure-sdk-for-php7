<?php

namespace Microsoft\Azure\Storage;

use GuzzleHttp\Client;
use Microsoft\Azure\Common\FactoryInterface;
use Microsoft\Azure\Storage\Auth\AuthenticationService;
use Microsoft\Azure\Storage\Entity\ContainerEntityHydrator;

class StorageFactory implements FactoryInterface
{
    /**
     * Factory operation to create a new instance of a storage service
     * 
     * @param $accountName
     * @param $accountKey
     * @param string $httpProtocol
     * @return StorageService
     */
    public static function create($accountName, $accountKey, $httpProtocol = StorageService::HTTP_PROTO_SEC)
    {
        $entityHydtrator = new ContainerEntityHydrator();
        $authService = new AuthenticationService($accountName, $accountKey);
        $client = new Client();
        return new StorageService($authService, $client, $entityHydtrator, $accountName, $accountKey, $httpProtocol);
    }
}