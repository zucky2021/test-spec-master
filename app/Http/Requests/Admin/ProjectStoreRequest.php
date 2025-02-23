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

    /**
     * バリデーションメッセージ
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'departmentId.required' => '部署を選択してください。',
            'name.required'         => 'プロジェクト名を入力してください。',
            'name.max'              => 'プロジェクト名は:max文字以内で入力してください。',
            'summary.required'      => '概要を入力してください。',
            'summary.max'           => '概要は:max文字以内で入力してください。',
        ];
    }
}
