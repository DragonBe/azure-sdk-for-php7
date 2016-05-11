<?php

namespace Microsoft\Azure\Storage\Entity;

use Microsoft\Azure\Common\EntityInterface;

interface ContainerPropertyEntityInterface extends EntityInterface
{
    /**
     * @return PropertyLoggingEntityInterface
     */
    public function getLogging(): PropertyLoggingEntityInterface;

    /**
     * @param PropertyLoggingEntityInterface $logging
     * @return ContainerPropertyEntityInterface
     */
    public function setLogging(PropertyLoggingEntityInterface $logging): ContainerPropertyEntityInterface;

    /**
     * @return PropertyMetricsEntity
     */
    public function getHourMetrics(): PropertyMetricsEntity;

    /**
     * @param PropertyMetricsEntity $hourMetrics
     * @return ContainerPropertyEntityInterface
     */
    public function setHourMetrics(PropertyMetricsEntity $hourMetrics): ContainerPropertyEntityInterface;

    /**
     * @return PropertyMetricsEntity
     */
    public function getMinuteMetrics(): PropertyMetricsEntity;

    /**
     * @param PropertyMetricsEntity $minuteMetrics
     * @return ContainerPropertyEntityInterface
     */
    public function setMinuteMetrics(PropertyMetricsEntity $minuteMetrics): ContainerPropertyEntityInterface;

    /**
     * @return PropertyCorsRuleEntityInterface
     */
    public function getCors(): PropertyCorsRuleEntityInterface;

    /**
     * @param PropertyCorsRuleEntityInterface $cors
     * @return ContainerPropertyEntityInterface
     */
    public function setCors(PropertyCorsRuleEntityInterface $cors): ContainerPropertyEntityInterface;
}
