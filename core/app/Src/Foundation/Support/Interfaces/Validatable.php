<?php namespace Huifang\Src\Foundation\Support\Interfaces;

interface Validatable
{
    /**
     * Validate this object (either entity or value object).
     *
     * @return \Huifang\Src\Foundation\Support\Validation
     */
    public function validate();

}