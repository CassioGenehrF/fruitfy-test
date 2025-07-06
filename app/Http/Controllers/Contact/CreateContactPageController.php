<?php

namespace App\Http\Controllers\Contact;

use Inertia\Inertia;
use Inertia\Response;

class CreateContactPageController
{
    public function __invoke(): Response
    {
        return Inertia::render('Contacts/Create');
    }
}
