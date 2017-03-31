FlexiProxy
=======================================

 * author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * copyright 2017 VitexSoftware (c)

Co aplikace umí
---------------

 * Proxy mezi FlexiBee a klientem

Co aplikace neumí
-----------------

 * Všechon

Instalace
---------


### Debian

Pro Debian či Ubuntu prosím použijte [repozitář](http://vitexsoftware.cz/repos.php) se závislostmi composer, EaseFramework a FlexiPeehp:

    wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key|sudo apt-key add -
    echo deb http://v.s.cz/ stable main > /etc/apt/sources.list.d/vitexsoftware.list
    apt-get update
    gdebi flexiproxy_0.1-7_all.deb

během instalace bude proveden dotaz na přihlašovací údaje do FlexiBee a umístění složky se vstupními soubory


### Git

Pro jiné systémy je třeba 

    git clone  ssh://git@www.vitexsoftware.cz/vitex-software/flexiproxy/flexprox.git
    cd flexiprox
    composer install
        
a poté upravit __config.json__


Spouštění
---------

Spouštění se provádí skriptem src/doit.php nebo příkazem /usr/bin/flexiproxy z debianího balíčku


Konfigurace
-----------

Ten si načte obsah konfiguračního souboru config.json 

    {
        "FLEXIBEE_URL": "",
        "FLEXIBEE_LOGIN": "",
        "FLEXIBEE_PASSWORD": "",
        "FLEXIBEE_COMPANY": "",
        "EASE_APPNAM": "FlexiProxy",
        "EASE_LOGGER": "syslog|console",
        "EMAIL_FROM": "flexiproxy@localhost",
    }


Logování
--------

Se provádí do systémového logu. Ten pak vypadá zhruba takto:

    Nov  7 17:41:44 dellnik FlexiProxy:  `FlexiPeeHP\Adresar`   ❁ GET AddressBook item AT Computers a.s. as https://localhost:5434/c/firma_s_r_o_/adresar/641.json


Testování
---------

Skript obsahuje i PHPUnit testy


