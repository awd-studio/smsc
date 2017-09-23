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

use Smsc\Settings\Settings;


/**
 * Class Message
 *
 * @package Smsc\Message
 */
class SmscBalance extends AbstractSmscService
{

    /**
     * Message constructor.
     *
     * @param Settings $settings
     * @param array    $options
     */
    public function __construct(Settings $settings, $options = [])
    {
        parent::__construct($settings, $options);

        $this->settings->mergeOptions([
            'cur' => true,
        ]);
    }


    /**
     * Set current API method.
     */
    public function setApiMethod()
    {
        $this->apiMethod = 'balance';
    }


    /**
     * Processing response.
     *
     * @return mixed
     */
    public function results()
    {
        return $this->getData()->getResponse();
    }
}
