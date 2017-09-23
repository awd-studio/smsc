<?php

/**
 * This file is part of SMSC PHP library for sending
 * short messages.
 *
 * @author    Anton Karpov <awd.com.ua@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/awd-studio/smsc
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