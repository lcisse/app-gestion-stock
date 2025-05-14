# Utiliser l'image PHP avec Apache
FROM php:8.2-apache

# Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libssl-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Activer la gestion des sessions PHP
RUN mkdir -p /var/lib/php/sessions && chmod -R 777 /var/lib/php/sessions

# Activer mod_rewrite pour Apache
RUN a2enmod rewrite

# Installer Composer depuis l'image officielle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer l'extension MongoDB
RUN pecl install mongodb \
    && echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini

# Copier les fichiers du projet dans un sous-dossier
COPY . /var/www/html/

# Changer les droits pour éviter les erreurs d'accès
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html/gestion-stock/

# Installer les dépendances avec Composer (autoloader, etc.)
RUN composer install || composer dump-autoload

# Copier un fichier de configuration Apache personnalisé
COPY default.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default.conf

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
