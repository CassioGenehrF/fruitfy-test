<?php

namespace App\Http\Controllers\Contact;

use App\Domain\Contact\Services\ContactService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactsRequest;

class CreateContactController extends Controller
{
    public function __construct(
        protected ContactService $service
    ) {}

    public function __invoke(ContactsRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('contact.index')->with('success', 'Contact created successfully!');
    }
}
