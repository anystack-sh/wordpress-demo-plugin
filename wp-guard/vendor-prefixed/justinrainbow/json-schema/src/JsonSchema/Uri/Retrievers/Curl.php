<?php

/*
 * This file is part of the JsonSchema package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\JsonSchema\Uri\Retrievers;

use Anystack\WPGuard\V001\JsonSchema\Exception\RuntimeException;
use Anystack\WPGuard\V001\JsonSchema\Validator;

/**
 * Tries to retrieve JSON schemas from a URI using cURL library
 *
 * @author Sander Coolen <sander@jibber.nl>
 */
class Curl extends AbstractRetriever
{
    protected $messageBody;

    public function __construct()
    {
        if (!function_exists('curl_init')) {
            // Cannot test this, because curl_init is present on all test platforms plus mock
            throw new RuntimeException('cURL not installed'); // @codeCoverageIgnore
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see \Anystack\WPGuard\V001\JsonSchema\Uri\Retrievers\UriRetrieverInterface::retrieve()
     */
    public function retrieve($uri)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: ' . Validator::SCHEMA_MEDIA_TYPE));

        $response = curl_exec($ch);
        if (false === $response) {
            throw new \Anystack\WPGuard\V001\JsonSchema\Exception\ResourceNotFoundException('JSON schema not found');
        }

        $this->fetchMessageBody($response);
        $this->fetchContentType($response);

        curl_close($ch);

        return $this->messageBody;
    }

    /**
     * @param string $response cURL HTTP response
     */
    private function fetchMessageBody($response)
    {
        preg_match("/(?:\r\n){2}(.*)$/ms", $response, $match);
        $this->messageBody = $match[1];
    }

    /**
     * @param string $response cURL HTTP response
     *
     * @return bool Whether the Content-Type header was found or not
     */
    protected function fetchContentType($response)
    {
        if (0 < preg_match("/Content-Type:(\V*)/ims", $response, $match)) {
            $this->contentType = trim($match[1]);

            return true;
        }

        return false;
    }
}
