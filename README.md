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

/etc/apache2/sites-available/default.com.conf 

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