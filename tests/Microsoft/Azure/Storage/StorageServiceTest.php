<?php

namespace Microsoft\Test\Azure\Storage;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Microsoft\Azure\Storage\Auth\AuthenticationService;
use Microsoft\Azure\Storage\Entity\ContainerEntityHydrator;
use Microsoft\Azure\Storage\Entity\ContainerEntityInterface;
use Microsoft\Azure\Storage\StorageService;

class StorageServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StorageService
     */
    protected $storageService;

    /**
     * Helper functionality to process dummy responses to mock
     * out the service for testing. It returns an array with
     * the HTTP Status Code ('httpStatus'), an array of headers
     * ('headers') and the response body ('body').
     *
     * @param string $filename
     * @return array
     * @todo This helper should be created outside the testsuite!
     */
    protected function parseResponseFiles(string $filename): array
    {
        $file = __DIR__ . '/_files/' . $filename . '.txt';
        if (!file_exists($file)) {
            $this->fail('File ' . basename($file) . ' is not found');
        }
        $response = file_get_contents($file);
        $responseData = explode(PHP_EOL, $response);
        $httpStatusLine = array_shift($responseData);
        $httpStatus = substr($httpStatusLine, 9, 3);
        $responseHeaders = [];
        $responseBody = [];
        $seen = false;
        foreach ($responseData as $responseLine) {
            if ('' === $responseLine) {
                $seen = true;
                continue;
            }
            if (!$seen) {
                list($key, $value) = explode(': ', $responseLine);
                $responseHeaders[$key] = $value;
            } else {
                $responseBody[] = ltrim($responseLine);
            }
        }
        $parsedResponse = [
            'httpStatus' => (int) $httpStatus,
            'headers' => $responseHeaders,
            'body' => implode(PHP_EOL, $responseBody),
        ];
        return $parsedResponse;
    }

    /**
     * Helper logic to create a StorageService allowing to load
     * custom Responses to test various use cases. If no use case
     * is provide, the service will be called.
     *
     * @param string $responseFile
     * @return StorageService
     * @todo This helper should be created outside the testsuite!
     */
    protected function createStorageService(string $responseFile = ''): StorageService
    {
        $clientOptions = [];
        if ('' !== $responseFile) {
            $response = $this->parseResponseFiles($responseFile);

            $mock = new MockHandler([
                new Response($response['httpStatus'], $response['headers'], $response['body'])
            ]);
            $handler = HandlerStack::create($mock);
            $clientOptions = ['handler' => $handler];
        }

        $accountName = 'foo';
        $accountKey = 'bar';
        $httpProtocol = StorageService::HTTP_PROTO_SEC;
        $authenticationService = new AuthenticationService($accountName, $accountKey);
        $client = new Client($clientOptions);
        $hydrator = new ContainerEntityHydrator();

        $storageService = new StorageService(
            $authenticationService,
            $client,
            $hydrator,
            $accountName,
            $accountKey,
            $httpProtocol
        );
        return $storageService;
    }

    /**
     * @expectedException \Microsoft\Azure\Common\Exception\NotFoundException
     * @covers \Microsoft\Azure\Storage\StorageService::listContainers
     */
    public function testServiceThrowsExceptionForWrongCredentials()
    {
        $storageService = $this->createStorageService('not_existing_service_response');
        $containers = $storageService->listContainers();
        $this->fail('Expected exception was not thrown');
    }
    
    /**
     * @expectedException \Microsoft\Azure\Common\Exception\NotFoundException
     * @covers \Microsoft\Azure\Storage\StorageService::listContainers
     */
    public function testServiceThrowsExceptionForDateTooOld()
    {
        $storageService = $this->createStorageService('date_too_old_response');
        $containers = $storageService->listContainers();
        $this->fail('Expected exception was not thrown');
    }

    /**
     * @covers \Microsoft\Azure\Storage\StorageService::listContainers
     */
    public function testServiceCanListContainers()
    {
        $storageService = $this->createStorageService('success_container_listing');
        $containers = $storageService->listContainers();
        $this->assertCount(3, $containers);
        return $containers->current();
    }

    /**
     * @param ContainerEntityInterface $containerEntity
     * @depends testServiceCanListContainers
     * @covers \Microsoft\Azure\Storage\Entity\ContainerEntity::getName
     */
    public function testContainerEntityContainsData(ContainerEntityInterface $containerEntity)
    {
        $this->assertInstanceOf('\\Microsoft\\Azure\\Storage\\Entity\\ContainerEntity', $containerEntity);
        $this->assertSame('Foo', $containerEntity->getName());
    }
}