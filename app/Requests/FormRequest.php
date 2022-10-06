<?php


namespace App\Requests;

class FormRequest extends FormRequestAbstract
{

    public function rules(): array
    {
        return [];
    }

    public function validate(): array
    {
        return $this->checkFields();
    }
}