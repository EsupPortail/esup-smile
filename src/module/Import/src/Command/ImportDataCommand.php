<?php

namespace Import\Command;


use Import\Service\Import\ImportService;
use Laminas\ServiceManager\ServiceManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use UnicaenSynchro\Service\Synchronisation\SynchronisationService;

class ImportDataCommand extends Command
{
    protected static $defaultName = 'app:import-data';

    private ServiceManager $serviceManager;

    public function __construct(ServiceManager $sm)
    {
        $this->serviceManager = $sm;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Import data from a source');
    }

    protected function getIO(InputInterface $input, OutputInterface $output): SymfonyStyle
    {
        return new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $io = $this->getIO($input, $output);
        $io->writeln('Importing data from a source');
        $sm = $this->serviceManager;
//        $synchroService = $sm->get(SynchronisationService::class);
//        $synchroService->synchronise('COMPOSANTES');

        $importService = $sm->get(ImportService::class);
        $importService->importODF();

        return Command::SUCCESS;
    }

}