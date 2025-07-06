<?php

namespace App\Http\Controllers\Contact;

use App\Domain\Contact\Services\ContactService;
use App\Http\Controllers\Controller;
use App\Models\Contact;

class ToggleContactController extends Controller
{
    public function __construct(
        protected ContactService $service
    ) {}

    public function __invoke($id)
    {
        $contact = Contact::findOrFail($id);

        $this->service->toggleFavorite($contact);

        return redirect()->route('contact.index')->with('success', 'Favorite status updated!');
    }
}
