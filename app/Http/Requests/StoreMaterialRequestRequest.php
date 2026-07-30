<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'keterangan' => 'nullable|string',

            'nama_barang' => 'required|array',

            'nama_barang.*' => 'required|string|max:255',

            'nama_kategori' => 'required|array',

            'nama_kategori.*' => 'required|string|max:255',

            'qty' => 'required|array',

            'qty.*' => 'required|integer|min:1',

            'catatan' => 'nullable|array',

        ];
    }
}