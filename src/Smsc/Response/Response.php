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
    protected $rawResponse;

    /**
     * Decoded response.
     *
     * @var array|object
     */
    protected $response;

    /**
     * Status code.
     * If "0" - operation success. Else - failed.
     *
     * @var int
     */
    protected $statusCode;

    /**
     * Status message.
     * If success = "success", else - message from response.
     *
     * @var string
     */
    protected $statusMessage;

    /**
     * Status code message.
     * Error message. Empty if success operation.
     *
     * @var string
     */
    protected $statusCodeMessage;

    /**
     * API method
     *
     * @var string
     */
    protected $apiMethod;


    /**
     * Response constructor.
     *
     * @param string $json
     * @param string $apiMethod
     */
    public function __construct($json, $apiMethod = 'send')
    {
        $this->rawResponse = $json;
        $this->apiMethod   = $apiMethod;
        $this->response    = json_decode($json);

        $this->statusCode        = $this->hasError() ? $this->response->error_code : 0;
        $this->statusMessage     = $this->hasError() ? $this->response->error : 'Success';
        $this->statusCodeMessage = $this->hasError() ? $this->getErrorMessage() : '';
    }

    /**
     * Check if operation has error.
     *
     * @return bool
     */
    public function hasError()
    {
        return (bool) @$this->response->error_code;
    }

    /**
     * Error message.
     *
     * @return string
     *
     */
    private function getErrorMessage()
    {
        $responseCodes = self::responseErrorCodes();

        if (isset($responseCodes[$this->apiMethod][$this->statusCode])) {
            $message = $responseCodes[$this->apiMethod][$this->statusCode];
        } else {
            $message = "Unknown error: \"$this->apiMethod\":\"$this->statusCode\". ";
            $message .= "See full response: {$this->getRawResponse()}";
        }

        return $message;
    }

    /**
     * @return string
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    /**
     * @return string
     */
    public function getStatusCodeMessage()
    {
        return $this->statusCodeMessage;
    }

    /**
     * @return string
     */
    public function getApiMethod()
    {
        return $this->apiMethod;
    }


    /**
     * Return prepared query params for post request.
     */
    private static function responseErrorCodes()
    {
        return [
            'send'           => [
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
            'templates'      => [
                1 => 'Ошибка в параметрах',
                2 => 'Неверный логин или пароль',
                3 => 'Запись не найдена',
                4 => 'IP-адрес временно заблокирован',
                5 => 'Ошибка сохранения или удаления',
                9 => 'Попытка отправки более трех одинаковых запросов на действия с шаблонами',
            ],
            'jobs'           => [
                1 => 'Ошибка в параметрах',
                2 => 'Неверный логин или пароль',
                3 => 'Ошибка сохранения записи',
                4 => 'IP-адрес временно заблокирован из-за частых ошибок в запросах',
                5 => 'Неверный формат даты',
                9 => 'Отправка более одного одинакового запроса на действия с рассылками в течение минуты',
            ],
            'status'         => [
                1 => 'Ошибка в параметрах',
                2 => 'Неверный логин или пароль',
                4 => 'IP-адрес временно заблокирован',
                5 => 'Ошибка удаления сообщения',
                9 => 'Попытка отправки более пяти запросов на получение статуса одного и того же сообщения в течение минуты',
            ],
            'balance'        => [
                1 => 'Ошибка в параметрах',
                2 => 'Неверный логин или пароль',
                4 => 'IP-адрес временно заблокирован',
                9 => 'Попытка отправки более десяти запросов на получение баланса в течение минуты',
            ],
            'phones'         => [
                1 => 'Ошибка в параметрах',
                2 => 'Неверный логин или пароль',
                3 => 'Записи не найдены',
                4 => 'IP-адрес временно заблокирован',
                5 => 'Ошибка выполнения операции',
                9 => 'Попытка отправки более трех одинаковых запросов на операции с группами, контактами или записями "черного" списка в течение минуты',
            ],
            'users'          => [
                1  => 'Ошибка в параметрах',
                2  => 'Неверный логин или пароль',
                3  => 'Записи не найдены',
                4  => 'IP-адрес временно заблокирован',
                5  => 'Ошибка выполнения операции',
                6  => 'Субклиент с указанным логином не существует',
                7  => 'Указан сублогин имеющий общий баланс с главным аккаунтом',
                8  => 'Ошибка при сохранении записи',
                9  => 'Попытка отправки более трех запросов на добавление субклиентов или изменение одного и того же субклиента в течение минуты',
                10 => 'Недостаточно средств для зачисления',
            ],
            'senders'        => [
                1  => 'Ошибка в параметрах',
                2  => 'Неверный логин или пароль',
                3  => 'Имя отправителя не найдено',
                4  => 'IP-адрес временно заблокирован',
                5  => 'Ошибка сохранения или удаления имени отправителя',
                7  => 'Неверный формат номера',
                8  => 'Код подтверждения на указанный номер не может быть доставлен',
                9  => 'Попытка отправки более трех одинаковых запросов на получение списка доступных имен отправителей или пяти запросов на создание нового имени отправителя в течение минуты',
                10 => 'Код уже был отправлен на указанный номер. Повторная попытка возможна через 8 часов',
                11 => 'Неверный код подтверждения',
            ],
            'get'            => [
                1 => 'Ошибка в параметрах',
                2 => 'Неверный логин или пароль',
                3 => 'Сообщение не найдено | Лицевые счета не найдены | Оператор не найден',
                4 => 'IP-адрес временно заблокирован',
                9 => 'Попытка отправки более трех одинаковых запросов на получение истории исходящих сообщений в течение минуты',
            ],
            'info'           => [
                1 => 'Ошибка в параметрах',
                2 => 'Неверный логин или пароль',
                3 => 'Оператор не найден',
                4 => 'IP-адрес временно заблокирован',
                9 => 'Попытка отправки более трех одинаковых запросов или любых 100 запросов на получение информации об операторе абонента в течение минуты',
            ],
            'get_mnp'        => [
                1 => 'Ошибка в параметрах',
                2 => 'Неверный логин или пароль',
                4 => 'IP-адрес временно заблокирован',
                9 => 'Попытка отправки более трех одинаковых запросов на выгрузку базы портированных номеров в течение минуты',
            ],
            'receive_phones' => [
                1 => 'Ошибка в параметрах',
                2 => 'Неверный логин или пароль',
                3 => 'Недостаточно средств на счете для аренды номера',
                4 => 'IP-адрес временно заблокирован',
                9 => 'Попытка отправки более двух одинаковых запросов на получение списка доступных для аренды номеров или подключение номера, либо изменение свойств выделенного номера в течение минуты',
            ],
        ];
    }
}
