<?php

namespace App\Service;

use League\Csv\Reader;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExporterCSV
{
    private string $image_directory;
    public function __construct(string $image_directory)
    {
        $this->image_directory = $image_directory;
    }

    public function getDataFromFile() : array
    {

        $data = [];
        $csvFile = $this->image_directory . 'ingredients.xlsx';
        $spreadsheet = IOFactory::load($csvFile);
        $worksheet = $spreadsheet->getActiveSheet();

        foreach ($worksheet->getRowIterator() as $row) {
            $lineData = [];

            // Parcours des cellules de la ligne en cours
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);
            foreach ($cellIterator as $cell) {
                $lineData[] = $cell->getValue();
            }
            $data[] = $lineData;
        }
        array_shift($data);
        return $data;
    }


}