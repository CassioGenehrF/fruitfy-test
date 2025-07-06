<?php

namespace App\Http\Controllers\Contact;

use App\Exports\ContactsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportContactController extends Controller
{
    public function __invoke()
    {
        return Excel::download(new ContactsExport, "contacts.csv", null, [
            'Content-Type' => 'text/csv; charset=UTF-8'
        ]);
    }
}
