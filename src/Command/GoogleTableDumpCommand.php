<?php

namespace App\Command;

use App\ApiClient\GoogleClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class GoogleTableDumpCommand extends Command
{
    /**
     * @var ParameterBag
     */
    private $parameterBag;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ParameterBagInterface $parameterBag, EntityManagerInterface $entityManager, string $name = null)
    {
        parent::__construct($name);
        $this->parameterBag = $parameterBag;
        $this->em = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setName('app:google-api:dump-google-table')
            ->setDescription('Dumps data from Google Table to Sql-lite')
            ->addArgument('sheet_name', InputArgument::REQUIRED, 'Name of spreadsheet according to config')
            ->addArgument('column_ids', InputArgument::IS_ARRAY, 'Column ids to save in database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Start data dump');
        $sheetName = $input->getArgument('sheet_name');
        $columnIds = $input->getArgument('column_ids');

        $config = $this->parameterBag->get('app.google_sheet_config.'.$sheetName);
        $entityClass = $config['entity_class'];
        $spreadsheetId = $config['sheet_id'];
        $range = $config['range'];
        $columnPropRels = $config['column_prop_rel'];

        $client = GoogleClient::getClient();
        $service = new \Google_Service_Sheets($client);

        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        if (empty($values)) {
            print "No data found.\n";

            return self::SUCCESS;
        }

        $progressBar = new ProgressBar($output, count($values));
        $progressBar->setFormat('debug');
        $progressBar->start();

        foreach ($values as $row) {
            $columnsToSave = empty($columnIds) ? array_keys($columnPropRels) : $columnIds;

            $entity = new $entityClass();
            foreach ($columnsToSave as $columnId) {
                $propName = 'set'.ucfirst($columnPropRels[$columnId]);
                $propValue = $row[$columnId];
                $entity->$propName($propValue);
            }
            $this->em->persist($entity);
            $progressBar->advance();
        }

        $this->em->flush();
        $progressBar->finish();
        $output->write('', true);
        $output->writeln('Complete data dump');

        return self::SUCCESS;
    }
}
