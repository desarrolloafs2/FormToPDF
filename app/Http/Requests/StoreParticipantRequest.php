<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DniNieRule;
use App\Rules\CifOrDniNieRule;

class StoreParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'firstSurname' => ['required'],
            'secondSurname' => ['required'],
            'address' => ['required'],
            'locality' => ['required'],
            'province' => ['required'],
            'postalCode' => ['required', 'regex:/^(0[1-9]|[1-4][0-9]|5[0-2])\d{3}$/'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'regex:/^(?:\+34|34)?\s?(6|7|8|9)\d{2}[\s-]?\d{3}[\s-]?\d{3}$/'],
            'nif' => ['required', new DniNieRule()],
            'ssnumber' => ['required', 'regex:/^\d{12}$/'],
            'birthdate' => ['required', 'date', 'before:today'],
            'studyLevel' => ['required'],
            'contributionGroup' => ['required'],
            'zzOtherText' => ['nullable', 'required_if:otherQualification,ZZ'],
            'professionalCategory' => ['required'],
            'cno' => ['required'],
            'participantStatus' => ['required'],
            'employmentRegime' => ['nullable', 'required_if:participantStatus,ocupado'],
            'company' => ['nullable', 'required_if:participantStatus,ocupado'],
            'cif' => [
                'nullable',
                'required_if:participantStatus,ocupado',
                new CifOrDniNieRule()
            ],
            'gender' => ['required'],
            'disability' => ['required'],
            'otherQualification' => ['nullable'],
            'functionalArea' => ['nullable', 'required_if:participantStatus,ocupado'],
            'signature' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => 'Le faltó un campo obligatorio',
            'email.email' => 'El formato del email es incorrecto',
            'postalCode.regex' => 'El formato del código postal es incorrecto',
            'phone.regex' => 'El formato del teléfono es inválido',
            'ssnumber.regex' => 'El formato del número de afiliación a la seguridad social es inválido',
            'birthdate.before' => 'La fecha de nacimiento debe ser anterior a hoy',
            'zzOtherText.required_if' => 'Debe especificar que titulación alternativa posee',
            'employmentRegime.required_if' => 'Le faltó un campo obligatorio',
            'company.required_if' => 'Le faltó un campo obligatorio',
            'cif.required_if' => 'Le faltó un campo obligatorio',
            'functionalArea.required_if' => 'Le faltó un campo obligatorio'
        ];
    }
}
