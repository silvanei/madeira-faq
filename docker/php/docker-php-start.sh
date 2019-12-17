#!/usr/bin/env sh
set -e

DEBUG=${DEBUG:-0}
COMPOSER_INSTALL=${COMPOSER_INSTALL:-1}
COMPOSER_INSTALL_PARANS=${COMPOSER_INSTALL_PARANS:-"--prefer-dist --no-scripts --no-dev --optimize-autoloader"}

if [ "$DEBUG" = "1" ]; then
  echo "Enabling XDebug"
  docker-php-ext-enable xdebug
fi

if [ "$COMPOSER_INSTALL" = "1" ]; then
  if [ -f "composer.json" ]; then
    echo "Install Composer => composer install $COMPOSER_INSTALL_PARANS"
    sh -c "composer install $COMPOSER_INSTALL_PARANS"
  else
    echo "Não foi encontrado o composer.json"
  fi
fi

echo "Application Start!!!!"
exec php-fpm
