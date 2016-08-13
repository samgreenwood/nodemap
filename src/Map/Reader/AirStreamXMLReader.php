<?php

namespace Map\Reader;

use SimpleXMLElement;

class AirStreamXMLReader
{
    /**
     * @var string
     */
    private $nodeDbUsername;

    /**
     * @var string
     */
    private $nodeDbPassword;

    /**
     * AirStreamXMLReader constructor.
     * @param $nodeDbUsername
     *
     * @param $nodeDbPassword
     */
    public function __construct($nodeDbUsername, $nodeDbPassword)
    {
        $this->nodeDbUsername = $nodeDbUsername;
        $this->nodeDbPassword = $nodeDbPassword;
    }

    /**
     * @return SimpleXMLElement
     */
    public function read() : SimpleXMLElement
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://members.air-stream.org/login');
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['username' => $this->nodeDbUsername, 'password' => $this->nodeDbPassword]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_exec($ch);

        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_URL, 'https://members.air-stream.org/node/xmlnodes');

        $nodeXml = curl_exec($ch);

        curl_close($ch);

        return new SimpleXMLElement($nodeXml);
    }
}