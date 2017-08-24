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
    public function __construct($login, $psw, $host = self::SMSC_HOST_UA, $sender = null)
    {
        $this->setLogin($login);
        $this->setPsw($psw);
        $this->setHost($host);
        $this->setSender($sender);
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
     * @param string $host
     *
     * @throws \Exception
     */
    public function setHost(string $host)
    {
        if (in_array($host, $this->getApiHosts())) {
            $this->host = $host;
        } else {
            throw new \Exception("Host \"$host\" not supported!");
        }
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
     * Get API URL
     *
     * @param string $method
     *
     * @return string
     * @throws \Exception
     */
    public function getApiUrl(string $method)
    {
        if (in_array($method, $this->getApiMethods())) {
            return 'https://' . $this->getHost() . "/sys/$method.php";
        } else {
            throw new \Exception("Method \"$method\" not supported!");
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
