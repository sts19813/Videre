<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña – Videre</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">
    <div style="max-width:600px; margin:auto; background:#ffffff; padding:30px; border-radius:6px;">

        {{-- LOGO --}}
        <div style="text-align:center; margin-bottom:20px;">
            <img src="{{ asset('assets/img/videre-logo.png') }}" alt="Videre" style="max-width:180px;">
        </div>

        <h2 style="color:#1e1e2d; text-align:center;">
            Restablecer contraseña
        </h2>

        <p>Hola <strong>{{ $user->name ?? 'Usuario' }}</strong>,</p>

        <p>
            Recibimos una solicitud para restablecer la contraseña de tu cuenta en
            <b>Videre</b>.
        </p>

        <p style="text-align:center;">
            <a href="{{ $resetUrl }}"
                style="display:inline-block;padding:12px 20px;background:#0d6efd;color:#ffffff;text-decoration:none;border-radius:4px;">
                Restablecer contraseña
            </a>
        </p>

        <p>
            Este enlace expirará en <b>{{ $expire }} minutos</b>.
        </p>

        <p>
            Si no solicitaste el restablecimiento de contraseña, puedes ignorar este correo.
        </p>

        <hr style="margin:30px 0;">

        <p style="font-size:12px;color:#6c757d; text-align:center;">
            © {{ date('Y') }} Videre. Todos los derechos reservados.
        </p>
    </div>
</body>

</html>