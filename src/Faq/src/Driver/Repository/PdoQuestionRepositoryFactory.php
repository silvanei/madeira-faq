<?php

declare(strict_types=1);

namespace Faq\Driver\Repository;

use Faq\Repository\QuestionRepository;
use PDO;
use Psr\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;

class PdoQuestionRepositoryFactory
{
    public function __invoke(ContainerInterface $container): QuestionRepository
    {

        $config = $container->get('config');

        if (!isset($config['db'])) {
            throw new ServiceNotCreatedException('Adicionar a confiração co o banco de dados mysql.');
        }

        return new PdoQuestionRepository(
            new PDO(
                $config['db']['dsn'],
                $config['db']['username'],
                $config['db']['password'],
                $config['db']['driver_options']
            )
        );
    }
}
