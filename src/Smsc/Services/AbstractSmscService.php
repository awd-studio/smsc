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
     * Response.
     *
     * @var mixed
     */
    protected $data;


    /**
     * Query parameters.
     *
     * @var mixed
     */
    protected $params;


    /**
     * Message constructor.
     *
     * @param Settings $settings
     * @param array    $options
     *
     * @throws \Exception
     */
    public function __construct(Settings $settings, $options = [])
    {
        $this->settings = $settings;
        $this->options  = $options;

        $this->collectParams();
        $this->setApiMethod();
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
     * Add additional query parameters.
     *
     * @param array $params
     */
    public function addParams(array $params)
    {
        $this->params += $params;
    }


    /**
     * Collect parameters for query.
     */
    public function collectParams()
    {
        $this->params = [
                'login'   => $this->settings->getLogin(),
                'psw'     => $this->settings->getPsw(),
                'charset' => 'utf-8',
                'fmt'     => 3,
                'pp'      => '343371',
            ] + $this->options;
    }


    /**
     * Get query parameters.
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }


    /**
     * Return prepared query params for post request.
     */
    public function buildParams()
    {
        return http_build_query($this->getParams());
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
        return isset($driver) ? $driver : new CurlRequest;
    }


    /**
     * Send request and set response.
     *
     * @param RequestInterface|null $driver
     */
    public function send(RequestInterface $driver = null)
    {
        $rawResponse = $this->getRequestDriver($driver)->execute($this);
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
