<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Contraseña actualizada – Videre</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">
    <div style="max-width:600px; margin:auto; background:#ffffff; padding:30px; border-radius:6px;">

        {{-- LOGO --}}
        <div style="text-align:center; margin-bottom:20px;">
            <img src="{{ asset('assets/img/videre-logo.png') }}" alt="Videre" style="max-width:180px;">
        </div>

        <h2 style="color:#1e1e2d; text-align:center;">
            Contraseña actualizada
        </h2>

        <p>Hola <strong>{{ $user->name }}</strong>,</p>

        <p>
            Te confirmamos que la contraseña de tu cuenta en <b>Videre</b>
            fue actualizada correctamente.
        </p>

        <p>
            Si <b>tú no realizaste este cambio</b>, por favor contacta
            inmediatamente a nuestro equipo de soporte.
        </p>

        <p style="text-align:center; margin-top:30px;">
            <a href="{{ url('/login') }}"
                style="display:inline-block;padding:12px 20px;background:#0d6efd;color:#ffffff;text-decoration:none;border-radius:4px;">
                Acceder a Videre
            </a>
        </p>

        <hr style="margin:30px 0;">

        <p style="font-size:12px;color:#6c757d; text-align:center;">
            © {{ date('Y') }} Videre. Todos los derechos reservados.
        </p>

    </div>
</body>

</html>