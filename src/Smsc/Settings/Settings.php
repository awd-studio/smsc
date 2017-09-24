<?php

/**
 * This file is part of SMSC PHP library for sending
 * short messages.
 *
 * @author    Anton Karpov <awd.com.ua@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/awd-studio/smsc
 */

namespace Smsc\Settings;

use Smsc\Request\CurlRequest;
use Smsc\Request\GuzzleRequest;
use Smsc\Request\RequestInterface;

/**
 * Class Settings
 *
 * @package Smsc\Settings
 */
final class Settings
{

    /**
     * API Hosts.
     */
    const SMSC_HOST_UA = 'smsc.ua';
    const SMSC_HOST_RU = 'smsc.ru';
    const SMSC_HOST_KZ = 'smsc.kz';
    const SMSC_HOST_TJ = 'smsc.tj';
    const SMSC_HOST_CY = 'smscentre.com';

    /**
     * API methods.
     */
    const SMSC_METHOD_SEND           = 'send';
    const SMSC_METHOD_TEMPLATES      = 'templates';
    const SMSC_METHOD_JOBS           = 'jobs';
    const SMSC_METHOD_STATUS         = 'status';
    const SMSC_METHOD_BALANCE        = 'balance';
    const SMSC_METHOD_PHONES         = 'phones';
    const SMSC_METHOD_USERS          = 'users';
    const SMSC_METHOD_SENDERS        = 'senders';
    const SMSC_METHOD_GET            = 'get';
    const SMSC_METHOD_INFO           = 'info';
    const SMSC_METHOD_GET_MNP        = 'get_mnp';
    const SMSC_METHOD_RECEIVE_PHONES = 'receive_phones';


    /**
     * Account login.
     *
     * @var string
     */
    protected $login;

    /**
     * Account password.
     *
     * @var string
     */
    protected $psw;

    /**
     * API Host.
     *
     * @var string
     */
    protected $host;

    /**
     * Options.
     *
     * @var array
     */
    protected $options;

    /**
     * Request driver.
     *
     * @var RequestInterface
     */
    protected $driver;


    /**
     * Settings constructor.
     *
     * @param array            $options Key-value options list
     * @param RequestInterface $driver
     *
     * @internal param string $login
     * @internal param string $psw
     * @internal param string $host
     * @internal param string $sender
     */
    public function __construct($options = [], RequestInterface $driver = null)
    {
        $this->options = $options;
        $this->driver  = $driver;

        $this->setParams();
        $this->setDefaults();
    }


    /**
     * Set default parameters.
     */
    private function setParams()
    {
        $optionList = [
            'login',
            'psw',
            'host',
        ];

        foreach ($optionList as $option) {
            if ($val = $this->getOption($option)) {
                $this->$option = $val;
            }
        }
    }


    /**
     * Set default values.
     */
    private function setDefaults()
    {
        /* Set default host */
        if ($this->host === null) {
            $this->host = $this->getDefaultHost();
        }

        /* Set default driver */
        if ($this->driver === null) {
            $this->driver = $this->getDefaultDriver();
        }

        /* Set default options */
        $this->setDefaultOptions();
    }


    /**
     * Collect parameters for query.
     */
    public function setDefaultOptions()
    {
        $this->mergeOptions([
            'charset' => 'utf-8',
            'fmt'     => 3,
            'pp'      => '343371',
        ]);
    }


    /**
     * Check valid settings.
     *
     * @return bool
     */
    public function valid()
    {
        return (!empty($this->login) && !empty($this->psw) && !empty($this->host));
    }


    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }


    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }


    /**
     * @return string
     */
    public function getPsw()
    {
        return $this->psw;
    }


    /**
     * @param string $psw
     */
    public function setPsw($psw)
    {
        $this->psw = $psw;
    }


    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }


    /**
     * Default host.
     *
     * @return string
     */
    public function getDefaultHost()
    {
        return self::SMSC_HOST_UA;

    }


    /**
     * @param string $host
     *
     * @throws \Exception
     */
    public function setHost($host = null)
    {
        if (empty($host)) {
            $this->host = $this->getDefaultHost();
        } elseif (in_array($host, $this->getApiHosts())) {
            $this->host = $host;
        } else {
            throw new \Exception("Host \"$host\" not supported!");
        }
    }


    /**
     * Validate host by name.
     *
     * @param string $host
     *
     * @return bool
     */
    public function validHost($host)
    {
        return in_array($host, $this->getApiHosts());
    }


    /**
     * Validate API methods.
     *
     * @param string $method
     *
     * @return bool
     * @throws \Exception
     */
    public function validApiMethod($method)
    {
        if (in_array($method, $this->getApiMethods())) {
            return true;
        } else {
            throw new \Exception("Method \"$method\" not supported!");
        }
    }


    /**
     * Get API URL
     *
     * @param string $method
     *
     * @return string
     * @throws \Exception
     */
    public function getApiUrl($method)
    {
        if ($this->validApiMethod($method)) {
            return 'https://' . $this->host . "/sys/$method.php";
        } else {
            throw new \Exception('API URL cant be generated!');
        }
    }


    /**
     * Get available API hosts.
     */
    public function getApiHosts()
    {
        return self::getConstants('SMSC_HOST_');
    }


    /**
     * Get available API methods.
     */
    public function getApiMethods()
    {
        return self::getConstants('SMSC_METHOD_');
    }


    /**
     * Get self constants by pattern.
     *
     * @param string $needle
     *
     * @return array
     */
    private static function getConstants($needle)
    {
        $reflection   = new \ReflectionClass(__CLASS__);
        $allConstants = $reflection->getConstants();

        $constants = [];

        foreach ($allConstants as $name => $constant) {
            if (0 === strpos($name, $needle)) {
                $constants[$name] = $constant;
            }
        }

        return $constants;
    }


    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }


    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }


    /**
     * Get single option.
     *
     * @param string $string
     *
     * @return mixed|null
     */
    public function getOption($string)
    {
        $options = $this->getOptions();

        return isset($options[$string]) ? $options[$string] : null;
    }


    /**
     * Set single option.
     *
     * @param $key
     * @param $value
     *
     * @return array New options array.
     *
     */
    public function setOption($key, $value)
    {
        return $this->mergeOptions([$key => $value]);
    }


    /**
     * Merge exists options with added.
     *
     * @param array $options
     *
     * @return array
     */
    public function mergeOptions(array $options)
    {
        $this->options = array_merge($this->getOptions(), $options);

        return $this->options;
    }


    /**
     * @return string | null
     */
    public function getSender()
    {
        $sender = $this->getOption('sender');

        return isset($sender) ? $sender : '';
    }


    /**
     * Set Sender ID.
     *
     * @param string $sender
     *
     * @return array
     */
    public function setSender($sender)
    {
        return $this->setOption('sender', $sender);
    }


    /**
     * @return RequestInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }


    /**
     * Set Sender ID.
     *
     * @param RequestInterface $driver
     */
    public function setDriver(RequestInterface $driver)
    {
        $this->driver = $driver;
    }


    /**
     * Get default request driver.
     *
     * @return RequestInterface
     */
    private function getDefaultDriver()
    {
        if (class_exists('GuzzleHttp\\Client')) {
            $driver = new GuzzleRequest;
        } else {
            $driver = new CurlRequest;
        }

        return $driver;
    }


    /**
     * Return prepared query params for post request.
     */
    public function getPostData()
    {
        return http_build_query($this->getOptions());
    }
}
