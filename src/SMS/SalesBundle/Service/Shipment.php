<?php

namespace SMS\SalesBundle\Service;

use Exception;
use Symfony\Component\DependencyInjection\Container;

class Shipment
{
    /**
     * The instance of Container.
     *
     * @var Container
     */
    private $container;

    /**
     * Array of the service identifiers.
     *
     * @var array
     */
    private $methods;

    /**
     * Initializes properties.
     *
     * @param Container $container
     * @param array $methods
     */
    public function __construct(Container $container, array $methods)
    {
        $this->container = $container;
        $this->methods = $methods;
    }

    /**
     * Returns all shipment_method tagged services.
     *
     * @return array
     * @throws Exception
     */
    public function getShipmentMethods()
    {
        $methods = [];
        foreach ($this->methods as $method) {
            $methods[] = $this->container->get($method);
        }

        return $methods;
    }
}
