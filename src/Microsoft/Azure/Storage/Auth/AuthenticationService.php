<?php

namespace Microsoft\Azure\Storage\Auth;
use Microsoft\Azure\Version;

/**
 * Class AuthenticationService
 *
 * This class provides all required functionality to authenticate
 * for Microsoft Azure Storage services (Blob, Queue and Tables).
 *
 * @package Microsoft\Azure\Storage\Auth
 * @link https://msdn.microsoft.com/en-us/library/azure/dd179428.aspx
 */
class AuthenticationService
{
    const HTTP_USER_AGENT = 'Azure-SDK-For-PHP7';
    const AZURE_STORAGE_BLOB_URI = 'blob.core.windows.net';

    /**
     * @var string The name of your Azure Storage account
     */
    protected $accountName;
    /**
     * @var string The key of your Azure Storage account
     */
    protected $accountKey;

    /**
     * AuthenticationService constructor.
     *
     * @param string $accountName
     * @param string $accountKey
     */
    public function __construct(string $accountName, string $accountKey)
    {
        $this->accountName = $accountName;
        $this->accountKey = $accountKey;
    }

    /**
     * Creates the authorization headers to connect to Microsoft Azure Storage
     * services using the REST API
     *
     * @param string $url
     * @param string $httpVerb
     * @return array
     */
    public function getAuthorizationHeaders(string $url, string $httpVerb = 'GET'): array
    {
        $header = [
            'User-Agent' => self::HTTP_USER_AGENT . '/' . Version::AZURE_SDK_VERSION,
            'X-Ms-Version' => Version::AZURE_API_VERSION,
            'Date' => $this->getUtcDate(),
            'Authorization' => $this->createAuthorizationHeader($url, $httpVerb),
            'Host' => $this->accountName . '.' . self::AZURE_STORAGE_BLOB_URI,
            'Accept-Encoding' => 'gzip, deflate',
        ];
        return $header;
    }
    
    /**
     * Create a signature based on the headers and system headers
     *
     * @param string $httpVerb
     * @param string $url
     * @return string
     * @link https://msdn.microsoft.com/en-us/library/azure/dd179428.aspx
     */
    protected function createAuthorizationHeader(string $url, string $httpVerb = 'GET'): string
    {
        $date = $this->getUtcDate();
        $allHeaders = array_merge(
            ['HttpVerb' => $httpVerb],
            $this->getSignatureHeaders($date),
            array_map(function ($value, $key) {
                return $key . ':' . $value;
            }, $this->getCanonicalHeaders(), array_keys($this->getCanonicalHeaders())),
            $this->getCanonicalResourceHeaders($url)
        );
        $signatureString = implode("\n", array_values($allHeaders));

        return 'SharedKey ' . $this->accountName . ':' . $this->createSignature($signatureString);
    }

    /**
     * Creates the signature for authentication to Microsoft Azure Storage Services
     * 
     * @param string $signatureString
     * @return string
     */
    protected function createSignature(string $signatureString): string
    {
        return base64_encode(
            hash_hmac('sha256', $signatureString, base64_decode($this->accountKey), true)
        );
    }

    /**
     * Assembles the canonical headers for Microsoft Azure Storage Services
     * 
     * @return array
     */
    protected function getCanonicalHeaders(): array
    {
        return [
            'x-ms-version' => Version::AZURE_API_VERSION,
        ];
    }

    /**
     * Creates canonical resource headers for creating the authentication
     * signature.
     * 
     * @param string $url
     * @return array
     */
    protected function getCanonicalResourceHeaders(string $url): array
    {
        $canonicalResourceHeaders = [
            'resource' => '/' . $this->accountName . parse_url($url, PHP_URL_PATH),
            'params' => $this->parseUrlParams(parse_url($url, PHP_URL_QUERY)),
        ];
        return array_values($canonicalResourceHeaders);
    }

    /**
     * The required headers required for creating the authentication
     * signature.
     * 
     * @param string $date
     * @return array
     */
    protected function getSignatureHeaders(string $date): array
    {
        $signatureHeaders = [
            'Content-Encoding' => NULL,
            'Content-Language' => NULL,
            'Content-Length' => NULL,
            'Content-MD5' => NULL,
            'Content-Type' => NULL,
            'Date' => $date,
            'If-Modified-Since ' => NULL,
            'If-Match' => NULL,
            'If-None-Match' => NULL,
            'If-Unmodified-Since' => NULL,
            'Range' => NULL,
        ];
        return $signatureHeaders;
    }

    /**
     * Parse the parameters on the URL
     * 
     * @param string $params
     * @return string
     */
    protected function parseUrlParams(string $params): string
    {
        $string = str_replace('=', ':', $params);
        return $string;
    }

    /**
     * Create a GMT timestamp for usage on Azure Services
     * 
     * @param string|null $timestamp
     * @return string
     */
    public static function getUtcDate(string $timestamp = null): string
    {
        $tz = date_default_timezone_get();
        date_default_timezone_set('GMT');

        if (is_null($timestamp)) {
            $timestamp = time();
        }
        $returnValue = date('D, d M Y H:i:s T', $timestamp);
        date_default_timezone_set($tz);
        return $returnValue;
    }
}
