# Instrucciones de instalación y ejecución

Este proyecto utiliza **Docker** para levantar el entorno completo de desarrollo, incluyendo la aplicación, el servidor web, el entorno de frontend y la base de datos MySQL.

A continuación se detallan los pasos necesarios para ejecutar el proyecto desde cero.

---

## 1. Copiar archivo `.env`

Antes de iniciar el entorno, es necesario copiar el archivo `.env` provisto en el siguiente link y colocarlo en la raíz del proyecto:

```
https://www.notion.so/Adrian-Mercado-env-Prueba-Tecnica-2aea6a1d244d8018bae7d8250e407001?source=copy_link
```

Este archivo contiene la configuración necesaria para el correcto funcionamiento de la aplicación.

---

## 2. Verificar puertos necesarios

Previo a iniciar los contenedores, asegurarse de que los siguientes puertos **no estén en uso**:

* **80** → Servidor web
* **8080** → Reverb / WebSockets
* **5173** → Frontend (Vite)
* **3306** → Base de datos MySQL

En caso de estar ocupados, liberar los puertos o modificar las configuraciones correspondientes.

---

## 3. Levantar los contenedores con Docker

Una vez verificados los puertos, levantar el entorno con:

```
docker compose up -d
```

Este comando descargará las imágenes necesarias (si no existen), construirá los contenedores y los dejará ejecutándose en segundo plano.

---

## 4. Ingresar al contenedor de la aplicación

Para ejecutar comandos internos de Laravel, ingresar al contenedor principal:

```
docker exec -it am_app bash
```

Esto abrirá una terminal dentro del contenedor.

---

## 5. Ejecutar el proceso de inicialización

Dentro del contenedor, correr el comando:

```
php artisan app:boot
```

Este comando inicializa la aplicación (migraciones, seeders u otros procesos definidos en el proyecto).

---

## 6. Aplicación lista

Una vez completados los pasos anteriores, la aplicación estará lista para utilizarse.

Podés acceder desde el navegador o mediante las herramientas indicadas en la documentación del proyecto.
