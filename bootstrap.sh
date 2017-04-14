#!/usr/bin/env bash
wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key|sudo apt-key add -
echo deb http://v.s.cz/ stable main > /etc/apt/sources.list.d/vitexsoftware.list

export DEBIAN_FRONTEND="noninteractive"
apt-get update
apt-get install -y php7.0 php7.0-curl php-pear php7.0-intl composer unzip php7.0-zip devscripts
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
