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
     * Sender ID.
     *
     * @var string
     */
    protected $sender;

    /**
     * Settings constructor.
     *
     * @param string $login
     * @param string $psw
     * @param string $host
     * @param string $sender
     */
    public function __construct($login = null, $psw = null, $host = null, $sender = null)
    {
        $this->login  = $login;
        $this->psw    = $psw;
        $this->host   = $host;
        $this->sender = $sender;

        $this->setDefaults();
    }

    /**
     * Set default values.
     */
    private function setDefaults()
    {
        if ($this->host === null) {
            $this->host = $this->getDefaultHost();
        }
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
    public function setLogin(string $login)
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
    public function setPsw(string $psw)
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
    public function setHost(string $host = null)
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
    public function validHost(string $host)
    {
        return in_array($host, $this->getApiHosts());
    }

    /**
     * @return string | null
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param string $sender
     */
    public function setSender(string $sender)
    {
        $this->sender = $sender;
    }

    /**
     * Validate API methods.
     *
     * @param string $method
     *
     * @return bool
     * @throws \Exception
     */
    public function validApiMethod(string $method)
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
    public function getApiUrl(string $method)
    {
        if ($this->validApiMethod($method)) {
            return 'https://' . $this->getHost() . "/sys/$method.php";
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
    private static function getConstants(string $needle)
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
}
