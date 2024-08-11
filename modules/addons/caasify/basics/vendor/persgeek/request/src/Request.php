<?php

namespace PG\Request;

/**
 * Documentation for this.
 */
class Request
{
    /**
     * Documentation for this.
     */
    protected $address;

    /**
     * Documentation for this.
     */
    protected $headers;

    /**
     * Documentation for this.
     */
    protected $params;

    /**
     * Documentation for this.
     */
    public static function instance()
    {
        return new static();
    }

    /**
     * Documentation for this.
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Documentation for this.
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Documentation for this.
     */
    public function mergeAddress()
    {
        $address = $this->address;

        if (is_array($address)) {
            $address = append($address);
        }

        return $address;
    }

    /**
     * Documentation for this.
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Documentation for this.
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Documentation for this.
     */
    public function mergeHeaders()
    {
        $headers = [];

        foreach ($this->headers as $name => $value) {
            $headers[] = "$name:$value";
        }

        return $headers;
    }

    /**
     * Documentation for this.
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Documentation for this.
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Documentation for this.
     */
    public function mergeParams()
    {
        $params = $this->params;

        if (is_array($params)) {
            $params = http_build_query($params);
        }

        return $params;
    }

    /**
     * Documentation for this.
     */
    public function getResponse()
    {
        $address = $this->mergeAddress();

        $headers = [];

        if ($this->headers) {
            $headers = $this->mergeHeaders();
        }

        return $this->send($address, $headers, $this->params);
    }

    /**
     * Documentation for this.
     */
    protected function send($address, $headers, $params)
    {
        $curl = curl_init($address);

        $options = [CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_TIMEOUT => 15];

        if ($headers) {
            $options[CURLOPT_HTTPHEADER] = $headers;
        }

        if ($params) {
            $options[CURLOPT_POSTFIELDS] = $params;
        }

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        curl_close($curl);

        return new Response($response);
    }
}
