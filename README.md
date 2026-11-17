# Gestor de proyectos

Aplicación web para organizar proyectos y sus equipos de trabajo. Los usuarios pueden crear proyectos, consultar sus detalles y asignar colaboradores con un rol y horas de contribución.

## Funcionalidades

- Registro, inicio y cierre de sesión.
- Recuperación y cambio de contraseña, verificación de correo y edición del perfil.
- Creación, consulta, edición y eliminación de proyectos.
- Gestión del equipo de cada proyecto: asignación de colaboradores, rol y horas aportadas.
- Cálculo de las horas totales de contribución por proyecto.

Las rutas de proyectos requieren iniciar sesión.

## Tecnologías

- PHP 8.3 o superior y Laravel 13.
- MySQL 8.4.
- Node.js, npm, Vite y Tailwind CSS.
- Laravel Sail y Docker Compose para el entorno de desarrollo.

## Requisitos

- Git
- PHP 8.3+ y Composer
- Node.js y npm
- Docker y Docker Compose

## Instalación y puesta en marcha

Clona el repositorio y entra en su directorio:

```bash
git clone <URL_DEL_REPOSITORIO>
cd laravel-proyecto
```

Instala las dependencias de PHP y crea la configuración local:

```bash
composer install
cp .env.example .env
```

Inicia los contenedores de la aplicación y MySQL:

```bash
./vendor/bin/sail up -d --build
```

Genera la clave de la aplicación, crea las tablas y carga los datos de ejemplo:

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
```

Instala las dependencias de JavaScript y compila los recursos:

```bash
npm install
npm run build
```

Abre [http://localhost:8000](http://localhost:8000). El puerto se puede cambiar mediante `APP_PORT` en `.env`.

Para compilar los recursos mientras desarrollas, ejecuta `npm run dev`. Para detener los contenedores:

```bash
./vendor/bin/sail down
```

## Datos de ejemplo

El seeder crea proyectos, colaboradores y cuentas de prueba. En una base de datos recién creada, la cuenta de administrador de ejemplo es:

- **Correo:** `admin@admin.com`
- **Contraseña:** `password123`

Estas credenciales son únicamente para desarrollo local. Cámbialas o elimina la cuenta antes de desplegar la aplicación.

## Pruebas

Ejecuta la suite de pruebas con:

```bash
./vendor/bin/sail artisan test
```

## Estructura del proyecto

- `app/Models` — modelos de usuarios y proyectos.
- `app/Http/Controllers` — controladores de proyectos, perfil y autenticación.
- `database/migrations` — esquema de la base de datos.
- `database/seeders` — datos iniciales y de demostración.
- `resources/views` — vistas Blade de la aplicación.
- `routes/web.php` y `routes/auth.php` — rutas web y de autenticación.

## Licencia

Este proyecto utiliza Laravel, distribuido bajo la [licencia MIT](https://opensource.org/licenses/MIT).
