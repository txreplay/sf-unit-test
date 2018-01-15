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
        throw new Exception('Not implemented');
    }
    public function saveUser(User $user)
    {
        throw new Exception('Not implemented');
    }
    public function saveExchange(Exchange $exchange)
    {
        throw new Exception('Not implemented');
    }

}