<?php

namespace Microsoft\Azure\Storage\Entity;

use Microsoft\Azure\Common\EntityInterface;
use Microsoft\Azure\Common\XmlHydratorInterface;

class ContainerEntityHydrator implements XmlHydratorInterface
{
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
     * @todo Make this hydrator more generic to be used in more circumstances
     */
    public function hydrate(\SimpleXMLIterator $xmlElement, EntityInterface $object): EntityInterface
    {
        foreach ($xmlElement as $node) {
            if ('Properties' === $node->getName()) {
                $object = $this->hydrate($node, $object);
            }
            $method = 'set' . ucFirst(str_replace('-', '', $node->getName()));
            if (method_exists($object, $method)) {
                $value = $node->__toString();
                if ('Last-Modified' === $node->getName()) {
                    $value = new \DateTime($value);
                }
                $object->$method($value);
            }
        }
        return $object;
    }
}
