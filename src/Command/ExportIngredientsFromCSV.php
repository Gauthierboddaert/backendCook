<?php

namespace App\Command;

use App\Entity\Ingredient;
use App\Service\ExporterCSV;
use App\Service\IngredientManager;
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
    private IngredientManager $ingredientManager;
    public function __construct(ExporterCSV $exporterCSV,EntityManagerInterface $entityManager,IngredientManager $ingredientManager, $name = null)
    {
        parent::__construct($name);
        $this->exporterCSV = $exporterCSV;
        $this->entityManager = $entityManager;
        $this->ingredientManager = $ingredientManager;
    }

    // the command description shown when running "php bin/console list"
    protected static $defaultDescription = 'Import ingredients from XLSX file';

    // ...
    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to import data of ingredients')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = $this->exporterCSV->getDataFromFile();
        if($this->ingredientManager->addIngredientsFromXlsx($data))
        {
            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}