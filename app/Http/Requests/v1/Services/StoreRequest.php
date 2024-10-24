<?php

namespace App\Http\Requests\v1\Services;

use App\Http\Payloads\CreateService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'url' => ['required', 'url', 'min:11', 'max:255'],
        ];
    }

    public function payload(): CreateService
    {
        return new CreateService(
            name: $this->string('name')->toString(),
            url: $this->string('url')->toString(),
            user: $this->user()->id,
        );
    }
}
