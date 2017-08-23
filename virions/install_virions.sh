#!/bin/bash

if [ ! -d "libasynql/" ]; then
    https://github.com/poggit/libasynql.git
fi

if [ ! -d "spoondetector/" ]; then
    https://github.com/Falkirks/spoondetector.git
fi

if [ ! -e "virion.php" ]; then
    wget https://github.com/poggit/poggit/raw/beta/assets/php/virion.php
fi
if [ ! -e "virion_stub.php" ]; then
    wget https://github.com/poggit/poggit/raw/beta/assets/php/virion_stub.php
fi

cp virion.php libasynql/libasynql
cp virion_stub.php libasynql/libasynql

cp virion.php spoondetector
cp virion_stub.php spoondetector

../bin/php7/bin/php -dphar.readonly=0 ../cores/PocketMine-DevTools/src/DevTools/ConsoleScript.php \
--entry virion_stub.php \
--make libasynql/libasynql/ \
--stub '<?php require "phar://" . __FILE__ . "/virion_stub.php"; __HALT_COMPILER();' \
--out libasynql.phar

../bin/php7/bin/php -dphar.readonly=0 ../cores/PocketMine-DevTools/src/DevTools/ConsoleScript.php \
--entry virion_stub.php \
--make spoondetector/ \
--stub '<?php require "phar://" . __FILE__ . "/virion_stub.php"; __HALT_COMPILER();' \
--out spoondetector.phar