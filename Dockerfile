FROM php:8.3-apache

# Actualiza zona horaria
ENV TZ=America/Bogota
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Establecer parámetros principales
ARG environment

ENV ENV=$environment
ENV APP_HOME /var/www/html
ENV USERNAME=www-data
ENV USER=root


# instalacion de dependencias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libaio1 \
    libaio-dev \
    libzip-dev \
    vim \
    libcurl4-openssl-dev \
    supervisor

# Instala locales
RUN apt-get install -y locales && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen

# Actualizar composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Descarga los archivos de Oracle Instant Client
COPY ./docker/config/instantclient-basic-linux.x64-21.3.0.0.0.zip /tmp/
COPY ./docker/config/instantclient-sdk-linux.x64-21.3.0.0.0.zip /tmp/

# Descomprime los archivos de Oracle Instant Client
RUN unzip /tmp/instantclient-basic-linux.x64-21.3.0.0.0.zip -d /opt/oracle \
    && unzip /tmp/instantclient-sdk-linux.x64-21.3.0.0.0.zip -d /opt/oracle \
    && ln -s /opt/oracle/instantclient_21_3 /opt/oracle/instantclient \
    && rm /tmp/instantclient-basic-linux.x64-21.3.0.0.0.zip \
    && rm /tmp/instantclient-sdk-linux.x64-21.3.0.0.0.zip


# Configurando Oracle Instant Client
RUN sh -c "echo /opt/oracle/instantclient_21_3 > /etc/ld.so.conf.d/oracle-instantclient.conf"
RUN ldconfig


ENV ORACLE_HOME /opt/oracle/instantclient_19_19


# Agregando variables de entorno
ENV PATH=$ORACLE_HOME:/usr/sbin:$PATH \
    LD_LIBRARY_PATH=$ORACLE_HOME:/usr/lib \
    CLASSPATH=$ORACLE_HOME



#Habilitar extensiones
RUN docker-php-ext-configure oci8 --with-oci8=instantclient,/opt/oracle/instantclient_21_3
RUN docker-php-ext-install curl pdo pdo_mysql mysqli mbstring exif pcntl bcmath gd sockets oci8 zip


# limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


# 3. mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

RUN chmod -R 777 /var/www/html

# 4. start with base php config, then add extensions
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"


# cambiar directorio de trabajo
WORKDIR /var/www/html

# instalar dependencias del proyecto
#RUN composer install

#USER $user

EXPOSE 8011

