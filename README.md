# Microsoft Azure SDK for PHP 7

With the release of [PHP 7](http://www.php.net) on December 3, 2015 it's important that tools that depend on this technology are using the latest versions as quickly as possible. Also because the original [Azure-SDK-For-PHP](https://github.com/Azure/azure-sdk-for-php) is depending on legacy [PEAR](http://pear.php.net) library components, so an upgrade was required.

Also with the rebranding of "Windows Azure" to "Microsoft Azure" in 2015, it's important that this rebranding is also present within the SDK.

[![Build Status](https://status.continuousphp.com/git-hub/DragonBe/azure-sdk-for-php7?token=ddcc4e1e-ac10-45e9-be14-150a7a5ecfd2&branch=master)](https://continuousphp.com/git-hub/DragonBe/azure-sdk-for-php7)

## Goals

  1. Rebuild the SDK from scratch using native PHP 7 functionality
  2. Reduce dependencies by using factories and Dependency Injection (DI)
  3. Provide quality tests to ensure the highest quality
  4. Make it a [Composer](https://getcomposer.org) package for easy adoption

## Installation

```
git clone https://github.com/DragonBe/azure-sdk-for-php7.git
cd azure-sdk-for-php7/
composer install
```

At this point of development, no [Packagist](https://packagist.org) package is being provided. Once the minimal functionality roadmap is completed, a package will be created to be used with [Composer](https://getcomposer.org).

## Minimal Functionaliy Roadmap

This is the initial roadmap to build service functionality, split up by components available in Microsoft Azure services.

  - [Microsoft Azure Storage Service](https://azure.microsoft.com/en-us/documentation/services/storage/)
  - [Microsoft Azure App Service](https://azure.microsoft.com/en-us/documentation/services/app-service/)
  - [Microsoft Azure Search](https://azure.microsoft.com/en-us/documentation/services/search/)
  - [Microsoft Azure DocumentDB](https://azure.microsoft.com/en-us/documentation/services/documentdb/)
  - [Microsoft Azure Schedular](https://azure.microsoft.com/en-us/documentation/services/scheduler/)

More services need to be added, but these forementioned services are a requirement to give this project a minimal mass to be viable for the public audience. To see an overview of available services, please consult [Microsoft Azure website](https://azure.microsoft.com).

## License

This software is released under [MIT license](LICENSE). Even though this SDK is developed for Microsoft Azure services, it is in no way related to [Microsoft](https://www.microsoft.com), [Microsoft Azure](https://azure.microsoft.com) or its partners.