<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bienvenido a Videre</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">
    <div style="max-width:600px; margin:auto; background:#ffffff; padding:30px; border-radius:6px;">

        {{-- LOGO --}}
        <div style="text-align:center; margin-bottom:20px;">
            <img src="{{ asset('assets/img/videre-logo.png') }}" alt="Videre" style="max-width:180px;">
        </div>

        <h2 style="color:#1e1e2d; text-align:center;">
            Bienvenido a Videre
        </h2>

        <p>Hola <strong>{{ $user->name }}</strong>,</p>

        <p>
            Tu cuenta como <b>afiliado</b> ha sido creada correctamente en el sistema <b>Videre</b>.
        </p>

        <p><strong>Datos de tu cuenta:</strong></p>

        <ul>
            <li><b>Clínica:</b> {{ $provider->clinic_name }}</li>
            <li><b>Correo:</b> {{ $user->email }}</li>
            <li><b>Contraseña:</b> {{ $password }}</li>
        </ul>

        <p>
            Puedes acceder al sistema desde el siguiente enlace:
        </p>

        <p style="text-align:center;">
            <a href="{{ url('/login') }}"
                style="display:inline-block;padding:12px 20px;background:#0d6efd;color:#ffffff;text-decoration:none;border-radius:4px;">
                Acceder a Videre
            </a>
        </p>

        <p style="margin-top:20px;">
            Por seguridad, te recomendamos cambiar tu contraseña después de iniciar sesión.
        </p>

        <hr style="margin:30px 0;">

        <p style="font-size:12px;color:#6c757d; text-align:center;">
            © {{ date('Y') }} Videre. Todos los derechos reservados.
        </p>

    </div>
</body>

</html>