<?php

namespace App\Http\Controllers\Contact;

use App\Domain\Contact\Services\ContactService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactsRequest;
use App\Models\Contact;

class UpdateContactController extends Controller
{
    public function __construct(
        protected ContactService $service
    ) {}

    public function __invoke(ContactsRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $this->service->update($contact, $request->validated());

        return redirect()->route('contact.index')->with('success', 'Contact updated successfully!');
    }
}
