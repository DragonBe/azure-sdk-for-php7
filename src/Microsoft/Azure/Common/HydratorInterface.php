<?php

namespace Microsoft\Azure\Common;

interface HydratorInterface
{
    /**
     * Extracts values from an object and returns an array
     *
     * @param EntityInterface $object
     * @return array
     */
    public function extract(EntityInterface $object): array;

    /**
     * Hydrates an object with given data
     * 
     * @param array $array
     * @param EntityInterface $object
     * @return EntityInterface
     */
    public function hydrate(array $array, EntityInterface $object): EntityInterface;
}