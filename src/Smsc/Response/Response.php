<?php

/**
 * This file is part of SMSC PHP library for sending
 * short messages.
 *
 * @author    Anton Karpov <awd.com.ua@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/awd-studio/smsc
 */

namespace Smsc\Response;


/**
 * Class Response
 *
 * @package Smsc\Response
 */
class Response
{

    /**
     * Original text (json) response.
     *
     * @var string
     */
    protected $origin;

    /**
     * Response object.
     *
     * @var array | mixed
     */
    protected $response;

    /**
     * @var bool
     */
    protected $hasError;

    /**
     * @var int
     */
    protected $errorOriginCode;

    /**
     * @var string
     */
    protected $errorOriginMessage;

    /**
     * Message
     *
     * @var string
     */
    protected $message;

    /**
     * Response constructor.
     *
     * @param string $json
     * @param string $method
     */
    public function __construct($json, $method = 'send')
    {
        $this->origin   = $json;
        $this->response = json_decode($json);

        if (isset($this->response->error) || isset($this->response->error_code)) {

            $this->hasError           = (bool) $this->response->error_code;
            $this->errorOriginCode    = $this->response->error_code;
            $this->errorOriginMessage = $this->response->error;
            $this->message            = $this->getErrorMessage($method, $this->response->error_code);

        } else {

            $this->message  = 'Success';
            $this->hasError = false;

        }
    }

    /**
     * Error message.
     *
     * @param $method    string
     * @param $errorCode string
     *
     * @return string
     *
     */
    private function getErrorMessage($method, $errorCode)
    {
        $responseCodes = self::responseErrorCodes();

        if (isset($responseCodes[$method][$errorCode])) {
            $message = $responseCodes[$method][$errorCode];
        } else {
            $message = "Unknown error: \"$method\":\"$errorCode\". ";
            $message .= "See full response: {$this->getOrigin()}";
        }

        return $message;
    }

    /**
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->hasError;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param bool $message
     */
    public function setMessage(bool $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getErrorOriginMessage(): string
    {
        return $this->errorOriginMessage;
    }

    /**
     * @return int
     */
    public function getErrorOriginCode(): int
    {
        return $this->errorOriginCode;
    }

    /**
     * @return array|mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getOrigin(): string
    {
        return $this->origin;
    }


    /**
     * Return prepared query params for post request.
     */
    private static function responseErrorCodes()
    {
        return [
            'send' => [
                1 => 'Ошибка в параметрах',
                2 => 'Неверный логин или пароль',
                3 => 'Недостаточно средств на счете Клиента',
                4 => 'IP-адрес временно заблокирован из-за частых ошибок в запросах',
                5 => 'Неверный формат даты',
                6 => 'Сообщение запрещено (по тексту или по имени отправителя)',
                7 => 'Неверный формат номера телефона',
                8 => 'Сообщение на указанный номер не может быть доставлено',
                9 => 'Отправка более одного одинакового запроса на передачу SMS-сообщения либо более пяти одинаковых запросов на получение стоимости сообщения в течение минуты',
            ],
        ];
    }
}