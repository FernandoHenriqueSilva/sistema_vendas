# Use a imagem base oficial do PHP com Apache
FROM php:8.2-apache

# Instale dependências do sistema
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip \
    && docker-php-ext-install mysqli

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie o código fonte do aplicativo para o contêiner
COPY . /var/www/html/

# Defina o diretório de trabalho
WORKDIR /var/www/html/

# Ajuste permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Garanta que o script de entrada seja executável
RUN chmod +x /usr/local/bin/docker-php-entrypoint

# Instale as dependências do Composer
RUN composer install --no-plugins --no-scripts --no-interaction

# Exponha a porta 80
EXPOSE 80

# Defina o comando de entrada explicitamente
CMD ["apache2-foreground"]
