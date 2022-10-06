<?php

declare(strict_types=1);


namespace App\Requests;

class CommentCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
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