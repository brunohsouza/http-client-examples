<?php

namespace App\Command;

use App\Service\RetryFailedExampleService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class HttpClientRetryFailedCommand extends Command
{
    protected static $defaultName = 'http-client:retry-failed';

    private RetryFailedExampleService $retryFailureExampleService;

    public function __construct(RetryFailedExampleService $retryFailedExampleService)
    {
        $this->retryFailureExampleService = $retryFailedExampleService;
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

        $io->info(json_encode($response));

        return Command::SUCCESS;
    }
}
