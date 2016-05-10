<?php

namespace Microsoft\Test\Azure;

use Microsoft\Azure\Version;

class VersionTest extends \PHPUnit_Framework_TestCase
{
    public function testVersionIsNewer()
    {
        $this->assertSame(-1, Version::versionCompare('0.0.0'));
    }

    public function testVersionIsSame()
    {
        $this->assertSame(0, Version::versionCompare(Version::AZURE_SDK_VERSION));
    }

    public function testVersionIsOlder()
    {
        $this->assertSame(1, Version::versionCompare('999.999.999'));
    }
}