<?php

declare(strict_types = 1);

namespace App;

use Dotenv\Dotenv;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use App\Services\AbstractApi\EmailValidationService;
use App\Exceptions\RouteNotFoundException;
use App\Contracts\EmailValidationInterface;
use Symfony\Component\Mailer\MailerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Services\Emailable;

class App
{
    private Config $config;

    public function __construct(
        protected Container $container,
        protected ?Router $router = null,
        protected array $request = [],
    ) {
    }

    public function initDb(array $config)
    {
        $capsule = new Capsule();

        $capsule->addConnection($config);
        $capsule->setEventDispatcher(new Dispatcher($this->container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->config = new Config($_ENV);

        $this->initDb($this->config->db);

        $this->container->bind(MailerInterface::class, fn() => new CustomMailer($this->config->mailer['dsn']));
        $this->container->bind(
            EmailValidationInterface::class,
            fn() => new Emailable\EmailValidationService($this->config->apiKeys['emailable'])
        );

        // $this->container->bind(EmailValidationInterface::class, fn() => new EmailValidationService($this->config->apiKeys['abstract_api_email_validation']));

        return $this;
    }

    public function run()
    {
        try {
            echo $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (RouteNotFoundException) {
            http_response_code(404);

            echo View::make('error/404');
        }
    }
}
