<?php

namespace Microsoft\Azure\Storage;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Microsoft\Azure\Common\Exception\NotFoundException;
use Microsoft\Azure\Common\XmlHydratorInterface;
use Microsoft\Azure\Storage\Auth\AuthenticationService;
use Microsoft\Azure\Storage\Entity\ContainerEntity;

class StorageService
{
    const BLOP_API_URI = 'blob.core.windows.net';

    const HTTP_PROTO_SEC = 'https';
    const HTTP_PROTO_NORM = 'http';

    /**
     * @var string The name of the Microsoft Azure Storage account
     */
    protected $accountName;
    /**
     * @var string The key of the Microsoft Azure Storage account
     */
    protected $accountKey;
    /**
     * @var string
     */
    protected $httpProtocol;

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var XmlHydratorInterface
     */
    protected $hydrator;

    /**
     * StorageService constructor.
     *
     * @param AuthenticationService $authService
     * @param Client $client
     * @param XmlHydratorInterface $hydrator
     * @param string $accountName
     * @param string $accountKey
     * @param string $httpProtocol
     */
    public function __construct(
        AuthenticationService $authService,
        Client $client,
        XmlHydratorInterface $hydrator,
        string $accountName,
        string $accountKey,
        string $httpProtocol = self::HTTP_PROTO_SEC
    )
    {
        $this->authService = $authService;
        $this->client = $client;
        $this->hydrator = $hydrator;
        $this->accountName = $accountName;
        $this->accountKey = $accountKey;
        $this->httpProtocol = $httpProtocol;
    }

    /**
     * List all containers on the Blob storage
     * 
     * @return \SplObjectStorage
     * @throws NotFoundException
     */
    public function listContainers()
    {
        $url = sprintf(
            '%s://%s.%s/?comp=list',
            $this->httpProtocol,
            $this->accountName,
            self::BLOP_API_URI
        );
        $headers = $this->authService->getAuthorizationHeaders($url, 'GET');
        try {
            $result = $this->client->request('GET', $url, [
                'headers' => $headers,
            ]);
        } catch (ClientException $e) {
            throw new NotFoundException($e->getMessage());
        }
        $containerCollection = new \SplObjectStorage();

        $xml = (string) $result->getBody();

        $data = new \SimpleXMLIterator($xml);
        foreach ($data->Containers->Container as $container) {
            $containerObj = $this->hydrator->hydrate($container, new ContainerEntity());
            $containerCollection->attach($containerObj);
        }
        $containerCollection->rewind();
        return $containerCollection;
    }
}