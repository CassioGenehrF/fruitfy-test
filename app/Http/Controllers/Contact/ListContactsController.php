<?php

namespace App\Http\Controllers\Contact;

use App\Domain\Contact\Services\ContactService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListContactsController extends Controller
{
    public function __construct(
        protected ContactService $service
    ) {}

    public function __invoke(Request $request)
    {
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');

        $contacts = $this->service->paginate(10, $sort, $direction, $request->get('search'));

        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts,
            'filters' => [
                'search' => $request->get('search', ''),
                'sort' => $sort,
                'direction' => $direction,
            ],
        ]);
    }
}
