<?php

namespace Microsoft\Azure\Storage\Entity;

use Microsoft\Azure\Common\EntityInterface;

interface PropertyMetricsEntityInterface extends EntityInterface
{
    /**
     * @return string
     */
    public function getVersion(): string;

    /**
     * @param string $version
     * @return PropertyMetricsEntityInterface
     */
    public function setVersion(string $version): PropertyMetricsEntityInterface;

    /**
     * @return boolean
     */
    public function isEnabled(): bool;

    /**
     * @param boolean $enabled
     * @return PropertyMetricsEntityInterface
     */
    public function setEnabled(bool $enabled): PropertyMetricsEntityInterface;

    /**
     * @return boolean
     */
    public function isIncludeApis(): bool;

    /**
     * @param boolean $includeApis
     * @return PropertyMetricsEntityInterface
     */
    public function setIncludeApis(bool $includeApis): PropertyMetricsEntityInterface;

    /**
     * @return RetentionPolicyEntity
     */
    public function getRetentionPolicy(): RetentionPolicyEntity;

    /**
     * @param RetentionPolicyEntity $retentionPolicy
     * @return PropertyMetricsEntityInterface
     */
    public function setRetentionPolicy(RetentionPolicyEntity $retentionPolicy): PropertyMetricsEntityInterface;
}
