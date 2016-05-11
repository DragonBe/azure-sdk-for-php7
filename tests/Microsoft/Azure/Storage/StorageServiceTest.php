<?php

namespace Microsoft\Test\Azure\Storage;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Microsoft\Azure\Storage\Auth\AuthenticationService;
use Microsoft\Azure\Storage\Entity\ContainerEntityHydrator;
use Microsoft\Azure\Storage\Entity\ContainerEntityInterface;
use Microsoft\Azure\Storage\Entity\ContainerPropertyEntity;
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

    /**
     * @covers \Microsoft\Azure\Storage\StorageService::getBlobStorageProperties
     */
    public function testRetrieveContainerPropertiesWithCorsSet()
    {
        $storageService = $this->createStorageService('success_container_properties_with_cors');
        $properties = $storageService->getBlobStorageProperties();
        $this->assertInstanceOf('\\Microsoft\\Azure\\Storage\\Entity\\ContainerPropertyEntityInterface', $properties);

        $this->assertInstanceOf('\\Microsoft\\Azure\\Storage\\Entity\\PropertyLoggingEntityInterface', $properties->getLogging());
        $this->assertSame('1.0', $properties->getLogging()->getVersion());
        $this->assertFalse($properties->getLogging()->isRead());
        $this->assertTrue($properties->getLogging()->isWrite());
        $this->assertTrue($properties->getLogging()->isDelete());
        $this->assertTrue($properties->getLogging()->getRetentionsPolicy()->isEnabled());
        $this->assertSame(7, $properties->getLogging()->getRetentionsPolicy()->getDays());

        $this->assertInstanceOf('\\Microsoft\\Azure\\Storage\\Entity\\PropertyMetricsEntityInterface', $properties->getHourMetrics());
        $this->assertSame('1.0', $properties->getHourMetrics()->getVersion());
        $this->assertTrue($properties->getHourMetrics()->isEnabled());
        $this->assertFalse($properties->getHourMetrics()->isIncludeApis());
        $this->assertTrue($properties->getHourMetrics()->getRetentionPolicy()->isEnabled());
        $this->assertSame(7, $properties->getHourMetrics()->getRetentionPolicy()->getDays());

        $this->assertInstanceOf('\\Microsoft\\Azure\\Storage\\Entity\\PropertyMetricsEntityInterface', $properties->getMinuteMetrics());
        $this->assertSame('1.0', $properties->getMinuteMetrics()->getVersion());
        $this->assertTrue($properties->getMinuteMetrics()->isEnabled());
        $this->assertTrue($properties->getMinuteMetrics()->isIncludeApis());
        $this->assertTrue($properties->getMinuteMetrics()->getRetentionPolicy()->isEnabled());
        $this->assertSame(7, $properties->getMinuteMetrics()->getRetentionPolicy()->getDays());

        $this->assertInstanceOf('\\Microsoft\\Azure\\Storage\\Entity\\PropertyCorsRuleEntityInterface', $properties->getCors());
        $this->assertSame('http://www.fabrikam.com,http://www.contoso.com', $properties->getCors()->getAllowedOrigins());
        $this->assertSame('GET,PUT', $properties->getCors()->getAllowedMethods());
        $this->assertSame('x-ms-meta-data*,x-ms-meta-customheader', $properties->getCors()->getExposedHeaders());
        $this->assertSame('x-ms-meta-target*,x-ms-meta-customheader', $properties->getCors()->getAllowedHeaders());
    }

    /**
     * @covers \Microsoft\Azure\Storage\StorageService::getBlobStorageProperties
     */
    public function testRetrieveContainerPropertiesWithOutCorsSet()
    {
        $storageService = $this->createStorageService('success_container_properties_without_cors');
        $properties = $storageService->getBlobStorageProperties();
        $this->assertInstanceOf('\\Microsoft\\Azure\\Storage\\Entity\\ContainerPropertyEntityInterface', $properties);

        $this->assertInstanceOf('\\Microsoft\\Azure\\Storage\\Entity\\PropertyLoggingEntityInterface', $properties->getLogging());
        $this->assertSame('1.0', $properties->getLogging()->getVersion());
        $this->assertFalse($properties->getLogging()->isRead());
        $this->assertTrue($properties->getLogging()->isWrite());
        $this->assertTrue($properties->getLogging()->isDelete());
        $this->assertTrue($properties->getLogging()->getRetentionsPolicy()->isEnabled());
        $this->assertSame(7, $properties->getLogging()->getRetentionsPolicy()->getDays());

        $this->assertInstanceOf('\\Microsoft\\Azure\\Storage\\Entity\\PropertyMetricsEntityInterface', $properties->getHourMetrics());
        $this->assertSame('1.0', $properties->getHourMetrics()->getVersion());
        $this->assertTrue($properties->getHourMetrics()->isEnabled());
        $this->assertFalse($properties->getHourMetrics()->isIncludeApis());
        $this->assertTrue($properties->getHourMetrics()->getRetentionPolicy()->isEnabled());
        $this->assertSame(7, $properties->getHourMetrics()->getRetentionPolicy()->getDays());

        $this->assertInstanceOf('\\Microsoft\\Azure\\Storage\\Entity\\PropertyMetricsEntityInterface', $properties->getMinuteMetrics());
        $this->assertSame('1.0', $properties->getMinuteMetrics()->getVersion());
        $this->assertTrue($properties->getMinuteMetrics()->isEnabled());
        $this->assertTrue($properties->getMinuteMetrics()->isIncludeApis());
        $this->assertTrue($properties->getMinuteMetrics()->getRetentionPolicy()->isEnabled());
        $this->assertSame(7, $properties->getMinuteMetrics()->getRetentionPolicy()->getDays());

        $this->assertInstanceOf('\\Microsoft\\Azure\\Storage\\Entity\\PropertyCorsRuleEntityInterface', $properties->getCors());
        $this->assertSame('', $properties->getCors()->getAllowedOrigins());
        $this->assertSame('', $properties->getCors()->getAllowedMethods());
        $this->assertSame('', $properties->getCors()->getExposedHeaders());
        $this->assertSame('', $properties->getCors()->getAllowedHeaders());
    }
}