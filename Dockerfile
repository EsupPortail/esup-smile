FROM php:8.0-apache-bullseye

ENV PHP_VERSION=8.0

#Add proxy
ENV HTTP_PROXY http://proxy.unicaen.fr:3128
ENV HTTPS_PROXY http://proxy.unicaen.fr:3128
RUN export http_proxy=$HTTP_PROXY
RUN export https_proxy=$HTTPS_PROXY
RUN touch /etc/apt/apt.conf.d/05proxy
RUN echo 'Acquire::HTTP::Proxy "http://proxy.unicaen.fr:3128";' >> /etc/apt/apt.conf.d/05proxy
RUN echo 'Acquire::HTTPS::Proxy "http://proxy.unicaen.fr:3128";' >> /etc/apt/apt.conf.d/05proxy
RUN echo 'Acquire::ftp::Proxy "http://proxy.unicaen.fr:3128";' >> /etc/apt/apt.conf.d/05proxy

# Deploy configuration & sources
RUN mkdir /smile-app
WORKDIR /smile-app
ADD ./src /smile-app
ADD ./deploy_configuration/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
ADD ./deploy_configuration/generate_env.sh /smile-app/generate_env.sh
#ADD ./deploy_configuration/php/99-app.ini /usr/local/etc/php/conf.d/docker-php-ext-sodium.ini


# Répertoires de travail de Doctrine
RUN mkdir -p data/cache
RUN mkdir -p data/DoctrineModule/cache
RUN mkdir -p data/DoctrineORMModule/Proxy

RUN chmod -R 777 data

# Prepare packages management
#fix no candidates
RUN rm /etc/apt/preferences.d/no-debian-php
#Continue
RUN apt-get update -y
RUN apt-get install -y git libc6 wget gnupg2 apt-transport-https lsb-release ca-certificates

RUN apt-get -qq update
RUN apt-get -y install apt-transport-https lsb-release ca-certificates curl
RUN curl -sSLo /usr/share/keyrings/deb.sury.org-php.gpg https://packages.sury.org/php/apt.gpg
RUN sh -c 'echo "deb [signed-by=/usr/share/keyrings/deb.sury.org-php.gpg] https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list'
RUN wget -e use_proxy=on -e https_proxy=$HTTP_PROXY --no-check-certificate -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list

RUN apt-get upgrade
RUN apt-get update

# Enable previous extension

RUN docker-php-ext-install bcmath
#RUN docker-php-ext-install curl
#RUN docker-php-ext-install dev
#RUN docker-php-ext-install fpm
RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev libpng-dev
RUN docker-php-ext-install gd
RUN docker-php-ext-install gettext
RUN docker-php-ext-install iconv
#RUN docker-php-ext-install imagick
RUN apt-get install -y libicu-dev  && docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN apt-get install -y libldap2-dev
RUN docker-php-ext-install ldap
# mb string
#RUN docker-php-ext-install memcached
RUN docker-php-ext-install opcache
RUN apt-get install -y libpq-dev

RUN docker-php-ext-install pgsql
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-enable pdo_pgsql
RUN docker-php-ext-configure pgsql
RUN apt-get install -y libxml2-dev
RUN docker-php-ext-install soap
#RUN docker-php-ext-install xdebug
RUN docker-php-ext-install xml
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip
#RUN docker-php-ext-install cli
#RUN docker-php-ext-install common
# Prepare PHP


# Build smile-app

# Install composer 
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
RUN HASH=`curl -sS https://composer.github.io/installer.sig`
RUN echo $HASH
RUN php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Build Smile
RUN composer install --no-dev --no-suggest --optimize-autoloader 
#Fix bug unicaen auth
RUN composer update
RUN composer require unicaen/auth "6.0.1"

RUN chown -R www-data:www-data /smile-app/data


# Reload configuration
RUN a2enmod rewrite

ENV HTTP_PROXY ""
ENV HTTPS_PROXY ""
RUN export http_proxy=""
RUN export https_proxy=""
RUN rm /etc/apt/apt.conf.d/05proxy

RUN service apache2 restart