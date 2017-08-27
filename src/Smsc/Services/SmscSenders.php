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


/**
 * Class Message
 *
 * @package Smsc\Message
 */
class SmscSenders extends AbstractSmscService
{

    /**
     * Get current senders.
     */
    public function getSenders()
    {
        $this->addParams(['get' => true]);
    }


    /**
     * Set current API method.
     */
    public function setApiMethod()
    {
        $this->apiMethod = 'senders';
    }


    /**
     * Processing response.
     *
     * @return array
     */
    public function results()
    {
        return array_map(function ($sender) {
            return $sender->sender;
        }, (array) $this->getData()->getResponse());
    }
}
