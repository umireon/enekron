#!/bin/sh

sudo apt-get install apache2 libapache2-mod-fastcgi

PHPDIR=$HOME/.phpenv/versions/`phpenv version-name`
echo "cgi.fix_pathinfo = 1" >> $PHPDIR/etc/php.ini
if [ -x $PHPDIR/sbin/php-fpm ]; then
	cp $PHPDIR/etc/php-fpm.conf.default $PHPDIR/etc/php-fpm.conf
	$PHPDIR/sbin/php-fpm
else
	$PHPDIR/bin/php-cgi -b 127.0.0.1:9000 &
fi

sudo a2enmod rewrite actions fastcgi alias
sudo cp -f .travis/apache-site.conf /etc/apache2/sites-available/default
sudo sed -e "s?%TRAVIS_BUILD_DIR%?$(pwd)?g" --in-place /etc/apache2/sites-available/default
sudo service apache2 restart

