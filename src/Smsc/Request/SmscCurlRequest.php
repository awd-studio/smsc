<?php

/**
 * This file is part of SMSC PHP library for sending
 * short messages.
 *
 * @author    Anton Karpov <awd.com.ua@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/awd-studio/smsc
 */


namespace Smsc\Request;


use Smsc\Services\SmscService;


/**
 * Class CurlMessage
 *
 * @package Smsc\CurlMessage
 */
class SmscCurlRequest implements RequestInterface
{

    const CONNECTTIMEOUT = 5;
    const TIMEOUT        = 60;

    /**
     * Execute request.
     *
     * @param SmscService $service
     *
     * @return string
     * @throws \Exception
     */
    public function execute(SmscService $service): string
    {
        if (function_exists('curl_init')) {

            static $chanel = 0; // keepalive


            $url  = $service->getApiUrl();
            $post = $service->buildParams();


            if (!$chanel) {
                $chanel = curl_init();

                curl_setopt($chanel, CURLOPT_URL, $url);
                curl_setopt($chanel, CURLOPT_POST, 1);
                curl_setopt($chanel, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
                curl_setopt($chanel, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chanel, CURLOPT_POSTFIELDS, $post);
            }

            $response = curl_exec($chanel);
            curl_close($chanel);

            return $response;
        } else {
            throw new \Exception('CURL must be installed on your server!');
        }
    }
}