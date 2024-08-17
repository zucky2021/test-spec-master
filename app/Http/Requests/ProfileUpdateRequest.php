<?php

namespace App\Http\Requests;

use App\Domain\Department\DepartmentRepositoryInterface;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int|string, \Illuminate\Contracts\Validation\Rule|string>|string>
     */
    public function rules(): array
    {
        if (empty($this->user())) {
            throw new AuthenticationException('User is not authenticated.');
        }
        /** @var int */
        $userId = $this->user()->id;

        return [
            'department_id' => ['nullable', 'integer', 'exists' . DepartmentRepositoryInterface::TABLE_NAME . ',id'],
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($userId)],
        ];
    }
}
