<?php
/**
 * Created by PhpStorm.
 * User: denismitr
 * Date: 30.07.2018
 * Time: 1:41
 */

namespace App\Auth;


use stdClass;

class DecodedToken
{
    /**
     * @var stdClass
     */
    protected $payload;

    /**
     * DecodedToken constructor.
     * @param stdClass $payload
     */
    public function __construct(stdClass $payload)
    {
        $this->payload = $payload;
    }

    public function getSubject()
    {
        return $this->payload->sub;
    }

    public function __get($prop)
    {
        if (property_exists($this->payload, $prop)) {
            return $this->payload->{$prop};
        }
    }
}