<?php

namespace PG\Request;

/**
 * Documentation for this.
 */
class Response
{
    /**
     * Documentation for this.
     */
    protected $data;

    /**
     * Documentation for this.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Documentation for this.
     */
    public function asPlain()
    {
        return $this->data;
    }

    /**
     * Documentation for this.
     */
    public function asArray()
    {
        return json_decode($this->data, true);
    }

    /**
     * Documentation for this.
     */
    public function asObject()
    {
        return json_decode($this->data);
    }
}
