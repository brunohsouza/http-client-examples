<?php

namespace App\Command;

use App\Service\ConcurrentRequestService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class HttpClientConcurrentRequestsCommand extends Command
{
    protected static $defaultName = 'http-client:concurrent-requests';

    private ConcurrentRequestService $httpClientExperimentsService;

    public function __construct(ConcurrentRequestService $httpClientExperimentsService)
    {
        $this->httpClientExperimentsService = $httpClientExperimentsService;
        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this->setDescription('Execute requests to measure the performance with concurrent requests');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->note('Executing request');
        $displayContent = $this->httpClientExperimentsService->executeConcurrentRequestsWithHttp2();

        $io->success($displayContent);

        return Command::SUCCESS;
    }
}
