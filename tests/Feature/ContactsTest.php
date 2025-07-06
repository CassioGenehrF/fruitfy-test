<?php

namespace Tests\Feature;

use App\Mail\ContactDeleted;
use App\Mail\WelcomeContactMail;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class CreateContactsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_should_be_able_to_create_a_new_contact(): void
    {
        $data = [
            'name' => 'Rodolfo Meri',
            'email' => 'rodolfomeri@contato.com',
            'phone' => '(41) 98899-4422'
        ];

        $response = $this->post('/contacts', $data);

        $response->assertRedirect(route('contact.index'));
        $response->assertSessionHas('success', 'Contact created successfully!');

        $expected = $data;
        $expected['phone'] = preg_replace('/\D/', '', $expected['phone']);

        $this->assertDatabaseHas('contacts', $expected);
    }

    #[Test]
    public function it_should_validate_information(): void
    {
        $data = [
            'name' => 'ro',
            'email' => 'email-errado@',
            'phone' => '419'
        ];

        $response = $this->post('/contacts', $data);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'phone'
        ]);

        $this->assertDatabaseCount('contacts', 0);
    }

    #[Test]
    public function it_should_be_able_to_list_contacts_paginated_by_10_items_per_page(): void
    {
        Contact::factory(20)->create();

        $response = $this->get('/contacts');

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) =>
            $page->component('Contacts/Index')
                ->has('contacts.data', 10)
                ->has('contacts.links')
        );
    }

    #[Test]
    public function it_should_be_able_to_delete_a_contact(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->delete("/contacts/{$contact->id}");

        $response->assertRedirect(route('contact.index'));
        $response->assertSessionHas('success', 'Contact deleted successfully!');

        $this->assertDatabaseMissing('contacts', $contact->toArray());
    }

    #[Test]
    public function the_contact_email_should_be_unique(): void
    {
        $contact = Contact::factory()->create();

        $data = [
            'name' => 'Rodolfo Meri',
            'email' => $contact->email,
            'phone' => '(41) 98899-4422'
        ];

        $response = $this->post('/contacts', $data);

        $response->assertSessionHasErrors([
            'email'
        ]);

        $this->assertDatabaseCount('contacts', 1);
    }

    #[Test]
    public function it_should_be_able_to_update_a_contact(): void
    {
        $contact = Contact::factory()->create();

        $data = [
            'name' => 'Rodolfo Meri',
            'email' => 'emailatualizado@email.com',
            'phone' => '(41) 98899-4422'
        ];

        $response = $this->put("/contacts/{$contact->id}", $data);

        $response->assertRedirect(route('contact.index'));
        $response->assertSessionHas('success', 'Contact updated successfully!');

        $expected = $data;

        $expected['phone'] = preg_replace('/\D/', '', $expected['phone']);

        $this->assertDatabaseHas('contacts', $expected);

        $this->assertDatabaseMissing('contacts', $contact->toArray());
    }

    #[Test]
    public function it_should_send_an_email_when_contact_is_deleted(): void
    {
        Mail::fake();

        $contact = Contact::factory()->create();

        $response = $this->delete("/contacts/{$contact->id}");

        $response->assertRedirect(route('contact.index'));
        $response->assertSessionHas('success', 'Contact deleted successfully!');

        Mail::assertSent(ContactDeleted::class, function ($mail) use ($contact) {
            return $mail->hasTo($contact->email) &&
                $mail->contact->is($contact);
        });

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }

    #[Test]
    public function it_should_send_a_welcome_email_when_contact_is_created(): void
    {
        Mail::fake();

        $data = [
            'name' => 'Rodolfo Meri',
            'email' => 'rodolfomeri@contato.com',
            'phone' => '(41) 98899-4422'
        ];

        $this->post('/contacts', $data);

        Mail::assertSent(WelcomeContactMail::class, function ($mail) use ($data) {
            return $mail->hasTo($data['email']) && $mail->name === $data['name'];
        });
    }

    #[Test]
    public function it_should_export_contacts_as_csv(): void
    {
        Storage::fake('local');
        
        Contact::factory()->create([
            'name' => 'Rodolfo Meri',
            'email' => 'rodolfomeri@contato.com',
            'phone' => '(41) 98899-4422',
            'birthdate' => '1990-01-01',
        ]);


        \Maatwebsite\Excel\Facades\Excel::store(new \App\Exports\ContactsExport, 'contacts.csv', 'local');

        $csvContent = Storage::disk('local')->get('contacts.csv');
        $this->assertStringContainsString('Rodolfo Meri', $csvContent);
        $this->assertStringContainsString('rodolfomeri@contato.com', $csvContent);
        $this->assertStringContainsString('41988994422', $csvContent);
        $this->assertStringContainsString('1990-01-01', $csvContent);
    }

    #[Test]
    public function it_should_import_contacts_from_csv(): void
    {
        Storage::fake('local');

        $csvContent = <<<CSV
name,email,phone,birthdate
João Silva,joao@example.com,(11) 91234-5678,1990-01-01
Maria Oliveira,maria@example.com,(21) 99876-5432,1985-05-03
CSV;

        $file = UploadedFile::fake()->createWithContent('contacts.csv', $csvContent);

        $response = $this->post('/contacts/import', [
            'file' => $file,
        ]);

        $response->assertRedirect(route('contact.index'));
        $response->assertSessionHas('success', 'Contacts imported successfully!');

        $this->assertDatabaseHas('contacts', [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'phone' => '11912345678',
            'birthdate' => '1990-01-01'
        ]);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Maria Oliveira',
            'email' => 'maria@example.com',
            'phone' => '21998765432',
            'birthdate' => '1985-05-03'
        ]);
    }

    #[Test]
    public function it_should_list_favorite_contacts_first(): void
    {
        Contact::factory()->create([
            'name' => 'Favorite Contact',
            'email' => 'favorite@contact.com',
            'phone' => '11912345678',
            'birthdate' => '1990-01-01',
            'is_favorite' => true,
        ]);

        Contact::factory()->create([
            'name' => 'Regular Contact',
            'email' => 'regular@contact.com',
            'phone' => '21998765432',
            'birthdate' => '1985-05-03',
            'is_favorite' => false
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertInertia(fn (Assert $page) =>
            $page->component('Home')
                ->has('contacts', 2)
                ->where('contacts.0.name', 'Favorite Contact')
                ->where('contacts.1.name', 'Regular Contact')
        );
    }

    #[Test]
    public function it_should_toggle_favorite_status_of_a_contact(): void
    {
        $contact = Contact::factory()->create([
            'is_favorite' => false,
        ]);

        $response = $this->patch("/contacts/{$contact->id}/toggle-favorite");

        $response->assertRedirect(route('contact.index'));
        $response->assertSessionHas('success', 'Favorite status updated!');

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'is_favorite' => true,
        ]);

        $response = $this->patch("/contacts/{$contact->id}/toggle-favorite");

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'is_favorite' => false,
        ]);
    }
}
