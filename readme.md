```markdown
# 📚 API Books Laravel v5.8

## 🚀 Descripción
API RESTful construida en **Laravel 5.8** para la gestión de autores y libros.  
Incluye autenticación JWT, validaciones, controladores organizados y respuestas uniformes en JSON.

---

## 📑 Documentación
La documentación completa de la API está disponible en Swagger UI:  
👉 [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

También puedes acceder al archivo JSON generado:  
👉 [http://localhost:8000/docs/api-docs.json](http://localhost:8000/docs/api-docs.json)

---

## ⚙️ Instalación

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/MiguelRodac/api-books-laravel-v5.8
   cd api-books-laravel-v5.8
   ```

2. Instalar dependencias:
   ```bash
   composer install
   ```

3. Configurar `.env`:
   ```env
   APP_NAME=API_Books
   APP_ENV=local
   APP_KEY=base64:...
   APP_DEBUG=true
   APP_URL=http://localhost:8000

   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=books_db
   DB_USERNAME=postgres
   DB_PASSWORD=secret

   JWT_SECRET=tu_secret_generado
   ```

4. Generar JWT Secret:
   ```bash
   php artisan jwt:secret
   ```
   Este comando actualizará tu archivo `.env` con una nueva clave en la variable `JWT_SECRET`.  
   Todos los tokens emitidos dependerán de esta clave, así que si la regeneras, los tokens anteriores dejarán de ser válidos.

5. Ejecutar migraciones:
   ```bash
   php artisan migrate
   ```

6. Levantar servidor:
   ```bash
   php artisan serve
   ```

---

## 🔑 Autenticación
La API usa **JWT**.  
- Login devuelve un token.  
- Todas las rutas protegidas requieren el header:
  ```
  Authorization: Bearer <TOKEN>
  ```

---

## 📖 Endpoints principales

### Auth
- **POST /api/auth/login**  
  Body:
  ```json
  { "email": "user@example.com", "password": "secret" }
  ```
  Respuesta:
  ```json
  { "access_token": "...", "token_type": "bearer", "expires_in": 3600 }
  ```

- **POST /api/auth/logout** → Invalida el token.  
- **GET /api/auth/me** → Devuelve datos del usuario autenticado.

---

### Authors
- **GET /api/authors** → Lista todos los autores.  
- **POST /api/authors** → Crea un autor.  
  ```json
  { "name": "Gabriel García Márquez", "email": "gabo@example.com", "bio": "Colombian novelist..." }
  ```
- **GET /api/authors/{id_author}** → Muestra un autor específico.  
- **PUT /api/authors/{id_author}** → Actualiza un autor.  
- **DELETE /api/authors/{id_author}** → Elimina un autor.

---

### Books
- **GET /api/books** → Lista todos los libros.  
- **POST /api/books** → Crea un libro.  
  ```json
  {
    "title": "Cien años de soledad",
    "description": "Novela emblemática del realismo mágico.",
    "published_at": "2025-11-24",
    "available": true,
    "id_author": 1
  }
  ```
- **GET /api/books/{id_book}** → Muestra un libro específico.  
- **PUT /api/books/{id_book}** → Actualiza un libro.  
- **DELETE /api/books/{id_book}** → Elimina un libro.

---

## 🧪 Ejemplos con curl

Crear un autor:
```bash
curl -X POST http://localhost:8000/api/authors \
  -H "Authorization: Bearer TU_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"name":"Gabriel García Márquez","email":"gabo@example.com","bio":"Colombian novelist"}'
```

Crear un libro:
```bash
curl -X POST http://localhost:8000/api/books \
  -H "Authorization: Bearer TU_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title":"Cien años de soledad","description":"Novela emblemática del realismo mágico.","published_at":"2025-11-24","available":true,"id_author":1}'
```

---

## 📂 Estructura del proyecto
- `app/Models` → Modelos (`Author`, `Book`, `User`)  
- `app/Http/Controllers` → Controladores REST  
- `app/Http/Requests` → Validaciones  
- `routes/api.php` → Definición de endpoints  
- `config/jwt.php` → Configuración JWT  

---

## ✅ Conclusión
La API está lista para pruebas y despliegue.  
Con este README y documentación, cualquier reviewer puede levantar el proyecto y probar los endpoints fácilmente.
```

---
