<?php

namespace App\Exports;
use App\Models\Employees\UsersModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection,WithHeadings
{
    protected $data;

    function __construct($data) {
        $this->data = $data;
    }
    public function headings(): array
    {
        return [
            'user id',
            'date',
            'log_in_time',
            'log_out_time',
            'ip_address_login',
            'Name',
            'Status',
        ];
    }
    public function collection()
    {
       // dd($this->data[0]);
        return $this->data;


    }
}
