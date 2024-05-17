<?php

namespace App\Imports;

use App\Models\SaldoAwalModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class SaldoAwalImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    // public function collection(Collection $collection)
    // {
    //     //
    //     return new SaldoAwalModel([
    //         'column1' => $collection[0],
    //         'column2' => $collection[1],
    //     ]);
        
        
    // }
    public function model(array $row)
    {
        // Define how to create a model from the Excel row data
        return new SaldoAwalModel([
            'kode_brng' => $row[0],
            'nama_item' => $row[1],
            'qty' => str_replace([',', '.','-',' '],0, $row[2]),
            'harsat' =>str_replace([',', '.','-',' '],0, $row[3]),
            // 'nilai' => $row[4],
            'nilai' => str_replace([',', '.','-',' '],0, $row[4]),
            // Add more columns as needed
        ]);
    }
}
