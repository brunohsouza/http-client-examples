<?php

namespace App\Command;

use App\Service\RetryFailureExampleService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class HttpClientRetryFailureCommand extends Command
{
    protected static $defaultName = 'http-client:retry-failure';

    private RetryFailureExampleService $retryFailureExampleService;

    public function __construct(RetryFailureExampleService $retryFailureExampleService)
    {
        $this->retryFailureExampleService = $retryFailureExampleService;
        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this->setDescription('Test the httpClient with retry failed requests');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->note('Testing a request with retry failed options.');

        $response = $this->retryFailureExampleService->executeRequest();

        $io->success((string) $response);

        return Command::SUCCESS;
    }
}
