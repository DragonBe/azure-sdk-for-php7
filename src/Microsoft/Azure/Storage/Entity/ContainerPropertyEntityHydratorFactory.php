<?php

namespace Microsoft\Azure\Storage\Entity;

class ContainerPropertyEntityHydratorFactory
{
    public static function create()
    {
        $logging = new PropertyLoggingEntity();
        $metrics = new PropertyMetricsEntity();
        $cors = new PropertyCorsRuleEntity();

        return new ContainerPropertyEntityHydrator($logging, $metrics, $cors);
    }

}