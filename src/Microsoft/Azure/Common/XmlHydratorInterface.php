<?php

namespace Microsoft\Azure\Common;

interface XmlHydratorInterface
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
     * @param \SimpleXMLIterator $xmlElement
     * @param EntityInterface $object
     * @return EntityInterface
     */
    public function hydrate(\SimpleXMLIterator $xmlElement, EntityInterface $object): EntityInterface;
}