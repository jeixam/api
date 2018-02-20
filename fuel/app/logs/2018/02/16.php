<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

WARNING - 2018-02-16 17:04:45 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
ERROR - 2018-02-16 17:04:45 --> Error - syntax error, unexpected ',', expecting ']' in /var/www/html/api/fuel/app/classes/controller/canciones.php on line 103
WARNING - 2018-02-16 17:06:29 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
WARNING - 2018-02-16 17:07:51 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
WARNING - 2018-02-16 17:31:05 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
WARNING - 2018-02-16 17:34:19 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
ERROR - 2018-02-16 17:34:19 --> 1054 - SQLSTATE[42S22]: Column not found: 1054 Unknown column 't0_through.id_listas' in 'on clause' with query: "SELECT `t0`.`id` AS `t0_c0`, `t0`.`nombre` AS `t0_c1`, `t0`.`artista` AS `t0_c2`, `t0`.`url` AS `t0_c3` FROM `cancion` AS `t0` JOIN `tiene` AS `t0_through` ON (`t0_through`.`id_listas` = `t0`.`id`) WHERE `t0_through`.`id_cancion` = 3" in /var/www/html/api/fuel/core/classes/database/pdo/connection.php on line 253
