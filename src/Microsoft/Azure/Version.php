<?php

namespace Microsoft\Azure;

/**
 * Class Version
 *
 * This class is to keep track of the version of this SDK.
 *
 * @package Microsoft\Azure
 */
final class Version
{
    const AZURE_SDK_VERSION = '0.0.1-alpha';
    const AZURE_API_VERSION = '2015-04-05';

    /**
     * Compares current version with provided version. It will return
     * 1 if the given version is newer, 0 if they are the same and -1
     * if the given version is older.
     *
     * @param string $version
     * @return int
     */
    public static function versionCompare(string $version): int
    {
        return version_compare($version, self::AZURE_SDK_VERSION);
    }
}