<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    //
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'employee_name', 'address', 'employee_NIC','employee_contact_number'
    ];

}
