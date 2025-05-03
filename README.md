Vanity And Magic

Este es un proyecto Laravel con Docker para gestionar [explica brevemente la funcionalidad del proyecto]. A continuación, encontrarás instrucciones detalladas para configurar, ejecutar y contribuir al proyecto.

📌 Requisitos Previos

Antes de comenzar, asegúrate de tener instalados los siguientes programas en tu sistema:

Docker: Para correr los contenedores del proyecto.

Git: Para clonar y gestionar el código fuente.

Composer: Para manejar las dependencias de PHP.

NVM (Node Version Manager): Para gestionar la versión de Node.js.

Si no los tienes, instálalos desde sus sitios oficiales:

Docker: https://www.docker.com/

Git: https://git-scm.com/

Composer: https://getcomposer.org/

NVM (Linux/macOS): https://github.com/nvm-sh/nvm

NVM para Windows: https://github.com/coreybutler/nvm-windows

🚀 Instalación y Configuración

1️⃣ Clonar el Repositorio

Abre una terminal y ejecuta el siguiente comando:

git clone git@github.com:EstebanKnabal9/Vanity-And-Magic.git
cd Vanity-And-Magic

2️⃣ Configurar Variables de Entorno

Renombra el archivo de configuración de entorno:

cp .env.example .env

Luego, edita el archivo .env y asegúrate de configurar correctamente la base de datos:

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=vanity
DB_USERNAME=vanity_user
DB_PASSWORD=secret

3️⃣ Construir y Levantar los Contenedores Docker

Ejecuta los siguientes comandos:

docker-compose up -d --build

Este comando construirá y ejecutará los contenedores en segundo plano.

4️⃣ Instalar Dependencias

Para Linux/macOS

Antes de instalar dependencias, asegúrate de tener la versión correcta de Node.js usando nvm:

nvm install 18  # O la versión que necesites
nvm use 18      # Activa esa versión

Para Windows

Si usas Windows, instala NVM para Windows y ejecuta:

nvm install 18
nvm use 18

Luego, dentro del contenedor de la aplicación, ejecuta:

docker exec -it vanity_app bash
composer install
npm install
npm run dev

5️⃣ Ejecutar Migraciones de Base de Datos

docker exec -it vanity_app bash
php artisan migrate

Este comando creará las tablas necesarias en la base de datos.

6️⃣ Generar la Key de Laravel

php artisan key:generate

Esto asegurará que Laravel tenga una clave única para encriptación.

📂 Estructura del Proyecto

Vanity-And-Magic/
│── app/                # Código de la aplicación Laravel
│── bootstrap/          # Archivos de arranque
│── config/             # Configuración del proyecto
│── database/           # Migraciones y seeders
│── public/             # Archivos públicos (CSS, JS, imágenes)
│── resources/          # Vistas y assets
│── routes/             # Rutas de la aplicación
│── storage/            # Logs y caché
│── tests/              # Pruebas
│── .env                # Variables de entorno
│── docker-compose.yml  # Configuración de Docker
│── README.md           # Documentación

✅ Comandos Útiles

Aquí algunos comandos que pueden ayudarte durante el desarrollo:

Ver los logs de Laravel:

docker logs -f vanity_app

Ingresar a la base de datos MySQL:

docker exec -it vanity_mysql mysql -u vanity_user -p

Reiniciar el servidor Laravel:

php artisan serve

🛠 Solución de Problemas

Error: "docker-compose: command not found"

Solución: Asegúrate de que Docker está correctamente instalado y que docker-compose está disponible en tu sistema.

Error: "Permission denied" al correr un comando

Solución: Si estás en Linux/macOS, intenta ejecutar el comando con sudo, o revisa los permisos de los archivos.

Error: "The connection to the database could not be established"

Solución: Asegúrate de que los contenedores están corriendo (docker ps) y de que las credenciales en .env son correctas.

🤝 Contribuir

Si deseas contribuir al proyecto, sigue estos pasos:

Haz un fork del repositorio.

Crea una nueva rama (git checkout -b mi-nueva-funcionalidad).

Realiza tus cambios y haz commits (git commit -m "Descripción del cambio").

Sube tu rama (git push origin mi-nueva-funcionalidad).

Abre un Pull Request en GitHub.

📜 Licencia

Este proyecto está bajo la licencia MIT.

Si tienes problemas o preguntas, no dudes en abrir un issue en el repositorio. ¡Feliz coding! 🚀

