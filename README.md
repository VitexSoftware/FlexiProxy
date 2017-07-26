FlexiProxy
=======================================

![FlexiProxy Logo](https://github.com/VitexSoftware/FlexiProxy/blob/master/doc/flexiproxy-square-logo.png "Project Logo")

 * author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * copyright 2017 VitexSoftware (c)

Co aplikace umí
---------------

 * Proxy mezi FlexiBee a klientem
 * Měnit Logo
 * Přidává práci s obrázky v ceníku
 * Rozšíření pro vývojáře 

![Obrázky produktů](https://raw.githubusercontent.com/VitexSoftware/FlexiProxy/master/doc/new-attachment.png "Obrázek")


Co aplikace neumí
-----------------

 * Uvidíme

Instalace
---------


### Debian

Pro Debian či Ubuntu prosím použijte [repozitář](http://vitexsoftware.cz/repos.php) se závislostmi composer, EaseFramework a FlexiPeehp:

    wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key|sudo apt-key add -
    echo deb http://v.s.cz/ stable main > /etc/apt/sources.list.d/vitexsoftware.list
    apt update
    apt install flexiproxy

během instalace bude proveden dotaz na přihlašovací údaje do FlexiBee a umístění složky se vstupními soubory


### Git

Pro jiné systémy je třeba 

    git clone  https://github.com/VitexSoftware/FlexiProxy.git
    cd FlexyProxy
    composer install
        
a poté upravit __config.json__


Spouštění
---------

Spouštění se provádí skriptem src/doit.php nebo příkazem /usr/bin/flexiproxy z debianího balíčku


Konfigurace
-----------

Ten si načte obsah konfiguračního souboru config.json 

    {
        "EASE_APPNAM": "FlexiProxy",
        "EASE_LOGGER": "syslog|console",
        "EMAIL_FROM": "flexiproxy@localhost",
        "FLEXIBEE_URL": "https://localhost:5434",
        "FLEXIBEE_LOGIN": "admin",
        "FLEXIBEE_PASSWORD": "admin123",
        "FLEXIBEE_COMPANY": "spoje_net_s_r_o_4",
        "access_policy": "login",
        "debug": "true",
        "logo": "/images/yourlogo.png"
    }

  * access_policy: **public** - zpřístupní vše pod uživatelem z natavení; **login** - je nutné se přihlásit
  * debug: vypisuje dodatečné ladící ingormace (nepovinné)
  * logo:  jiný než výchozí obrázek pro modul logochanger (nepovinné)

Logování
--------

Se provádí do systémového logu. Ten pak vypadá zhruba takto:

    Nov  7 17:41:44 dellnik FlexiProxy:  `FlexiPeeHP\Adresar`   ❁ GET AddressBook item AT Computers a.s. as https://localhost:5434/c/firma_s_r_o_/adresar/641.json


Testování
---------

Skript obsahuje i PHPUnit testy

Vagrant
-------

pro vyzkoušení aplikace je třeba zadat  tyto příkazy

    sudo sed -i '/^127.0.0.1/ s/$/ flexiproxy.vagrant/' /etc/hosts
    sudo a2enmod proxy
    sudo ln -s `realpath testing/localapache.conf` /etc/apache2/sites-available/
    sudo a2ensite localapache
    sudo service apache2 restart
    vagrant up
    
Aplikace pak bude dostupná na adrese http://flexiproxy.vagrant/ 


Databaze
--------

    vendor/bin/phinx create CustomColumns -c phinx-adapter.php
    vendor/bin/phinx migrate -c phinx-adapter.php

Testing
-------

At first you need initialise create sql user & database with login and password 
from testing/phinx.yml and initialise testing database by **phinx migrate** 
command:

```
composer update
cd tests
mysqladmin -u root -p create flexiproxy
mysql -u root -p -e "GRANT ALL PRIVILEGES ON flexiproxy.* TO flexiproxy@localhost IDENTIFIED BY 'flexiproxy'"
sudo -u postgres bash -c "psql -c \"CREATE USER flexiproxy WITH PASSWORD 'flexiproxy';\""
sudo -u postgres bash -c "psql -c \"create database flexiproxy with owner flexiproxy encoding='utf8' template template0;\""
../vendor/bin/phinx migrate -e development 
../vendor/bin/phinx migrate -e testing  
```

Building
--------

Simply run debian/deb-package.sh

For Docker:

    docker build -t vitexus/flexiproxy .
    docker push vitexus/flexiproxy


Links
=====

Homepage: https://www.vitexsoftware.cz/flexiproxy.php

GitHub: https://github.com/VitexSoftware/FlexiProxy

