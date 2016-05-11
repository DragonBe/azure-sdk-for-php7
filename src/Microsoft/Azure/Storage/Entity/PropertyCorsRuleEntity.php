<?php

namespace Microsoft\Azure\Storage\Entity;

class PropertyCorsRuleEntity implements PropertyCorsRuleEntityInterface
{
    /**
     * @var string
     */
    protected $allowedOrigins;
    /**
     * @var string
     */
    protected $allowedMethods;
    /**
     * @var int
     */
    protected $maxAgeInSeconds;
    /**
     * @var string
     */
    protected $exposedHeaders;
    /**
     * @var string
     */
    protected $allowedHeaders;

    /**
     * @return string
     */
    public function getAllowedOrigins(): string
    {
        return $this->allowedOrigins;
    }

    /**
     * @param string $allowedOrigins
     * @return PropertyCorsRuleEntityInterface
     */
    public function setAllowedOrigins(string $allowedOrigins): PropertyCorsRuleEntityInterface
    {
        $this->allowedOrigins = $allowedOrigins;
        return $this;
    }

    /**
     * @return string
     */
    public function getAllowedMethods(): string
    {
        return $this->allowedMethods;
    }

    /**
     * @param string $allowedMethods
     * @return PropertyCorsRuleEntityInterface
     */
    public function setAllowedMethods(string $allowedMethods): PropertyCorsRuleEntityInterface
    {
        $this->allowedMethods = $allowedMethods;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxAgeInSeconds(): int
    {
        return $this->maxAgeInSeconds;
    }

    /**
     * @param int $maxAgeInSeconds
     * @return PropertyCorsRuleEntityInterface
     */
    public function setMaxAgeInSeconds(int $maxAgeInSeconds): PropertyCorsRuleEntityInterface
    {
        $this->maxAgeInSeconds = $maxAgeInSeconds;
        return $this;
    }

    /**
     * @return string
     */
    public function getExposedHeaders(): string
    {
        return $this->exposedHeaders;
    }

    /**
     * @param string $exposedHeaders
     * @return PropertyCorsRuleEntityInterface
     */
    public function setExposedHeaders(string $exposedHeaders): PropertyCorsRuleEntityInterface
    {
        $this->exposedHeaders = $exposedHeaders;
        return $this;
    }

    /**
     * @return string
     */
    public function getAllowedHeaders(): string
    {
        return $this->allowedHeaders;
    }

    /**
     * @param string $allowedHeaders
     * @return PropertyCorsRuleEntityInterface
     */
    public function setAllowedHeaders(string $allowedHeaders): PropertyCorsRuleEntityInterface
    {
        $this->allowedHeaders = $allowedHeaders;
        return $this;
    }
}
