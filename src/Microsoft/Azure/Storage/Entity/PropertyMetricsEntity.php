<?php

namespace Microsoft\Azure\Storage\Entity;

class PropertyMetricsEntity implements PropertyMetricsEntityInterface
{
    /**
     * @var string
     */
    protected $version;
    /**
     * @var bool
     */
    protected $enabled;
    /**
     * @var bool
     */
    protected $includeApis;
    /**
     * @var RetentionPolicyEntity
     */
    protected $retentionPolicy;

    /**
     * PropertyMetricsEntity constructor.
     */
    public function __construct()
    {
        $this->setRetentionPolicy(new RetentionPolicyEntity());
    }
    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return PropertyMetricsEntityInterface
     */
    public function setVersion(string $version): PropertyMetricsEntityInterface
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     * @return PropertyMetricsEntityInterface
     */
    public function setEnabled(bool $enabled): PropertyMetricsEntityInterface
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isIncludeApis(): bool
    {
        return $this->includeApis;
    }

    /**
     * @param boolean $includeApis
     * @return PropertyMetricsEntityInterface
     */
    public function setIncludeApis(bool $includeApis): PropertyMetricsEntityInterface
    {
        $this->includeApis = $includeApis;
        return $this;
    }

    /**
     * @return RetentionPolicyEntity
     */
    public function getRetentionPolicy(): RetentionPolicyEntity
    {
        return $this->retentionPolicy;
    }

    /**
     * @param RetentionPolicyEntity $retentionPolicy
     * @return PropertyMetricsEntityInterface
     */
    public function setRetentionPolicy(RetentionPolicyEntity $retentionPolicy): PropertyMetricsEntityInterface
    {
        $this->retentionPolicy = $retentionPolicy;
        return $this;
    }
}
