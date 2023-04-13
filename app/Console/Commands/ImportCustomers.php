<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ImportCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Customer import';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get('https://randomuser.me/api/?nat=au&results=100');
        $customers = $response->json()['results'];

        foreach ($customers as $customer) {
            DB::table('customers')->updateOrInsert(
                ['email' => $customer['email']],
                [
                    'first_name'  => $customer['name']['first'],
                    'last_name'   => $customer['name']['last'],
                    'email'       => $customer['email'],
                    'password'    => md5($customer['login']['password']),
                    'gender'      => $customer['gender'],
                    'phone'       => $customer['phone'],
                    'nationality' => $customer['nat'],
                    'address'     => $customer['location']['street']['name'],
                    'city'        => $customer['location']['city'],
                    'country'     => $customer['location']['country'],
                ]
            );
        }

        $this->info('Imported ' . count($customers) . ' customers.');
    }
}
