<?php

namespace App\Imports;

use App\Models\EmailQueue;
use Maatwebsite\Excel\Concerns\ToModel;

class ReminderImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new EmailQueue([
            //
        ]);
    }
}
