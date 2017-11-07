<?php namespace Huifang\Src\Foundation\Support\Traits;

use Huifang\Src\Foundation\Support\Validation;

trait Validating
{
    /**
     * Validation object to be used.
     *
     * @var \Huifang\Src\Foundation\Support\Validation
     */
    protected $validation;

    /**
     * Get the validation object.
     *
     * @return \Huifang\Src\Foundation\Support\Validation
     */
    protected function getValidation()
    {
        if (!isset($this->validation)) {
            $this->validation = new Validation();
        }

        return $this->validation;
    }

}