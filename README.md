# CRUD Usuarios: Arquitectura Hexagonal con DDD y CQRS

Aplicación web PHP para la gestión de usuarios: registro, listado, visualización, edición, eliminación, autenticación con sesión y recuperación de contraseña por correo.

## Ejercicio 25: CRUDL de Emisora

Además de la entidad `Usuario`, este fork implementa la entidad **Emisora** en todas las capas:

| Capa | Componentes |
|---|---|
| Dominio | `EmisoraModel`, `GeneroEmisoraEnum`, value objects `EmisoraId`, `EmisoraNombre`, `BandaFm`, `BandaAm`, excepciones `InvalidEmisoraException`, `EmisoraNotFoundException`, `EmisoraAlreadyExistsException` |
| Aplicación | Puertos de entrada (`CreateEmisoraUseCase`...), puertos de salida (`SaveEmisoraPort`...), comandos y consultas CQRS, `EmisoraApplicationMapper` y 5 servicios |
| Adaptadores | `EmisoraRepositoryMySQL` (PDO), DTO de persistencia, entidad y mapper |
| Entrypoints | `EmisoraController` + vistas (`emisoras/list, create, edit, show`), `EmisoraApiController` (API JSON con manejo de errores 400/401/404/409/500), `EmisoraWebRequest`, `EmisoraResponse`, `EmisoraWebMapper`, documentación OpenAPI/Swagger en `public/docs/` |
| Común | `ClassLoader` y `DependencyInjection` registran y construyen los componentes de Emisora |

Atributos: `nombre, canal, bandaFm, bandaAm, numLocutores, genero, horario, patrocinador, pais,
descripcion, numProgramas, numCiudades`.

Reglas de negocio: id y nombre únicos; debe transmitir en FM (87.5–108.0 MHz), en AM
(530–1710 kHz) o en ambas; al menos 1 locutor y 1 ciudad; programas no negativos.

### Rutas

| Web (vistas) | API JSON | Método |
|---|---|---|
| `?route=emisoras.index` | `index.php/api/emisoras` | GET |
| `?route=emisoras.create` / `emisoras.store` | `index.php/api/emisoras` | POST |
| `?route=emisoras.show&id=...` | `index.php/api/emisoras/{id}` | GET |
| `?route=emisoras.edit` / `emisoras.update` | `index.php/api/emisoras/{id}` | PUT |
| `?route=emisoras.delete` | `index.php/api/emisoras/{id}` | DELETE |

Todas requieren sesión iniciada (`admin@example.com` / `Admin1234!`). La API responde `401` sin sesión.

### Ejecutar con Docker Compose

```bash
docker compose up --build
```

- Aplicación: <http://localhost:8081/public/index.php>
- Swagger: <http://localhost:8081/public/docs/swagger.html>
- MySQL: puerto `3307` (usuario `users_app`). `database/schema.sql` crea las tablas `users` y
  `emisoras` con el administrador y 3 emisoras de ejemplo.

### Pruebas

- `php tests/EmisoraDomainTest.php`: pruebas del dominio y los casos de uso con un repositorio en memoria.
- `postman/Emisoras-PHP.postman_collection.json`: colección para el Collection Runner
  (sin sesión, login, listar, crear, duplicado, validaciones, consultar, actualizar, eliminar).

### Nube y GitHub Actions

- `render.yaml` define el servicio web Docker en Render. Las variables `DB_*` apuntan a una base
  MySQL en la nube (por ejemplo Aiven o Railway) donde se ejecuta `database/schema.sql`.
- `.github/workflows/ci-cd.yml` revisa la sintaxis de todos los archivos PHP, ejecuta las pruebas,
  construye la imagen Docker y, en `main`, llama al Deploy Hook de Render (secreto
  `RENDER_DEPLOY_HOOK_URL`).

---

## Tecnologías

- PHP 8.3
- MySQL
- Apache mod_rewrite

---

## Funcionalidades

- Crear, listar, ver, editar y eliminar usuarios
- Autenticación con sesión (login / logout)
- Recuperación de contraseña mediante contraseña temporal enviada por correo
- Protección de rutas según estado de autenticación
- Protección contra acceso directo a archivos y listado de directorios
- Envía notificaciones a los usuarios vía Correo Electronico

---

## Conceptos aplicados

### Arquitectura general
- Arquitectura Hexagonal (Ports & Adapters)
- DDD (Domain-Driven Design)
- CQRS
- Capas: Domain / Application / Infrastructure / Entrypoints
- Front Controller · Single Entry Point

### Capa de Dominio
- Rich Domain Model
- Value Objects
- Named Constructors
- Domain Exceptions
- Domain Events
- Enumerations (Enums)
- Ubiquitous Language
- Inmutabilidad
- Fail-fast validation
- Encapsulación de reglas de negocio


### Capa de Aplicación
- Use Cases
- Application Services
- Ports In (interfaces de casos de uso)
- Ports Out (interfaces de persistencia)
- Commands y Queries
- DTOs
- Anti-corruption Layer
- Application Mapper


### Capa de Infraestructura
- Repository Pattern
- Data Mapper
- Persistence DTO
- Persistence Entity
- PDO con Prepared Statements
- Adapter Pattern

### Entrypoints / Presentación
- Enrutamiento por query string (`?route=`)
- PRG (Post-Redirect-Get)
- Flash Messages
- Autenticación basada en sesiones
- Web Mapper
- Web DTOs (WebRequest / UserResponse)
- `View::render` con `extract`
- Security Guard (IIFE)

---

### Patrones de diseño
- Front Controller
- Repository
- Data Mapper
- Factory Method
- DTO
- Strategy
- Template Method
- IIFE
- PRG (Post-Redirect-Get)

### Principios SOLID
- **SRP** — Single Responsibility Principle
- **OCP** — Open/Closed Principle
- **LSP** — Liskov Substitution Principle
- **ISP** — Interface Segregation Principle
- **DIP** — Dependency Inversion Principle

### Principios de Clean Code
- `declare(strict_types=1)` en todos los archivos
- Clases `final`
- Value Objects inmutables
- Named Constructors
- Fail-fast
- Nombres autodocumentados
- Separación estricta de capas
- Sin fugas de abstracción
- Fail-safe defaults (valores por defecto seguros)

### Configuración externalizada (12-Factor App: Factor III)
- Variables de entorno separadas del código fuente
- Credenciales en `.env` (ignorado por git), nunca en se debe publicar en el repo
- `.env.example` como plantilla y documentación de ejemplo para el equipo
- `EnvLoader` con responsabilidad única: leer el entorno
- Las variables reales del servidor tienen prioridad sobre `.env` (environment-over-code)

### Seguridad

- Credenciales fuera del código fuente y del historial de git

