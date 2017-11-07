<?php namespace Huifang\Src\Foundation\Support\Interfaces;

interface Printable
{
    /**
     * Print or echo this object.
     *
     * @return string
     */
    public function __toString();
}