FROM php:7.1.2-apache 

ENV TOOLS_DEPS \
        mysql-client \
        gnupg \
        wget \
        nmap \
        sudo \
        curl \
        nano \
        git \
        subversion \
        vim 

RUN apt-get update && apt-get install -y $TOOLS_DEPS

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer