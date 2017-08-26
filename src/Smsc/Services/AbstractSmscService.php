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


/**
 * Class Message
 *
 * @package Smsc\Message
 */
abstract class AbstractSmscService
{

    /**
     * Settings.
     *
     * @var Settings
     */
    protected $settings;


    /**
     * Additional options.
     *
     * @var string
     */
    protected $options;


    /**
     * API method.
     *
     * @var string
     */
    protected $apiMethod;


    /**
     * Message constructor.
     *
     * @param Settings $settings
     * @param array    $options
     */
    public function __construct(Settings $settings, $options = [])
    {
        $this->settings = $settings;
        $this->options  = $options;
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
        return [
                'login'   => $this->settings->getLogin(),
                'psw'     => $this->settings->getPsw(),
                'sender'  => $this->settings->getSender(),
                'charset' => 'utf-8',
                'fmt'     => 3,
                'pp'      => '343371',
            ] + $this->options;
    }


    /**
     * Return prepared query params for post request.
     */
    public function buildParams()
    {
        return http_build_query($this->getParams());
    }

    /**
     * Set current API method.
     *
     * @param string $method
     */
    public function setApiMethod(string $method)
    {
        if ($this->settings->validApiMethod($method)) {
            $this->apiMethod = $method;
        }
    }

    /**
     * Get current API method.
     *
     * @return string
     */
    public function getApiMethod()
    {
        return $this->apiMethod;
    }

    /**
     * Get current API method.
     *
     * @return string
     */
    public function getApiUrl()
    {
        return $this->settings->getApiUrl($this->getApiMethod());
    }

    /**
     * Check balance.
     *
     * @param RequestInterface|null $driver RequestInterface class name.
     *
     * @return Response
     */
    abstract public function send(RequestInterface $driver = null);
}