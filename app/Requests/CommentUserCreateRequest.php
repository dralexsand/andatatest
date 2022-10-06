<?php


namespace App\Requests;

class CommentUserCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            [
                'field' => 'username',
                'requirements' => [
                    [
                        'required' => true,
                        'message' => 'Expected parameter username',
                    ],
                    [
                        'min' => 3,
                        'message' => 'The string length must not be less than 3',
                    ],
                    [
                        'max' => 20,
                        'message' => 'The string length must not exceed 20',
                    ],
                ],
            ],
            [
                'field' => 'email',
                'requirements' => [
                    [
                        'required' => true,
                        'message' => 'Expected parameter email',
                    ],
                    [
                        'type' => 'email',
                        'message' => 'Parameter must be type email',
                    ],
                    [
                        'min' => 6,
                        'message' => 'The string length must not be less than 6',
                    ],
                    [
                        'max' => 30,
                        'message' => 'The string length must not exceed 30',
                    ],
                ],
            ],
            [
                'field' => 'comment',
                'requirements' => [
                    [
                        'required' => true,
                        'message' => 'Expected parameter comment',
                    ],
                    [
                        'min' => 3,
                        'message' => 'The string length must not be less than 3',
                    ],
                    [
                        'max' => 1000,
                        'message' => 'The string length must not exceed 1000',
                    ],
                ],
            ],

        ];
    }
}