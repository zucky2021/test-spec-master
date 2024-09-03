<?php

namespace App\Http\Requests;

use App\Domain\SpecDocItem\ValueObject\CheckDetail;
use App\Domain\SpecDocItem\ValueObject\Remark;
use App\Domain\SpecDocItem\ValueObject\TargetArea;
use Illuminate\Foundation\Http\FormRequest;

class SpecDocItemRequest extends FormRequest
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
            'items'               => 'array',
            'items.*.targetArea'  => 'required|string|max:' . TargetArea::MAX_LEN,
            'items.*.checkDetail' => 'required|string|max:' . CheckDetail::MAX_LEN,
            'items.*.remark'      => 'nullable|string|max:' . Remark::MAX_LEN,
        ];
    }
}
