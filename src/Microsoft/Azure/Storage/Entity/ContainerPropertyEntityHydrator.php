<?php

namespace Microsoft\Azure\Storage\Entity;

use Microsoft\Azure\Common\EntityInterface;
use Microsoft\Azure\Common\XmlHydratorInterface;

class ContainerPropertyEntityHydrator implements XmlHydratorInterface
{
    /**
     * @var PropertyLoggingEntityInterface
     */
    protected $logging;
    /**
     * @var PropertyMetricsEntityInterface
     */
    protected $metrics;
    /**
     * @var PropertyCorsRuleEntityInterface
     */
    protected $cors;

    /**
     * ContainerPropertyEntityHydrator constructor.
     *
     * @param PropertyLoggingEntityInterface $logging
     * @param PropertyMetricsEntityInterface $metrics
     * @param PropertyCorsRuleEntityInterface $cors
     */
    public function __construct(
        PropertyLoggingEntityInterface $logging,
        PropertyMetricsEntityInterface $metrics,
        PropertyCorsRuleEntityInterface $cors
    )
    {
        $this->logging = $logging;
        $this->metrics = $metrics;
        $this->cors = $cors;
    }
    /**
     * Extracts values from an object and returns an array
     *
     * @param EntityInterface $object
     * @return array
     */
    public function extract(EntityInterface $object): array
    {
        // TODO: Implement extract() method.
    }

    /**
     * Hydrates an object with given data
     *
     * @param \SimpleXMLIterator $xmlElement
     * @param EntityInterface $object
     * @return EntityInterface
     * @todo Make this more cleaner and generic
     */
    public function hydrate(\SimpleXMLIterator $xmlElement, EntityInterface $object): EntityInterface
    {
        $this->logging
            ->setVersion((string) $xmlElement->Logging->Version)
            ->setRead('true' === (string) $xmlElement->Logging->Read)
            ->setWrite('true' === (string) $xmlElement->Logging->Write)
            ->setDelete('true' === (string) $xmlElement->Logging->Delete);
        if ('false' !== (string) $xmlElement->Logging->RetentionPolicy->Enabled) {
            $this->logging->getRetentionsPolicy()
                ->setEnabled(true)
                ->setDays((int) $xmlElement->Logging->RetentionPolicy->Days);
        }

        $hm = clone $this->metrics;
        $hm->setVersion((string) $xmlElement->HourMetrics->Version)
            ->setEnabled('true' === (string) $xmlElement->HourMetrics->Enabled)
            ->setIncludeApis('true' === (string) $xmlElement->HourMetrics->IncludeAPIs);
        if ('false' !== (string) $xmlElement->HourMetrics->RetentionPolicy->Enabled) {
            $hm->getRetentionPolicy()
                ->setEnabled(true)
                ->setDays((int) $xmlElement->HourMetrics->RetentionPolicy->Days);
        }
        $this->metrics->setVersion((string) $xmlElement->MinuteMetrics->Version)
            ->setEnabled('true' === (string) $xmlElement->MinuteMetrics->Enabled)
            ->setIncludeApis('true' === (string) $xmlElement->MinuteMetrics->IncludeAPIs);
        if ('false' !== (string) $xmlElement->MinuteMetrics->RetentionPolicy->Enabled) {
            $this->metrics->getRetentionPolicy()
                ->setEnabled(true)
                ->setDays((int) $xmlElement->HourMetrics->RetentionPolicy->Days);
        }

        $this->cors->setAllowedOrigins((string) $xmlElement->Cors->CorsRule->AllowedOrigins)
            ->setAllowedMethods((string) $xmlElement->Cors->CorsRule->AllowedMethods)
            ->setMaxAgeInSeconds((int) $xmlElement->Cors->CorsRule->MaxAgeInSeconds)
            ->setExposedHeaders((string) $xmlElement->Cors->CorsRule->ExposedHeaders)
            ->setAllowedHeaders((string) $xmlElement->Cors->CorsRule->AllowedHeaders);

        $object->setLogging($this->logging)
            ->setHourMetrics($hm)
            ->setMinuteMetrics($this->metrics)
            ->setCors($this->cors);

        return $object;
    }

}