<?php

namespace App\Console\Commands;

use App\Mail\BirthdayReminder;
use App\Models\Contact;
use Illuminate\Console\Command;

class NotifyBirthdayContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:birthdays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Send birthday emails to today's contacts";

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $today = now()->format('m-d');


        $contacts = Contact::whereRaw("strftime('%m-%d', birthdate) = ?", [$today])->get();

        foreach ($contacts as $contact) {
            \Mail::to($contact->email)->send(new BirthdayReminder($contact));
            $this->info("Birthday email sent to {$contact->email}");
        }

        return Command::SUCCESS;
    }
}
