# API de Gestión de Libros y Autores

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Acerca de Este Proyecto

Esta es una API RESTful construida con Laravel que permite gestionar libros y autores. La API incluye autenticación con Laravel Sanctum y proporciona endpoints para crear, leer, actualizar y eliminar tanto libros como autores.

## Requisitos del Sistema

- PHP 8.0 o superior
- Composer
- MySQL o compatible
- Laravel 10.x

## Guía de Instalación

Sigue estos pasos para instalar y configurar el proyecto:

1. **Clonar el repositorio**

```bash
git clone [url-del-repositorio]
cd [nombre-del-directorio]
```

2. **Instalar dependencias**

```bash
composer install
```

3. **Configurar el archivo .env**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar la base de datos**

Edita el archivo .env y configura las credenciales de tu base de datos:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

5. **Ejecutar migraciones**

```bash
php artisan migrate
```

6. **Iniciar el servidor**

```bash
php artisan serve
```

## Uso de la API

### Autenticación

#### Registro de Usuario

```
POST /api/auth/register
```

Parámetros del cuerpo (JSON):
- `name`: Nombre del usuario
- `email`: Correo electrónico del usuario
- `password`: Contraseña del usuario
- `password_confirmation`: Confirmación de la contraseña

#### Inicio de Sesión

```
POST /api/auth/login
```

Parámetros del cuerpo (JSON):
- `email`: Correo electrónico del usuario
- `password`: Contraseña del usuario

Respuesta: Token de autenticación que debes incluir en las cabeceras de las siguientes peticiones.

#### Cerrar Sesión

```
POST /api/auth/logout
```

Requiere autenticación. Incluye el token en la cabecera:
```
Authorization: Bearer {tu_token}
```

### Gestión de Autores

#### Obtener todos los autores
```
GET /api/authors
```

#### Obtener un autor específico
```
GET /api/authors/{id}
```

#### Crear un nuevo autor
```
POST /api/authors
```

Parámetros del cuerpo (JSON):
- `name`: Nombre del autor
- `birthdate`: Fecha de nacimiento (YYYY-MM-DD)
- `nationality`: Nacionalidad del autor

#### Actualizar un autor
```
PUT /api/authors/{id}
```

Parámetros del cuerpo (JSON) (opcionales):
- `name`: Nombre del autor
- `birthdate`: Fecha de nacimiento (YYYY-MM-DD)
- `nationality`: Nacionalidad del autor

#### Eliminar un autor
```
DELETE /api/authors/{id}
```

### Gestión de Libros

#### Obtener todos los libros
```
GET /api/books
```

#### Obtener un libro específico
```
GET /api/books/{id}
```

#### Crear un nuevo libro
```
POST /api/books
```

Parámetros del cuerpo (JSON):
- `title`: Título del libro
- `publication_date`: Fecha de publicación (YYYY-MM-DD)
- `isbn`: Número ISBN
- `author_id`: ID del autor

#### Actualizar un libro
```
PUT /api/books/{id}
```

Parámetros del cuerpo (JSON) (opcionales):
- `title`: Título del libro
- `publication_date`: Fecha de publicación (YYYY-MM-DD)
- `isbn`: Número ISBN
- `author_id`: ID del autor

#### Eliminar un libro
```
DELETE /api/books/{id}
```

## Ejemplos de Uso

### Registro de un nuevo usuario

```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Usuario Ejemplo","email":"usuario@ejemplo.com","password":"contraseña123","password_confirmation":"contraseña123"}'
```

### Inicio de sesión

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"usuario@ejemplo.com","password":"contraseña123"}'
```

### Crear un autor

```bash
curl -X POST http://localhost:8000/api/authors \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {tu_token}" \
  -d '{"name":"Gabriel García Márquez","birthdate":"1927-03-06","nationality":"Colombiano"}'
```

### Crear un libro

```bash
curl -X POST http://localhost:8000/api/books \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {tu_token}" \
  -d '{"title":"Cien años de soledad","publication_date":"1967-05-30","isbn":"9780307350427","author_id":1}'
```

## Licencia

Este proyecto está licenciado bajo la [Licencia MIT](https://opensource.org/licenses/MIT).
