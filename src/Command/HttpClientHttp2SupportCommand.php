<?php

namespace App\Command;

use App\Service\Http2SupportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpClientHttp2SupportCommand extends Command
{
    protected static $defaultName = 'http-client:http2-support';

    private Http2SupportService $http2Service;

    public function __construct(Http2SupportService $http2SupportService)
    {
        $this->http2Service = $http2SupportService;
        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this
            ->setDescription('Test the http2 support with libcurl or amphp libs')
            ->addArgument('lib', InputArgument::OPTIONAL, 'Inform the lib to test', 'libcurl')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $lib = $input->getArgument('lib');
        $response = [];

        $io->note(sprintf('You passed the argument: %s', $lib));

        if ($lib === 'amphp') {
            $io->note('Testing with amphp');
            $response = $this->http2Service->getAmpHttpClient();
        }

        if ('libcurl' === $lib || !$lib) {
            $io->note('Testing with libcurl');
            $response = $this->http2Service->getCurlHttpClient();
        }

        $io->info(json_encode($response));

        return Command::SUCCESS;
    }
}
