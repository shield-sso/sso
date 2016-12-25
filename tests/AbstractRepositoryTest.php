<?php

declare(strict_types = 1);

namespace ShieldSSO\Test;

use Doctrine\ORM\EntityManagerInterface;
use ShieldSSO\Application;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Yaml\Yaml;
use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

abstract class AbstractRepositoryTest extends TestCase
{
    /** @var EntityManagerInterface */
    public static $entityManager;

    public static function setUpBeforeClass(): void
    {
        $app = new Application;

        $config = Yaml::parse(file_get_contents(__DIR__ . '/../resources/config/config.yml'));
        $app->register(new DoctrineServiceProvider, ['db.options' => ['url' => 'sqlite:///:memory:']]);
        $app->register(new DoctrineOrmServiceProvider, [
            'orm.proxies_dir' => __DIR__ . '/../' . $config['doctrine']['proxies_path'],
            'orm.em.options' => [
                'mappings' => [
                    [
                        'type' => $config['doctrine']['mapping']['type'],
                        'namespace' => $config['doctrine']['mapping']['namespace'],
                        'path' => __DIR__ . '/../' . $config['doctrine']['mapping']['path'],
                    ]
                ]
            ]
        ]);

        self::$entityManager = $app['orm.em'];

        $console = ConsoleRunner::createApplication(ConsoleRunner::createHelperSet(self::$entityManager));

        $commandName = 'orm:schema-tool:drop';
        $command = $console->find($commandName);
        $command->run(new ArrayInput(['command' => $commandName, '--force' => true]), new NullOutput);

        $commandName = 'orm:schema-tool:update';
        $command = $console->find($commandName);
        $command->run(new ArrayInput(['command' => $commandName, '--force' => true]), new NullOutput);
    }

    public function setUp(): void
    {
        self::$entityManager->clear();

        $purger = new ORMPurger;
        $executor = new ORMExecutor(self::$entityManager, $purger);
        $executor->execute([]);
    }

    public function tearDown(): void
    {
        $console = ConsoleRunner::createApplication(ConsoleRunner::createHelperSet(self::$entityManager));

        $commandName = 'orm:schema-tool:update';
        $command = $console->find($commandName);
        $command->run(new ArrayInput(['command' => $commandName, '--force' => true]), new NullOutput);
    }
}
