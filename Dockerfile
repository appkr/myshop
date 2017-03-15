FROM appkr/apache-php-base

ENV TZ=Asia/Seoul

#-------------------------------------------------------------------------------
# Timezone Setting
#-------------------------------------------------------------------------------

RUN echo $TZ | tee /etc/timezone \
    && dpkg-reconfigure --frontend noninteractive tzdata

#-------------------------------------------------------------------------------
# Install packages
#-------------------------------------------------------------------------------

RUN apt-get update && apt-get install -y --no-install-recommends \
        supervisor \
        cron \
        git \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

#-------------------------------------------------------------------------------
# Copy Configurations
#-------------------------------------------------------------------------------

COPY docker-files /

#-------------------------------------------------------------------------------
# Apache Setting
#-------------------------------------------------------------------------------

RUN a2dissite 000-default.conf \
    && a2ensite server.conf \
    && a2enmod rewrite deflate headers

#-------------------------------------------------------------------------------
# Publish Applications
#-------------------------------------------------------------------------------

ADD . /var/www/html

RUN chmod -R 775 /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/storage

RUN echo "" >> /root/.bashrc \
    && echo "export TERM=xterm-256color" >> /root/.bashrc

#-------------------------------------------------------------------------------
# Install Cron Job
#-------------------------------------------------------------------------------

RUN crontab /etc/cron.d/cronjob \
    && touch /var/log/cron.log

#-------------------------------------------------------------------------------
# Start Supervisord
#-------------------------------------------------------------------------------

WORKDIR /var/www/html

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]