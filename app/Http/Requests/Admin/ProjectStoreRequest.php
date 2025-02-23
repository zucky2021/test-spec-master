<?php

namespace App\Http\Requests\Admin;

use App\Domain\Project\ValueObject\Name;
use App\Domain\Project\ValueObject\Summary;
use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'departmentId' => 'required|integer',
            'name'         => 'required|string|max:' . Name::MAX_LEN,
            'summary'      => 'required|string|max:' . Summary::MAX_LEN,
        ];
    }
}
