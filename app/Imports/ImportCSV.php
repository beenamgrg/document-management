<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportCSV implements ToCollection, WithHeadingRow
{
    protected $file_name;

    public function __construct($file_name)
    {
        $this->file_name = $file_name;
    }

    public function collection(Collection $rows)
    {
        //Read each row of data and convert it into proper json format 
        $data = [];
        foreach ($rows as $index => $row)
        {
            $rowNumber = $index + 1; // Row numbers are 1-based
            $entry = [];
            foreach ($row as $key => $value)
            {
                $entry[ucfirst($key)] = $value;
            }
            $data[(string) $rowNumber] = $entry;
        }

        file_put_contents(public_path("documents/{$this->file_name}.json"), json_encode($data, JSON_PRETTY_PRINT));
    }
}
