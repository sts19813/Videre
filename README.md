# Videre

Sistema de gestión de pacientes y proveedores desarrollado en **Laravel 12** utilizando **Metronic 9 (Demo 2)** como framework UI.

Videre está diseñado como una plataforma multi-rol donde un **Administrador** gestiona proveedores y pacientes, y los **Proveedores** registran pacientes que posteriormente son atendidos mediante citas agendadas por el administrador.

---

## 📌 Objetivo del Proyecto

Centralizar la gestión de pacientes referidos por proveedores (clínicas/consultorios), permitiendo:

- Alta y administración de proveedores
- Registro de pacientes por proveedor
- Visualización global por parte del administrador
- Gestión de estatus de pacientes
- Agendado de citas
- Dashboards diferenciados por rol

---

## 🧱 Stack Tecnológico

- **Backend:** Laravel 12
- **Frontend:** Blade + Metronic 9 (Demo 2)
- **Base de datos:** MySQL
- **Autenticación:** Laravel Auth (email/password)
- **UI Framework:** Metronic 9
- **Control de acceso:** Roles a nivel aplicación (sin Spatie)

---

## 👥 Roles del Sistema

### 1️⃣ Administrador

Permisos:

- Crear, editar, activar y desactivar proveedores
- Ver todos los pacientes del sistema
- Cambiar estatus de pacientes
- Agendar citas
- Acceso a métricas globales

Dashboard incluye:

- Total de proveedores
- Pacientes enviados
- Pacientes atendidos

Secciones principales:

- Pacientes
- Proveedores
- Usuarios Videre

---

### 2️⃣ Proveedor

Permisos:

- Acceder solo a su información
- Registrar pacientes
- Visualizar estatus de sus pacientes

Restricciones:

- No puede modificar estatus
- No puede agendar citas
- Si es deshabilitado por el administrador, pierde acceso al sistema

Dashboard incluye:

- Pacientes enviados
- Pacientes pendientes
- Pacientes con cita
- Pacientes atendidos

---

## 🧠 Reglas de Negocio

- Un proveedor solo puede ver y gestionar sus propios pacientes
- El administrador puede ver y gestionar todos los registros
- Un paciente solo puede tener **una cita activa**
- Al agendar una cita, el estatus del paciente cambia automáticamente
- Proveedores deshabilitados no pueden iniciar sesión

---

## 📊 Estatus de Paciente

Los pacientes pueden tener uno de los siguientes estatus:

- `pendiente`
- `cita_agendada`
- `atendido`
- `cancelado`

---

## 🗂️ Estructura del Proyecto (Vistas)

```text
resources/views
│
├── layouts
│   ├── app.blade.php
│   └── auth.blade.php
│
├── partials
│   ├── header.blade.php
│   ├── navbar.blade.php
│   ├── footer.blade.php
│   ├── toolbar.blade.php
│   └── scripts.blade.php
│
├── admin
│   ├── dashboard.blade.php
│   ├── providers
│   │   ├── index.blade.php
│   │   └── form.blade.php
│   └── patients
│       ├── index.blade.php
│       ├── show.blade.php
│       └── schedule.blade.php
│
├── provider
│   ├── dashboard.blade.php
│   └── patients
│       ├── index.blade.php
│       └── create.blade.php
│
└── components
    ├── cards
    ├── tables
    └── badges
```

---

## 🎨 Metronic 9 – Integración

Se utiliza **Metronic 9 – Demo 2**.

### Assets

Los assets deben copiarse a:

```text
public/metronic/assets
```

En Blade se referencian mediante:

```blade
{{ asset('metronic/assets/...') }}
```

### División del HTML

El archivo `index.html` del demo se divide de la siguiente manera:

- `<head>` → `layouts/app.blade.php`
- Header → `partials/header.blade.php`
- Sidebar → `partials/sidebar.blade.php`
- Toolbar → `partials/toolbar.blade.php`
- Content → vistas específicas por rol
- Footer → `partials/footer.blade.php`
- Scripts → `partials/scripts.blade.php`

---

## 🗃️ Estructura de Base de Datos

### Tablas Principales

- `users`
- `providers`
- `patients`
- `appointments`

### Relaciones

- User → hasOne Provider
- Provider → belongsTo User
- Provider → hasMany Patients
- Patient → belongsTo Provider
- Patient → hasOne Appointment
- Appointment → belongsTo Patient

---

## 🧑‍💻 Campos Clave

### Pacientes

- Nombre
- Apellido
- Celular
- Correo
- Observaciones
- Estatus

### Citas

- Fecha
- Hora

---

## 🔐 Seguridad y Acceso

### Middlewares recomendados

- `auth`
- `role:admin`
- `role:provider`
- `active_provider`

Ejemplo:

```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    // rutas admin
});
```

---

## 🚀 Instalación del Proyecto

```bash
git clone <repositorio>
cd videre
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

---

## 📈 Futuras Mejoras

- Historial de citas
- Notificaciones por correo
- Roles avanzados
- Auditoría de cambios
- Exportación de reportes

---

## 🧾 Convenciones

- Código orientado a producción
- Separación clara de responsabilidades
- Blade limpio y reutilizable
- UI consistente con Metronic

---

## 📌 Notas Finales

Este proyecto fue diseñado con escalabilidad en mente, permitiendo agregar nuevas funcionalidades sin romper la arquitectura base.

Cualquier desarrollo futuro debe respetar:

- Roles
- Reglas de negocio
- Estructura de vistas
- Integración con Metronic

---

**Videre** — Sistema de Gestión de Pacientes y Proveedores