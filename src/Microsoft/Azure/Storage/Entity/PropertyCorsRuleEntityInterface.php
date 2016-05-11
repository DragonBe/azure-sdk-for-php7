<?php

namespace Microsoft\Azure\Storage\Entity;

use Microsoft\Azure\Common\EntityInterface;

interface PropertyCorsRuleEntityInterface extends EntityInterface
{
    /**
     * @return string
     */
    public function getAllowedOrigins(): string;

    /**
     * @param string $allowedOrigins
     * @return PropertyCorsRuleEntityInterface
     */
    public function setAllowedOrigins(string $allowedOrigins): PropertyCorsRuleEntityInterface;

    /**
     * @return string
     */
    public function getAllowedMethods(): string;

    /**
     * @param string $allowedMethods
     * @return PropertyCorsRuleEntityInterface
     */
    public function setAllowedMethods(string $allowedMethods): PropertyCorsRuleEntityInterface;

    /**
     * @return int
     */
    public function getMaxAgeInSeconds(): int;

    /**
     * @param int $maxAgeInSeconds
     * @return PropertyCorsRuleEntityInterface
     */
    public function setMaxAgeInSeconds(int $maxAgeInSeconds): PropertyCorsRuleEntityInterface;

    /**
     * @return string
     */
    public function getExposedHeaders(): string;

    /**
     * @param string $exposedHeaders
     * @return PropertyCorsRuleEntityInterface
     */
    public function setExposedHeaders(string $exposedHeaders): PropertyCorsRuleEntityInterface;

    /**
     * @return string
     */
    public function getAllowedHeaders(): string;

    /**
     * @param string $allowedHeaders
     * @return PropertyCorsRuleEntityInterface
     */
    public function setAllowedHeaders(string $allowedHeaders): PropertyCorsRuleEntityInterface;
}
