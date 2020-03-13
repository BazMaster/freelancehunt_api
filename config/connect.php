<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array(__DIR__ . "/../app/Models");
$isDevMode = true;

// the connection configuration
$dbParams = array(
	'driver'   => 'pdo_mysql',
	'charset'  => 'UTF8',
	'user'     => $db_user,
	'password' => '',
	'dbname'   => $db_name,
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);



//$projects = $entityManager
//	->getRepository('\App\Models\Project')
//	->findAll()
////	->find(1
//////				['id:>' => 1],
//////				['published_at' => 'DESC'],
//////				3,
//////				2
////	)
//;
