<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/connect.php';

return ConsoleRunner::createHelperSet($entityManager);