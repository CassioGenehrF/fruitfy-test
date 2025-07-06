<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportContactsRequest;
use App\Imports\ContactsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportContactController extends Controller
{
    public function __invoke(ImportContactsRequest $request)
    {
        $file = $request->file('file');

        $headings = Excel::toArray([], $file)[0][0] ?? [];

        $expected = ['name', 'email', 'phone', 'birthdate'];

        if (array_diff($expected, $headings)) {
            return redirect()->route('contact.index')->with('error', 'Invalid CSV format. Headers must be: name, email, phone, birthdate.');
        }

        Excel::import(new ContactsImport, $file);

        return redirect()->route('contact.index')->with('success', 'Contacts imported successfully!');
    }
}
