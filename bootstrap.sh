#!/usr/bin/env bash
wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key|sudo apt-key add -
echo deb http://v.s.cz/ stable main > /etc/apt/sources.list.d/vitexsoftware.list

export DEBIAN_FRONTEND="noninteractive"
apt-get update
apt-get install -y php7.0 php7.0-curl php-pear php7.0-intl composer unzip php7.0-zip devscripts php7.0-xdebug
sed -i '/^error_reporting/c\error_reporting = E_ALL' /etc/php/7.0/apache2/php.ini
sed -i '/^display_errors/c\display_errors = On' /etc/php/7.0/apache2/php.ini
sed -i '/^display_startup_errors/c\display_startup_errors = On' /etc/php/7.0/apache2/php.ini
cd /vagrant
composer update
cd debian
./deb-package.sh
mkdir -p /vagrant/deb
mv /*.deb /vagrant/deb
cd /vagrant/deb
dpkg-scanpackages . /dev/null | gzip -9c > Packages.gz
echo "deb file:/vagrant/deb ./" > /etc/apt/sources.list.d/local.list
apt-get update
apt-get -y --allow-unauthenticated install flexiproxy flexiproxy-apache
