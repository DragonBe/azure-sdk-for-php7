<?php

namespace Microsoft\Azure\Storage\Entity;

class PropertyLoggingEntity implements PropertyLoggingEntityInterface
{
    /**
     * @var string
     */
    protected $version;
    /**
     * @var bool
     */
    protected $read;
    /**
     * @var bool
     */
    protected $write;
    /**
     * @var bool
     */
    protected $delete;
    /**
     * @var RetentionPolicyEntity
     */
    protected $retentionPolicy;

    /**
     * PropertyLoggingEntity constructor.
     */
    public function __construct()
    {
        $this->setRetentionsPolicy(new RetentionPolicyEntity());
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
     * @return PropertyLoggingEntityInterface
     */
    public function setVersion(string $version): PropertyLoggingEntityInterface
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isRead(): bool
    {
        return $this->read;
    }

    /**
     * @param boolean $read
     * @return PropertyLoggingEntityInterface
     */
    public function setRead(bool $read): PropertyLoggingEntityInterface
    {
        $this->read = $read;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isWrite(): bool
    {
        return $this->write;
    }

    /**
     * @param boolean $write
     * @return PropertyLoggingEntityInterface
     */
    public function setWrite(bool $write): PropertyLoggingEntityInterface
    {
        $this->write = $write;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDelete(): bool
    {
        return $this->delete;
    }

    /**
     * @param boolean $delete
     * @return PropertyLoggingEntityInterface
     */
    public function setDelete(bool $delete): PropertyLoggingEntityInterface
    {
        $this->delete = $delete;
        return $this;
    }

    /**
     * @return RetentionPolicyEntity
     */
    public function getRetentionsPolicy(): RetentionPolicyEntity
    {
        return $this->retentionPolicy;
    }

    /**
     * @param RetentionPolicyEntity $retentionPolicy
     * @return PropertyLoggingEntityInterface
     */
    public function setRetentionsPolicy(RetentionPolicyEntity $retentionPolicy): PropertyLoggingEntityInterface
    {
        $this->retentionPolicy = $retentionPolicy;
        return $this;
    }

}