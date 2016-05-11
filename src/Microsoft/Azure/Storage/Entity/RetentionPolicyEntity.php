<?php

namespace Microsoft\Azure\Storage\Entity;

class RetentionPolicyEntity implements RetentionPolicyEntityInterface
{
    /**
     * @var bool
     */
    protected $enabled = false;
    /**
     * @var int
     */
    protected $days = 0;

    /**
     * @return boolean
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     * @return RetentionPolicyEntityInterface
     */
    public function setEnabled(bool $enabled = true): RetentionPolicyEntityInterface
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return int
     */
    public function getDays(): int
    {
        return $this->days;
    }

    /**
     * @param int $days
     * @return RetentionPolicyEntityInterface
     */
    public function setDays(int $days): RetentionPolicyEntityInterface
    {
        $this->days = $days;
        return $this;
    }

}