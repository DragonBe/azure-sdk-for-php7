<?php

namespace Microsoft\Azure\Storage\Entity;

use Microsoft\Azure\Common\EntityInterface;

interface ContainerEntityInterface extends EntityInterface
{
    /**
     * Retrieves the name of the Container
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Retrieves the last modification date and time of the Container
     *
     * @return \DateTime
     */
    public function getLastModified(): \DateTime;

    /**
     * Retrieves the E-tag of the Container
     *
     * @return string
     */
    public function getEtag(): string;

    /**
     * Retrieves the lease status of the Container
     *
     * @return string
     */
    public function getLeaseStatus(): string;

    /**
     * Retrieves the lease state of the Container
     *
     * @return string
     */
    public function getLeaseState(): string;
}