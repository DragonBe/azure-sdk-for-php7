<?php

namespace Microsoft\Azure\Storage\Entity;

class ContainerPropertyEntity implements ContainerPropertyEntityInterface
{
    /**
     * @var PropertyLoggingEntityInterface
     */
    protected $logging;
    /**
     * @var PropertyMetricsEntityInterface
     */
    protected $hourMetrics;
    /**
     * @var PropertyMetricsEntityInterface
     */
    protected $minuteMetrics;
    /**
     * @var PropertyCorsRuleEntityInterface
     */
    protected $cors;

    /**
     * @return PropertyLoggingEntityInterface
     */
    public function getLogging(): PropertyLoggingEntityInterface
    {
        return $this->logging;
    }

    /**
     * @param PropertyLoggingEntityInterface $logging
     * @return ContainerPropertyEntityInterface
     */
    public function setLogging(PropertyLoggingEntityInterface $logging): ContainerPropertyEntityInterface
    {
        $this->logging = $logging;
        return $this;
    }

    /**
     * @return PropertyMetricsEntity
     */
    public function getHourMetrics(): PropertyMetricsEntity
    {
        return $this->hourMetrics;
    }

    /**
     * @param PropertyMetricsEntity $hourMetrics
     * @return ContainerPropertyEntityInterface
     */
    public function setHourMetrics(PropertyMetricsEntity $hourMetrics): ContainerPropertyEntityInterface
    {
        $this->hourMetrics = $hourMetrics;
        return $this;
    }

    /**
     * @return PropertyMetricsEntity
     */
    public function getMinuteMetrics(): PropertyMetricsEntity
    {
        return $this->minuteMetrics;
    }

    /**
     * @param PropertyMetricsEntity $minuteMetrics
     * @return ContainerPropertyEntityInterface
     */
    public function setMinuteMetrics(PropertyMetricsEntity $minuteMetrics): ContainerPropertyEntityInterface
    {
        $this->minuteMetrics = $minuteMetrics;
        return $this;
    }

    /**
     * @return PropertyCorsRuleEntityInterface
     */
    public function getCors(): PropertyCorsRuleEntityInterface
    {
        return $this->cors;
    }

    /**
     * @param PropertyCorsRuleEntityInterface $cors
     * @return ContainerPropertyEntityInterface
     */
    public function setCors(PropertyCorsRuleEntityInterface $cors): ContainerPropertyEntityInterface
    {
        $this->cors = $cors;
        return $this;
    }
}
