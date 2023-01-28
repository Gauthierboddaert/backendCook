<?php

namespace App\Command;

use App\Entity\Ingredient;
use App\Service\ExporterCSV;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:import-ingredients')]
class ExportIngredientsFromCSV extends Command
{
    private ExporterCSV $exporterCSV;
    private EntityManagerInterface $entityManager;
    public function __construct(ExporterCSV $exporterCSV,EntityManagerInterface $entityManager, $name = null)
    {
        parent::__construct($name);
        $this->exporterCSV = $exporterCSV;
        $this->entityManager = $entityManager;
    }

    // the command description shown when running "php bin/console list"
    protected static $defaultDescription = 'Creates a new user.';

    // ...
    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to create a user...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = $this->exporterCSV->getDataFromFile();
        foreach ($data as $row){
            if(null !== $row[0])
            {
                $ingredient = new Ingredient();
                $ingredient->setName($row[0]);
                $this->entityManager->persist($ingredient);
            }
        }

        $this->entityManager->flush();
        //si data est nul error

        //boucle sur tab et stocket en db

        return Command::SUCCESS;
    }



}