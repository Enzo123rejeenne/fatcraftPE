#!/bin/bash
#if [ ! -d "Hormones/" ]; then
#    git clone https://github.com/HoverEpic/Hormones.git
#fi
#
#../bin/php7/bin/php -dphar.readonly=0 ../cores/PocketMine-DevTools/src/DevTools/ConsoleScript.php \
#--make Hormones/Hormones/ \
#--out Hormones.phar

../bin/php7/bin/php -dphar.readonly=0 ../cores/PocketMine-DevTools/src/DevTools/ConsoleScript.php \
--make LoadBalancer/ \
--out LoadBalancer.phar

if [ ! -d "devirion/" ]; then
    git clone https://github.com/poggit/devirion.git
fi

../bin/php7/bin/php -dphar.readonly=0 ../cores/PocketMine-DevTools/src/DevTools/ConsoleScript.php \
--make devirion/ \
--out devirion.phar

if [ ! -d "SimpleAuth/" ]; then
    git clone https://github.com/HoverEpic/SimpleAuth.git
fi

../bin/php7/bin/php -dphar.readonly=0 ../cores/PocketMine-DevTools/src/DevTools/ConsoleScript.php \
--make SimpleAuth/ \
--out SimpleAuth.phar

if [ ! -d "EconomyS/" ]; then
    git clone https://github.com/HoverEpic/EconomyS.git
fi

../bin/php7/bin/php -dphar.readonly=0 ../cores/PocketMine-DevTools/src/DevTools/ConsoleScript.php \
--make EconomyS/EconomyAPI/ \
--out EconomyAPI.phar

if [ ! -d "StatsPE/" ]; then
    git clone https://github.com/HoverEpic/StatsPE.git
fi

../bin/php7/bin/php -dphar.readonly=0 ../cores/PocketMine-DevTools/src/DevTools/ConsoleScript.php \
--make StatsPE/ \
--out StatsPE.phar

../bin/php7/bin/php -dphar.readonly=0 ../cores/PocketMine-DevTools/src/DevTools/ConsoleScript.php \
--make Worlds/ \
--out Worlds.phar

if [ ! -d "Parkour/" ]; then
    git clone https://github.com/HoverEpic/Parkour.git
fi

../bin/php7/bin/php -dphar.readonly=0 ../cores/PocketMine-DevTools/src/DevTools/ConsoleScript.php \
--make Parkour/ \
--out Parkour.phar

if [ ! -d "HungerGames-UPDATED/" ]; then
    git clone https://github.com/HoverEpic/HungerGames-UPDATED.git
fi

../bin/php7/bin/php -dphar.readonly=0 ../cores/PocketMine-DevTools/src/DevTools/ConsoleScript.php \
--make HungerGames-UPDATED/HungerGames/ \
--out HungerGames.phar

