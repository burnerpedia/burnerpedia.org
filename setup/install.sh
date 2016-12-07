#!/usr/bin/env bash

MEDIAWIKI_VERSION="1.28"
MEDIAWIKI_FULL_VERSION="1.28.0"
MEDIAWIKI_DOWNLOAD_URL="https://releases.wikimedia.org/mediawiki/$MEDIAWIKI_VERSION/mediawiki-$MEDIAWIKI_FULL_VERSION.tar.gz"

echo "Running install.sh ..."

gpg --keyserver pool.sks-keyservers.net --recv-keys \
    441276E9CCD15F44F6D97D18C119E1A64D70938E \
    41B2ABE817ADD3E52BDA946F72BC1C5D23107F8A \
    162432D9E81C1C618B301EECEE1F663462D84F01 \
    1D98867E82982C8FE0ABC25F9B69B3109D3BB7B0 \
    3CEF8262806D3F0B6BA1DBDD7956EE477F901A30 \
    280DB7845A1DCAC92BB5A00A946B02565DC00AA7

apt-get update
apt-get install -y --no-install-recommends \
    g++ \
    git \
    imagemagick \
    libicu52 \
    libicu-dev

docker-php-ext-install \
    mbstring \
    mysqli \
    opcache\
    sockets

pecl install intl
echo extension=intl.so >> /usr/local/etc/php/conf.d/ext-intl.ini

apt-get purge -y --auto-remove g++ libicu-dev
rm -rf /var/lib/apt/lists/*

# MediaWiki
mkdir -p /var/www/html/wiki
curl -fSL "$MEDIAWIKI_DOWNLOAD_URL" -o mediawiki.tar.gz
curl -fSL "${MEDIAWIKI_DOWNLOAD_URL}.sig" -o mediawiki.tar.gz.sig
gpg --verify mediawiki.tar.gz.sig
tar -xf mediawiki.tar.gz -C /var/www/html/wiki --strip-components=1
rm -rf mediawiki.tar.gz mediawiki.tar.gz.sig
rm -rf /var/www/html/wiki/skins/Vector

# Copy custom code
cp /tmp/burnerpedia/mediawiki/LocalSettings.php /var/www/html/wiki
cp -r /tmp/burnerpedia/mediawiki/theme /var/www/html/wiki/theme
cp -r /tmp/burnerpedia/mediawiki/skins/Vector /var/www/html/wiki/skins/Vector
cp -r /tmp/burnerpedia/mediawiki/extensions/* /var/www/html/wiki/extensions
cp /tmp/burnerpedia/public/* /var/www/html

# Composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === 'aa96f26c2b67226a324c27919f1eb05f21c248b987e6195cad9690d5c1ff713d53020a02ac8c217dbf90a7eacc9d141d') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
cp /tmp/burnerpedia/mediawiki/composer.local.json /var/www/html/wiki
cd /var/www/html/wiki && ../composer.phar install --no-dev --no-progress --no-suggest --optimize-autoloader

chown -R www-data:www-data /var/www/html

a2enmod rewrite
cp /tmp/burnerpedia/apache/mediawiki.conf /etc/apache2
echo Include /etc/apache2/mediawiki.conf >> /etc/apache2/apache2.conf

rm -rf /tmp/burnerpedia
