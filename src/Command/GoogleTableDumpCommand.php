<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GoogleTableDumpCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:google-api:dump-google-table')
            ->setDescription('Dumps data from Google Table to Sql-lite');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        dd(phpinfo());
    }
}
