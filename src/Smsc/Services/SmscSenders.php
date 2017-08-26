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
use Smsc\Request\CurlRequest;
use Smsc\Response\Response;


/**
 * Class Message
 *
 * @package Smsc\Message
 */
class SmscSenders extends AbstractSmscService
{

    /**
     * Collect parameters for query.
     */
    public function getParams()
    {
        return parent::getParams() + [
                'get' => true,
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
        $this->setApiMethod('senders');

        if (!isset($driver)) {
            $driver = new CurlRequest;
        }

        $response = $driver->execute($this);

        return new Response($response, $this->getApiMethod());
    }
}