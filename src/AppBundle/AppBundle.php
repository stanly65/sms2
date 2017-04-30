<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    /**
     * Sets FOSUserBundle as a parent of your AppBundle.
     *
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}