<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengajuanDanaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'proyek_id' => [
                'required',
                'exists:proyek,id'
            ],

            'divisi_id' => [
                'required',
                'exists:divisi,id'
            ],

            'judul' => [
                'required',
                'string',
                'max:255'
            ],

            'jumlah' => [
                'required',
                'numeric',
                'min:1'
            ],

            'keterangan' => [
                'nullable',
                'string'
            ],

            'bukti_pengajuan' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048'
            ],
        ];
    }


    public function messages(): array
    {
        return [

            'proyek_id.required' => 'Proyek wajib dipilih',

            'divisi_id.required' => 'Divisi wajib dipilih',

            'judul.required' => 'Judul pengajuan wajib diisi',

            'jumlah.required' => 'Jumlah dana wajib diisi',

            'jumlah.numeric' => 'Jumlah harus berupa angka',

            'jumlah.min' => 'Jumlah minimal Rp 1',

        ];
    }

}