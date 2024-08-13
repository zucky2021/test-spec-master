<?php

namespace App\Http\Requests;

use App\Domain\SpecificationDocument\ValueObject\Summary;
use App\Domain\SpecificationDocument\ValueObject\Title;
use Illuminate\Foundation\Http\FormRequest;

class SpecificationDocumentRequest extends FormRequest
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
            'title'   => 'required|string|max:' . Title::MAX_LEN,
            'summary' => 'required|string|max:' . Summary::MAX_LEN,
        ];
    }
}
