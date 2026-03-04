# VIP2CARS — Gestión de Vehículos (Entrega)

Resumen: proyecto mínimo en PHP + SQLite para registro y administración de vehículos.

**Contenido de esta entrega**
- Código fuente: `src/`, `public/`, `templates/`, `assets/`.
- Scripts de base de datos: `sql/vehicles_schema.sql`, `sql/surveys_schema.sql` y `migrate.php`.
- Seed de ejemplo: `seed.php`.

## 🔧 Requisitos del entorno
- PHP 8.0+ (se recomienda PHP 8.1)
- Extensión PDO y PDO_SQLITE
- Acceso a la línea de comandos para ejecutar `php` (CLI)
- No es necesaria una base de datos externa: usa SQLite por defecto

## 🧰 Instalación y configuración
1. Clona el repositorio:
```bash
git clone <REPO_URL> vip2cars
cd vip2cars
```
2. Crear la base de datos y tablas (migraciones):
```bash
php migrate.php
```
3. Insertar datos de ejemplo:
```bash
php seed.php
```

Archivo de ejemplo de configuración: `.env.example`

## ▶️ Puesta en marcha
Arrancar servidor embebido (entorno de desarrollo):
```powershell
cd vip2cars
php -S localhost:8000 -t public
```
Abrir en el navegador: `http://localhost:8000`

## 🗄️ Estructura de la BBDD
Los scripts SQL están en `sql/`:
- `sql/vehicles_schema.sql` — tabla `vehicles`.
- `sql/surveys_schema.sql` — tablas para módulo de encuestas (no usadas en demo).

También hay un script `migrate.php` que ejecuta todos los `.sql` en la carpeta `sql/`.

## 🔑 Usuario demo
No hay sistema de autenticación en esta versión. Usa los datos creados por `seed.php` como datos de ejemplo.

## 📦 Archivos importantes
- `public/index.php` — controlador y rutas básicas (listar, crear, editar, eliminar).
- `src/VehicleModel.php` — acceso a datos.
- `src/Validator.php` — validaciones servidor.
- `templates/` — vistas (form, list, layout).

## 📤 Cómo preparar el repositorio para entrega
1. Inicializa git si aún no está:
```bash
git init
git add .
git commit -m "Entrega VIP2CARS - [TU NOMBRE]"
```
2. Crea un repositorio remoto en GitHub/GitLab y empuja tus cambios:
```bash
git remote add origin <REPO_URL>
git branch -M main
git push -u origin main
```

## ✉️ Envío por correo
Envía un correo a:
- sistemas@vip2cars.com
- lcapcha@vip2cars.com
- tatiana.contreras@vip2cars.com

Asunto: `NOMBRE COMPLETO + DNI`
Incluye en el cuerpo:
- Enlace al repositorio público
- Breve instrucción para ejecutar (migrate.php, seed.php, php -S ...)

---
Si quieres, puedo preparar y añadir automáticamente un archivo `docs/email_draft.txt` listo para pegar en tu cliente de correo.
# VIP2CARS - Sistema mínimo CRUD de Vehículos y modelado de encuestas anónimas

Resumen rápido:
- Proyecto PHP simple (sin frameworks externos) que implementa un CRUD para vehículos y datos de contacto.
- BBDD: SQLite (archivo en `vip2cars/data/database.sqlite`).

Estructura:
- `vip2cars/public/index.php` - punto de entrada y rutas simples para CRUD.
- `vip2cars/src/VehicleModel.php` - acceso a BBDD con PDO.
- `vip2cars/init_db.php` - crea la base de datos y la tabla `vehicles`.
- `vip2cars/templates/` - vistas (listado, formulario, layout).

Campos del CRUD registrados:
- Placa
- Marca
- Modelo
- Año de fabricación
- Nombre del cliente
- Apellidos del cliente
- Nro. De documento del cliente
- Correo del cliente
- Teléfono del cliente

Instalación y puesta en marcha (XAMPP / Windows):

1. Copie la carpeta `vip2cars` dentro de `htdocs` de XAMPP (ya está colocada si usted usa este repositorio en `c:\xampp\htdocs\prueba`).
2. En un navegador, ejecute el script de inicialización para crear la BBDD:

```bash
php vip2cars/init_db.php
```

3. Abra en el navegador:

    http://localhost/prueba/vip2cars/public/index.php

Uso y notas:
- El botón `(Re)crear BBDD` en la interfaz invoca el script `init_db.php`.
- La BBDD es `vip2cars/data/database.sqlite`.

Funcionalidades añadidas:
- Búsqueda servidor/cliente por `placa`, `marca`, `modelo`, `nombre` o `apellidos`.
- Paginación servidor (10 registros por página).
- Script de semillas: `vip2cars/seed.php` para añadir registros de ejemplo.
- Scripts SQL de esquema en `vip2cars/sql/`.

Requisitos mínimos del entorno:
- PHP 8.0+ con PDO y la extensión sqlite3 habilitada.
- Servidor web local (XAMPP, WAMP) o PHP integrado.

Comandos útiles:

```powershell
# crear/actualizar la BBDD (ejecutar una vez)
php vip2cars/init_db.php

# insertar datos de ejemplo
php vip2cars/seed.php

# abrir app (navegador)
# http://localhost/prueba/vip2cars/public/index.php
```

Estructura de la BBDD y diagramas:
- Script SQL del CRUD de vehículos: `vip2cars/sql/vehicles_schema.sql`.
- Modelado de encuestas anónimas (script SQL): `vip2cars/sql/surveys_schema.sql`.
- Diagrama ER (Mermaid): `vip2cars/docs/surveys_er.mmd`.

Para generar una imagen del diagrama Mermaid localmente puedes usar `mmdc` (mermaid-cli) o usar el editor online en https://mermaid.live .

Migración a framework:
Este proyecto es una implementación ligera sin framework para facilitar evaluación y despliegue rápido. Si deseas, puedo migrarlo a Laravel (migrations, Eloquent, controllers y vistas Blade) y añadir autenticación y tests.


Modelado de BBDD para sistema de encuestas anónimas (propuesta):

Tablas principales sugeridas:

- `surveys` (encuestas): id, title, description, created_at, updated_at
- `questions`: id, survey_id (FK), text, type (text|radio|checkbox|rating), required, created_at
- `options`: id, question_id (FK), text — para preguntas con opciones
- `responses`: id, survey_id (FK), submitted_at, metadata (json) — anónimo: no almacenar datos personales
- `answers`: id, response_id (FK), question_id (FK), option_id (nullable), text_value

Consideraciones de anonimato:
- No guardar IP ni datos personales en `responses` si la encuesta debe ser completamente anónima.
- Si se requiere seguimiento, separar `responses` de `participants` y almacenar identificadores no vinculantes.

Subir a Git y enviar enlace por correo:

1. Inicie git en el directorio raiz del proyecto si no está inicializado:

```bash
cd c:/xampp/htdocs/prueba
git init
git add .
git commit -m "VIP2CARS - CRUD de vehículos y modelado de encuestas"
```

2. Cree un repositorio remoto en GitHub/GitLab, luego:

```bash
git remote add origin https://github.com/USUARIO/REPO.git
git branch -M main
git push -u origin main
```

3. Envíe el link del repositorio por correo a `sistemas@vip2cars.com` con el asunto: "Nombre Apellido - Postulación VIP2CARS".

Contacto del desarrollador:
- Indique su nombre y apellido en el asunto del correo como se pidió.
