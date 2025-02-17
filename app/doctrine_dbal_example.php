<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

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

$queryBuilder = $entityManager->createQueryBuilder();
$query = $queryBuilder->select('i.createdAt', 'i.amount')
    ->from('App\Entity\Invoice', 'i')
    ->where('i.amount > :amount')
    ->setParameter('amount', 100)
    ->orderBy('i.createdAt', 'DESC')
    ->getQuery();

    echo $query->getDQL();

    $invoices = $query->getResult();
