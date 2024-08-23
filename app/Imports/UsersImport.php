<?php

namespace App\Imports;

use App\Models\MA;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name'     => $row['name'], // Assuming there is a 'name' column in Excel
            'email'    => $row['email'], // Assuming there is an 'email' column in Excel
            'faculty'  => $row['faculty'], // Assuming there is a 'faculty' column in Excel
            // Add other columns as needed
        ]);
    }
}
