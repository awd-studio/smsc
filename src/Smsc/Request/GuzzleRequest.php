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


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Smsc\Services\AbstractSmscService;


/**
 * Class GuzzleRequest
 *
 * @package Smsc\Request
 */
class GuzzleRequest implements RequestInterface
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

        $uri  = $service->getApiUrl();
        $body = $service->buildParams();

        try {
            $client = new Client();

            $response = $client->post($uri, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body'    => $body,
            ]);

            return (string) $response->getBody();
        } catch (RequestException $e) {
            throw new \Exception("GuzzleHttp request failed! Exception: $e");
        }
    }
}
