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
use Smsc\Response\Response;
use Smsc\Settings\Settings;
use Smsc\Request\CurlRequest;


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
    }


    /**
     * Add phone numbers.
     *
     * @param string $phones Coma-separated phones
     */
    public function addPhones(string $phones)
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
    public function setPhones(string $phones)
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
    public function setMessage(string $message)
    {
        $this->message = $message;
    }


    /**
     * Get options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }


    /**
     * Set options.
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }


    /**
     * Collect parameters for query.
     */
    public function getParams()
    {
        return parent::getParams() + [
                'phones' => $this->phones,
                'mes'    => $this->message,
            ];
    }


    /**
     * Send SMS.
     *
     * @param RequestInterface|null $driver RequestInterface class name.
     *
     * @return Response
     */
    public function send(RequestInterface $driver = null)
    {
        $this->setApiMethod('send');

        if (!isset($driver)) {
            $driver = new CurlRequest;
        }

        $response = $driver->execute($this);

        return new Response($response, $this->getApiMethod());
    }
}