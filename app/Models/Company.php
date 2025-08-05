<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = [
        'cif', 'name', 'address', 'city', 'legal_form', 'cnae', 'last_balance_date',
        'status', 'phone', 'website', 'email', 'ceo_name', 'ceo_position',
        'capital', 'sales', 'sales_year', 'employees', 'founded_at',
    ];
}
