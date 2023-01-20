# Utilisez l'image officielle de PHP 8.1 en tant qu'image de base
FROM php:8.1-fpm-alpine

# Installez les dépendances nécessaires pour Symfony
RUN apk update && \
    apk add --no-cache \
        git \
        unzip \
        icu-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        libwebp-dev

# Configurez les extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Installez les extensions PHP
RUN docker-php-ext-install \
        intl \
        pdo_mysql \
        gd \
        zip \
        opcache

# Installez nginx et configurez le serveur
RUN apk add --no-cache nginx && \
    mkdir -p /run/nginx
COPY config/nginx.conf /etc/nginx/nginx.conf

# Copiez le projet Symfony dans le container
COPY . /var/www/symfony

# Configurez les permissions pour le propriétaire du processus PHP
RUN chown -R www-data:www-data /var/www/symfony

# Définissez le répertoire de travail pour le processus PHP
WORKDIR /var/www/symfony

# Exposez les ports nginx et PHP
EXPOSE 80
EXPOSE 9000

# Démarrez nginx et PHP en arrière-plan
CMD ["sh", "-c", "nginx && php-fpm"]
