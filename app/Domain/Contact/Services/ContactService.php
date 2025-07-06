<?php

namespace App\Domain\Contact\Services;

use App\Models\Contact;
use App\Mail\ContactDeleted;
use App\Mail\WelcomeContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactService
{
    public function create(array $data): Contact
    {
        $contact = Contact::create($data);
        Mail::to($contact->email)->send(new WelcomeContactMail($contact->name));

        return $contact;
    }

    public function update(Contact $contact, array $data): Contact
    {
        $contact->update($data);
        return $contact;
    }

    public function toggleFavorite(Contact $contact): Contact
    {
        $contact->is_favorite = !$contact->is_favorite;
        $contact->save();

        return $contact;
    }

    public function delete(Contact $contact): void
    {
        Mail::to($contact->email)->send(new ContactDeleted($contact));

        $contact->delete();
    }

    public function paginate($perPage = 10, $sort = 'name', $direction = 'asc', $search = null)
    {
        return Contact::when($search, function ($query, $search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%");
        })
            ->orderBy($sort, $direction)
            ->paginate($perPage)
            ->withQueryString();
    }
}
