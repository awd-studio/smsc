<?php
/**
 * Created by PhpStorm.
 * User: awd
 * Date: 20.08.17
 * Time: 4:30
 */

namespace Smsc\Request;


use Smsc\Services\SmscService;


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
     * @param SmscService $service
     *
     * @return string
     * @throws \Exception
     */
    public function execute(SmscService $service): string;

}