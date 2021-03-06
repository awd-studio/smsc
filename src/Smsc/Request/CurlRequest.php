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


use Smsc\Services\AbstractSmscService;


/**
 * Class CurlRequest
 *
 * @package Smsc\Request
 */
class CurlRequest implements RequestInterface
{

    /**
     * Execute request.
     *
     * @param AbstractSmscService $service
     *
     * @return string
     * @throws \Exception
     */
    public function execute(AbstractSmscService $service)
    {
        if (function_exists('curl_init')) {

            static $chanel = 0; // keepalive

            $response = null;

            $settings = $service->getSettings();

            $url  = $service->getApiUrl();
            $post = $settings->getPostData();

            if (!$chanel) {
                $chanel = curl_init();

                curl_setopt($chanel, CURLOPT_URL, $url);
                curl_setopt($chanel, CURLOPT_POST, 1);
                curl_setopt($chanel, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
                curl_setopt($chanel, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chanel, CURLOPT_POSTFIELDS, $post);

                $response = curl_exec($chanel);
                curl_close($chanel);
            }

            return $response;
        } else {
            throw new \Exception('CURL must be installed on your server!');
        }
    }
}
