<?php

namespace Microsoft\Azure\Storage\Entity;

use Microsoft\Azure\Common\EntityInterface;

interface RetentionPolicyEntityInterface extends EntityInterface
{
    /**
     * @return boolean
     */
    public function isEnabled(): bool;

    /**
     * @param boolean $enabled
     * @return RetentionPolicyEntityInterface
     */
    public function setEnabled(bool $enabled = true): RetentionPolicyEntityInterface;

    /**
     * @return int
     */
    public function getDays(): int;

    /**
     * @param int $days
     * @return RetentionPolicyEntityInterface
     */
    public function setDays(int $days): RetentionPolicyEntityInterface;

}