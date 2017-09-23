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


use Smsc\Request\CurlRequest;
use Smsc\Request\GuzzleRequest;
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
     * API method.
     *
     * @var string
     */
    protected $apiMethod;

    /**
     * Response.
     *
     * @var mixed
     */
    protected $data;


    /**
     * Service constructor.
     *
     * @param Settings $settings
     * @param array    $options
     *
     * @throws \Exception
     */
    public function __construct(Settings $settings, $options = [])
    {
        $this->settings = $settings;

        $this->settings->mergeOptions($options);

        $this->setApiMethod();
    }


    /**
     * Get service settings.
     *
     * @return Settings
     */
    public function getSettings()
    {
        return $this->settings;
    }


    /**
     * Get current API method.
     *
     * @return string
     * @throws \Exception
     */
    public function getApiMethod()
    {
        if (!empty($this->apiMethod) && $this->settings->validApiMethod($this->apiMethod)) {
            return $this->apiMethod;
        } else {
            throw new \Exception('No API method!');
        }
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
     * @return Response
     */
    public function getData()
    {
        return $this->data;
    }


    /**
     * @param Response $response
     */
    public function setData(Response $response)
    {
        $this->data = $response;
    }


    /**
     * Get request driver.
     *
     * @param RequestInterface|null $driver
     *
     * @return CurlRequest|RequestInterface
     */
    public function getRequestDriver(RequestInterface $driver = null)
    {
        if (!isset($driver)) {
            if (class_exists('GuzzleHttp\\Client')) {
                $driver = new GuzzleRequest;
            } else {
                $driver = new CurlRequest;
            }
        }

        return $driver;
    }


    /**
     * Send request and set response.
     */
    public function send()
    {
        $rawResponse = $this->settings->getDriver()->execute($this);
        $this->setData(new Response($rawResponse, $this->getApiMethod()));
    }


    /**
     * Set current API method.
     */
    abstract public function setApiMethod();


    /**
     * Processing response.
     *
     * Helper function for produced more helpful response.
     *
     * @return mixed
     */
    abstract public function results();
}
