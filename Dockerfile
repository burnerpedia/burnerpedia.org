FROM php:apache
MAINTAINER Keri Henare <keri.burnerpedia@henare.co.nz>

ENV MEDIAWIKI_VERSION 1.27
ENV MEDIAWIKI_FULL_VERSION 1.27.1

RUN set -x; \
    apt-get update && \
    apt-get install -y --no-install-recommends \
        g++ \
        libicu52 \
        libicu-dev && \
    pecl install intl && \
    echo extension=intl.so >> /usr/local/etc/php/conf.d/ext-intl.ini && \
    apt-get purge -y --auto-remove g++ libicu-dev && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    mbstring \
    mysqli \
    opcache\
    sockets

RUN set -x; \
    apt-get update && \
    apt-get install -y --no-install-recommends imagemagick && \
    rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

# https://www.mediawiki.org/keys/keys.txt
RUN gpg --keyserver pool.sks-keyservers.net --recv-keys \
    441276E9CCD15F44F6D97D18C119E1A64D70938E \
    41B2ABE817ADD3E52BDA946F72BC1C5D23107F8A \
    162432D9E81C1C618B301EECEE1F663462D84F01 \
    1D98867E82982C8FE0ABC25F9B69B3109D3BB7B0 \
    3CEF8262806D3F0B6BA1DBDD7956EE477F901A30 \
    280DB7845A1DCAC92BB5A00A946B02565DC00AA7

# Download MediaWiki
RUN MEDIAWIKI_DOWNLOAD_URL="https://releases.wikimedia.org/mediawiki/$MEDIAWIKI_VERSION/mediawiki-$MEDIAWIKI_FULL_VERSION.tar.gz"; \
    set -x; \
    mkdir -p /usr/src/mediawiki && \
    curl -fSL "$MEDIAWIKI_DOWNLOAD_URL" -o mediawiki.tar.gz && \
    curl -fSL "${MEDIAWIKI_DOWNLOAD_URL}.sig" -o mediawiki.tar.gz.sig && \
    gpg --verify mediawiki.tar.gz.sig && \
    mkdir -p /var/www/html/wiki && \
    tar -xf mediawiki.tar.gz -C /var/www/html/wiki --strip-components=1 && \
    rm -rf mediawiki.tar.gz mediawiki.tar.gz.sig

# Config
ADD mediawiki/LocalSettings.php /var/www/html/wiki

# Theme & Skin
RUN set -x; \
    rm -rf /var/www/html/wiki/skins/Vector
ADD mediawiki/theme /var/www/html/wiki/theme
ADD mediawiki/skins/Vector /var/www/html/wiki/skins/Vector
ADD mediawiki/extensions/googleAnalytics /var/www/html/wiki/extensions/googleAnalytics
ADD mediawiki/extensions/AbuseFilter /var/www/html/wiki/extensions/AbuseFilter
ADD mediawiki/extensions/Mailgun /var/www/html/wiki/extensions/Mailgun
ADD mediawiki/extensions/ReplaceText /var/www/html/wiki/extensions/ReplaceText

RUN set -x; \
    chown -R www-data:www-data /var/www/html

# Configure Apache
COPY apache/mediawiki.conf /etc/apache2/mediawiki.conf
RUN echo Include /etc/apache2/mediawiki.conf >> /etc/apache2/apache2.conf

# Entrypoint
CMD ["apache2-foreground"]
