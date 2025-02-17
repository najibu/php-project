<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = new PhpFile('migrations.php'); // Or use one of the Doctrine\Migrations\Configuration\Configuration\* loaders


$connectionParams = [
    'dbname' => $_ENV['DB_DATABASE'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'host' => $_ENV['DB_HOST'],
    'driver' => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
];

$entityManager = EntityManager::create(
    $connectionParams,
    Setup::createAnnotationMetadataConfiguration([__DIR__ . '/Entity'], true)
);

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
