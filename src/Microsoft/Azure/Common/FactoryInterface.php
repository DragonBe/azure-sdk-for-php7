<?php

namespace Microsoft\Azure\Common;

interface FactoryInterface
{
    /**
     * Factory that allows you to create new instances if required
     * 
     * @param string $accountName
     * @param string $accountKey
     * @param string $httpProtocol
     * @return mixed
     */
    public static function create($accountName, $accountKey, $httpProtocol);
}