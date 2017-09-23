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
class SmscMessage extends AbstractSmscService
{

    /**
     * Phones list.
     * You can set list of phones, separated by coma.
     *
     * @var string
     */
    protected $phones;

    /**
     * Message.
     *
     * @var string
     */
    protected $message;


    /**
     * Message constructor.
     *
     * @param Settings $settings
     * @param string   $phones
     * @param string   $message
     * @param array    $options
     */
    public function __construct(Settings $settings, $phones = '', $message = '', $options = [])
    {
        parent::__construct($settings, $options);

        $this->phones  = $phones;
        $this->message = $message;

        $this->settings->mergeOptions([
            'phones' => $this->phones,
            'mes'    => $this->message,
        ]);
    }


    /**
     * MMS message.
     *
     * @param string $subj
     */
    public function mms($subj = '')
    {
        $this->settings->mergeOptions(['mms' => true]);

        if (!empty($subj)) {
            $this->settings->mergeOptions(['subj' => $subj]);
        }
    }


    /**
     * E-mail message.
     *
     * @param string $subj
     */
    public function email($subj = '')
    {
        $this->settings->mergeOptions(['mail' => true]);

        if (!empty($subj)) {
            $this->settings->mergeOptions(['subj' => $subj]);
        }
    }


    /**
     * HLR message.
     */
    public function hlr()
    {
        $this->settings->mergeOptions(['hlr' => true]);
    }


    /**
     * Flash SMS.
     */
    public function flash()
    {
        $this->settings->mergeOptions(['flash' => true]);
    }


    /**
     * Push SMS.
     */
    public function push()
    {
        $this->settings->mergeOptions(['push' => true]);
    }


    /**
     * Ping SMS.
     */
    public function ping()
    {
        $this->settings->mergeOptions(['ping' => true]);
    }


    /**
     * Viber message.
     */
    public function viber()
    {
        $this->settings->mergeOptions(['viber' => true]);
    }

    /**
     * Call message.
     *
     * m  – мужской голос (по умолчанию).
     * m2 – мужской альтернативный голос.
     * w  – женский голос.
     * w2 – женский альтернативный голос 1.
     * w3 – женский альтернативный голос 2.
     * w4 – женский альтернативный голос 3.
     *
     * @param string $voice
     */
    public function call($voice = 'm')
    {
        $this->settings->mergeOptions([
            'call'  => true,
            'voice' => $voice,
        ]);
    }


    /**
     * Set current API method.
     */
    public function setApiMethod()
    {
        $this->apiMethod = 'send';
    }


    /**
     * Add phone numbers.
     *
     * @param string $phones Coma-separated phones
     */
    public function addPhones($phones)
    {
        $this->phones .= ',' . $phones;
    }


    /**
     * Get phone numbers.
     *
     * @return string
     */
    public function getPhones()
    {
        return $this->phones;
    }


    /**
     * Set phone numbers.
     *
     * @param string $phones
     */
    public function setPhones($phones)
    {
        $this->phones = $phones;
    }


    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * Set message.
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
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
