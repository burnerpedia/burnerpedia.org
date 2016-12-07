FROM php:apache
MAINTAINER Keri Henare <keri.burnerpedia@henare.co.nz>

COPY . /tmp/burnerpedia
RUN chmod +x /tmp/burnerpedia/setup/install.sh && /tmp/burnerpedia/setup/install.sh

# Entrypoint
CMD ["apache2-foreground"]
