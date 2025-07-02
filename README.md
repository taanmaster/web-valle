## Instalación en Servidor desde Linea de Comandos

### Requisitos de Servidor

La configuración recomendada es LAMP Stack.

* Ubuntu - 18.04
* Apache2 - 2.4.29
* MySQL server 5.7.23
* PHP - 8.1
* Phpmyadmin (OPCIONAL)

Tambien es posible implementar la plataforma en un Stack LEMP

* Ubuntu - 18.04
* Nginx - 1.14.0
* MySQL server 5.7.23
* PHP - 8.1
* Phpmyadmin (OPCIONAL)

Las instrucciones de instalación se enfocarán en Apache 2, si se implementa en Nginx hacer modificaciones en donde sea necesario.

-----------------------

### Instalar Git, Unzip.

```
sudo apt-get install git
sudo apt-get install unzip

```

### Instalar CURL + Composer

```
sudo apt-get install curl php8.0-curl php8.0-xml php8.0-gd php8.0-opcache php8.0-mbstring php8.0-zip php7.4-curl php7.4-xml php7.4-gd php7.4-opcache php7.4-mbstring php7.4-zip

curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### Habilitar Mods

```
sudo phpenmod mbstring
sudo a2enmod rewrite
sudo systemctl restart apache2

```

### Git CLONE del Proyecto en carpeta HTML

```
cd /var/www/html
git clone [RUTA DEL PROYECTO]
```

### Habilitar Rewrite para la carpeta

```
sudo chmod -R 777 [NOMBRE_DE_LA_CARPETA]

```

### Entrar en carpeta de proyecto

```
cd /[NOMBRE_DE_LA_CARPETA]
```

### Actualizar carpeta con COMPOSER 

```
composer update
```

### Crear una Llave de Encriptación

```
cp .env.example .env
php artisan key:generate
```
Es importante abrir el archivo .env para configurar la conexión a la base de datos si es que se requiere.

### Configurar Directorio de Proyecto

/etc/apache2/sites-available/000-default.conf 

```
<VirtualHost *:80>
	ServerName [RUTA].com
	DocumentRoot /var/www/html/[[ NOMBRE_DE_LA_CARPETA ]]/public

	<Directory /var/www/html/[[ NOMBRE_DE_LA_CARPETA ]]/public>
		AllowOverride All
		Require all granted
	</Directory>
</VirtualHost>
```
Si es necesario utilizar un certificado de seguridad utilizar el puerto 443 y activar las capacidades SSL del servidor por medio de la linea de comandos. Es importante que el certificado se encuentre en la ruta correcta que se determina en ese documento.

### Reiniciar Servidor

```
service apache2 reload

```

## Activación de SSL desde Linea de Comandos

Subir los archivos .crt y .key a la carpeta `ssl` utilizando un programa FTP como FileZilla, Cyberduck u otros.

### Configurar Directorio de Proyecto

Modificar el archivo de directorio de proyecto en `/etc/apache2/sites-available/000-default.conf` a lo siguiente:

```
<VirtualHost *:80>
   ServerName [[ DOMINIO_DEL_PROYECTO ]]
   Redirect permanent / https://[[ DOMINIO_DEL_PROYECTO ]]
</VirtualHost>

<IfModule mod_ssl.c>
    <VirtualHost _default_:443>
            ServerAdmin [[ CORREO_USUARIO_ADMIN ]]
            ServerName [[ DOMINIO_DEL_PROYECTO ]]
            DocumentRoot /var/www/html/[[ NOMBRE_DE_LA_CARPETA ]]/public

            SSLEngine on
            SSLCertificateFile /etc/ssl/[[ ARCHIVO_SSL ]].crt
            SSLCertificateKeyFile /etc/ssl/[[ ARCHIVO_SSL ]].key
            SSLCACertificateFile /etc/ssl/intermediate.crt

            <Directory /var/www/html/[[ NOMBRE_DE_LA_CARPETA ]]/public>
                Options Indexes FollowSymLinks
                AllowOverride All
                Require all granted
            </Directory>

            ErrorLog ${APACHE_LOG_DIR}/error.log
            CustomLog ${APACHE_LOG_DIR}/access.log combined

            <IfModule mod_dir.c>
                DirectoryIndex index.php index.pl index.cgi index.html index.xhtml index.htm
            </IfModule>

    </VirtualHost>
</IfModule>

```

### Activar Módulo SSL del Servidor

Para activar el módulo SSL del servidor corre el siguiente comando en la linea de comandos:

```
sudo a2enmod ssl
```

### Reiniciar Servidor

```
service apache2 reload

```

### Instalar paqueterias de CSS y JS

```
npm install

npm run build
```

# Configuración PHP para archivos grandes
# Agregar estas líneas a tu .htaccess o configurar en php.ini

# Aumentar límite de tamaño de archivo (500MB)
php_value upload_max_filesize 500M
php_value post_max_size 500M

# Aumentar tiempo de ejecución para archivos grandes
php_value max_execution_time 300
php_value max_input_time 300

# Aumentar memoria disponible
php_value memory_limit 512M

# Para nginx, agregar a tu configuración:
# client_max_body_size 500M;
# client_body_timeout 300s;
# client_header_timeout 300s;
