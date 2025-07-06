<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke()
    {
        $contacts = Contact::orderByDesc('is_favorite')
            ->orderBy('name')
            ->get();

        return Inertia::render('Home', [
            'contacts' => $contacts,
        ]);
    }
}
