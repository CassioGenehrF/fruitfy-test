<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Contact::all(['name', 'email', 'phone', 'birthdate']);
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
            'phone',
            'birthdate',
        ];
    }
}
