<?php
/**
 * Created by PhpStorm.
 * User: awd
 * Date: 20.08.17
 * Time: 4:30
 */

namespace Smsc\Request;


use Smsc\Services\AbstractSmscService;


/**
 * Interface RequestInterface
 *
 * @package Smsc\RequestInterface
 */
interface RequestInterface
{

    /**
     * Execute request.
     *
     * @param AbstractSmscService $service
     *
     * @return string
     * @throws \Exception
     */
    public function execute(AbstractSmscService $service);

}