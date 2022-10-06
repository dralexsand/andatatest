<?php


namespace App\Requests;

abstract class FormRequestAbstract
{
    protected array $request;
    protected array $fields;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    abstract public function rules(): array;

    abstract public function validate(): array;

    public function checkFields(): array
    {
        if (empty($this->rules())) {
            return $this->request;
        }

        if (empty($this->request)) {
            return $this->request;
        }

        $messages = [];

        foreach ($this->rules() as $fieldData) {
            $fieldName = $fieldData['field'];
            $requirements = $fieldData['requirements'];

            foreach ($requirements as $rule) {
                $keyRule = array_keys($rule)[0];

                $messages[] = match ($keyRule) {
                    'required' => $this->checkRequired($fieldName, $rule),
                    'type' => $this->checkType($fieldName, $rule),
                    'min' => $this->checkMin($fieldName, $rule),
                    'max' => $this->checkMax($fieldName, $rule),
                    default => 'unknown rule',
                };
            }
        }

        $status = implode('', $messages) === '';

        return [
            'status' => $status,
            'messages' => $status ? '' : $messages,
            'fields' => $status ? $this->fields : []
        ];
    }

    public function checkType($fieldName, $rule)
    {
        $message = '';

        if ($this->isValidType($rule['type'], $this->request[$fieldName])) {
            $message = $rule['message'];
        } else {
            $this->fields[$fieldName] = $this->request[$fieldName];
        }

        // ToDo set $messages as class property
        return $message;
    }

    public function isValidType($type, $value): bool
    {
        return match ($type) {
            'int' => is_numeric($value),
            'email' => !filter_var($value, FILTER_VALIDATE_EMAIL),
            'default' => 'unknown type',
        };
    }

    public function checkMin($fieldName, $rule)
    {
        $message = '';

        if (strlen($this->request[$fieldName]) < (int)$rule['min']) {
            $message = $rule['message'];
        } else {
            $this->fields[$fieldName] = $this->request[$fieldName];
        }

        return $message;
    }

    public function checkMax($fieldName, $rule)
    {
        $message = '';

        if (strlen($this->request[$fieldName]) > (int)$rule['max']) {
            $message = $rule['message'];
        } else {
            $this->fields[$fieldName] = $this->request[$fieldName];
        }

        return $message;
    }

    public function checkRequired($fieldName, $rule)
    {
        $message = '';

        if ($rule['required'] && !key_exists($fieldName, $this->request)) {
            $message = $rule['message'];
        } else {
            $this->fields[$fieldName] = $this->request[$fieldName];
        }

        return $message;
    }

}