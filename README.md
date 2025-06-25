# 🏋️‍♂️ Gym-App Backend

Este repositorio contiene el backend de **Gym-App**, una aplicación diseñada para la gestión de avances en el gym.
Aquí se incluyen los endpoints necesarios para el registro, inicio de sesión y demás funcionalidades posteriores.

---

## 🚀 Primeros pasos

### 1️⃣ Registro de usuarios

Antes de poder utilizar los demás servicios del backend, primero necesitas registrar un usuario.

📌 **Endpoint:** `register.php`  
📥 **Método:** `POST`  
📄 **Parámetros esperados:**

```json
{
  "email": "juan@ejemplo.com",
  "password": "123456"
}
2️⃣ Inicio de sesión
Después del registro, realiza el login para autenticarte y usar el resto de los servicios.

📌 Endpoint: login.php
📥 Método: POST
📄 Parámetros esperados:
{
  "correo": "juan@ejemplo.com",
  "password": "123456"
}
🔁 Respuesta exitosa:
{
  "status": "success",
  "token": "abc123..." // agregar el token a tu heder
}

⚙️ Tecnologías utilizadas
PHP nativo
lcobucci para generar tokens
MySQL
JSON como formato de intercambio de datos
