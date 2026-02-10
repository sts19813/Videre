<?php

return [

    'required' => 'El campo :attribute es obligatorio.',
    'email' => 'El campo :attribute debe ser un correo válido.',
    'unique' => 'El :attribute ya está registrado.',
    'accepted' => 'El campo :attribute debe ser aceptado.',
    'active_url' => 'El campo :attribute no es una URL válida.',
    'after' => 'El campo :attribute debe ser una fecha posterior a :date.',
    'alpha' => 'El campo :attribute solo debe contener letras.',
    'alpha_dash' => 'El campo :attribute solo debe contener letras, números y guiones.',
    'alpha_num' => 'El campo :attribute solo debe contener letras y números.',
    'confirmed' => 'La confirmación de la contraseña no coincide.',
    'same' => 'El campo :attribute y :other deben coincidir.',
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'max' => [
        'string' => 'El campo :attribute no debe exceder :max caracteres.',
    ],
    'attributes' => [
        'email' => 'correo electrónico',
        'first_name' => 'nombre',
        'last_name' => 'apellido',
        'clinic_name' => 'consultorio',
        'phone' => 'teléfono',
        'provider_type' => 'tipo de proveedor',
        'password' => 'contraseña',
        'password_confirmation' => 'confirmación de la contraseña',
    ],
];
