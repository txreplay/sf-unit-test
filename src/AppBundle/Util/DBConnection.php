<?php

namespace AppBundle\Util;

use PHPUnit\Framework\Exception;

class DBConnection
{
    function __construct()
    {
        //
    }
    public function saveProduct(Product $product)
    {
        return new \Exception('Not implemented');
    }
    public function saveUser(User $user)
    {
        return new \Exception('Not implemented');
    }
    public function saveExchange(Exchange $exchange)
    {
        return new \Exception('Not implemented');
    }

}