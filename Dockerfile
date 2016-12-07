FROM php:apache
MAINTAINER Keri Henare <keri.burnerpedia@henare.co.nz>

COPY . /tmp/burnerpedia
RUN /tmp/burnerpedia/setup/install.sh

# Entrypoint
CMD ["apache2-foreground"]
