<?php

namespace Microsoft\Azure\Storage\Entity;

use Microsoft\Azure\Common\EntityInterface;

interface PropertyLoggingEntityInterface extends EntityInterface
{
    /**
     * @return string
     */
    public function getVersion(): string;

    /**
     * @param string $version
     * @return PropertyLoggingEntityInterface
     */
    public function setVersion(string $version): PropertyLoggingEntityInterface;

    /**
     * @return boolean
     */
    public function isRead(): bool;

    /**
     * @param boolean $read
     * @return PropertyLoggingEntityInterface
     */
    public function setRead(bool $read): PropertyLoggingEntityInterface;

    /**
     * @return boolean
     */
    public function isWrite(): bool;

    /**
     * @param boolean $write
     * @return PropertyLoggingEntityInterface
     */
    public function setWrite(bool $write): PropertyLoggingEntityInterface;

    /**
     * @return boolean
     */
    public function isDelete(): bool;

    /**
     * @param boolean $delete
     * @return PropertyLoggingEntityInterface
     */
    public function setDelete(bool $delete): PropertyLoggingEntityInterface;

    /**
     * @return RetentionPolicyEntity
     */
    public function getRetentionsPolicy(): RetentionPolicyEntity;

    /**
     * @param RetentionPolicyEntity $retentionPolicy
     * @return PropertyLoggingEntityInterface
     */
    public function setRetentionsPolicy(RetentionPolicyEntity $retentionPolicy): PropertyLoggingEntityInterface;

}