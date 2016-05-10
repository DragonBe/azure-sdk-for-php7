<?php

namespace Microsoft\Azure\Storage\Entity;

class ContainerEntity implements ContainerEntityInterface
{
    /**
     * @var string The name of the Container
     */
    protected $name;
    /**
     * @var \DateTime The date and time of last modification
     */
    protected $lastModified;
    /**
     * @var string The E-tag of the container
     */
    protected $etag;
    /**
     * @var string The lease status of the container
     */
    protected $leaseStatus;
    /**
     * @var string The lease state of the container
     */
    protected $leaseState;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ContainerEntity
     */
    public function setName(string $name): ContainerEntity
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastModified(): \DateTime
    {
        return $this->lastModified;
    }

    /**
     * @param \DateTime $lastModified
     * @return ContainerEntity
     */
    public function setLastModified(\DateTime $lastModified): ContainerEntity
    {
        $this->lastModified = $lastModified;
        return $this;
    }

    /**
     * @return string
     */
    public function getEtag(): string
    {
        return $this->etag;
    }

    /**
     * @param string $etag
     * @return ContainerEntity
     */
    public function setEtag(string $etag): ContainerEntity
    {
        $this->etag = $etag;
        return $this;
    }

    /**
     * @return string
     */
    public function getLeaseStatus(): string
    {
        return $this->leaseStatus;
    }

    /**
     * @param string $leaseStatus
     * @return ContainerEntity
     */
    public function setLeaseStatus(string $leaseStatus): ContainerEntity
    {
        $this->leaseStatus = $leaseStatus;
        return $this;
    }

    /**
     * @return string
     */
    public function getLeaseState(): string
    {
        return $this->leaseState;
    }

    /**
     * @param string $leaseState
     * @return ContainerEntity
     */
    public function setLeaseState(string $leaseState): ContainerEntity
    {
        $this->leaseState = $leaseState;
        return $this;
    }
}
