FROM ubuntu:16.04

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=Asia/Seoul
ENV APACHE_ENVVARS=/etc/apache2/envvars
ENV WWW_ROOT_DIR=/var/www/html

#-------------------------------------------------------------------------------
# System Timezone Setting
#-------------------------------------------------------------------------------

RUN echo $TZ | tee /etc/timezone \
    && dpkg-reconfigure --frontend noninteractive tzdata

#-------------------------------------------------------------------------------
# Install Packages
#-------------------------------------------------------------------------------

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        apache2 \
        ca-certificates \
        supervisor \
        php \
        php-cli \
        php-intl \
        php-zip \
        php-curl \
        php-gd \
        php-mbstring \
        php-mysql \
        php-sqlite3 \
        php-opcache \
        php-xml \
        libapache2-mod-php \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

#-------------------------------------------------------------------------------
# Copy Settings
#-------------------------------------------------------------------------------

COPY docker-files /

#-------------------------------------------------------------------------------
# Apache Settings
#-------------------------------------------------------------------------------

RUN a2dissite 000-default \
    && rm /etc/apache2/sites-available/000-default.conf \
    && a2ensite server \
    && a2enmod rewrite deflate headers

RUN usermod -u 1000 www-data \
    && groupmod -g 1000 www-data

#-------------------------------------------------------------------------------
# Enable Application
#-------------------------------------------------------------------------------

ADD . /var/www/html

RUN chmod -R 775 /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/storage \
    && mv /var/www/html/.env.production /var/www/html/.env

#-------------------------------------------------------------------------------
# Run Environment
#-------------------------------------------------------------------------------

EXPOSE 80

WORKDIR /var/www/html

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]