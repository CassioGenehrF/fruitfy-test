<?php

namespace App\Http\Controllers\Contact;

use App\Models\Contact;
use Inertia\Inertia;
use Inertia\Response;

class UpdateContactPageController
{
    public function __invoke($id): Response
    {
        $contact = Contact::findOrFail($id);
        return Inertia::render('Contacts/Edit', ['contact' => $contact]);
    }
}
