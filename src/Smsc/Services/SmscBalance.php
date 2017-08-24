<?php

/**
 * This file is part of SMSC PHP library for sending
 * short messages.
 *
 * @author    Anton Karpov <awd.com.ua@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/awd-studio/smsc
 */

namespace Smsc\Services;


use Smsc\Request\RequestInterface;
use Smsc\Request\SmscCurlRequest;
use Smsc\Response\Response;


/**
 * Class Message
 *
 * @package Smsc\Message
 */
class SmscBalance extends SmscService
{

    /**
     * Collect parameters for query.
     */
    public function getParams()
    {
        return parent::getParams() + [
                'cur' => true,
            ];
    }


    /**
     * Check balance.
     *
     * @param RequestInterface|null $driver RequestInterface class name.
     *
     * @return Response
     */
    public function send(RequestInterface $driver = null)
    {
        $this->setApiMethod('balance');

        if (!isset($driver)) {
            $driver = new SmscCurlRequest;
        }

        $response = $driver->execute($this);

        return new Response($response, $this->getApiMethod());
    }
}