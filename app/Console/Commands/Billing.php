<?php

namespace App\Console\Commands;

use App\Billing\Customer;

use Illuminate\Console\Command;

class Billing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Line Interface for NorthWoods Customer Billing Gateway';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $customer = (new Customer);

        $card = $customer->setCreditCard([
            'card_number' => '4111111111111111',
            'exp_date'    => '2038-12'
        ]);

        $info = $customer->setBillingInfo([
            'first_name'  => 'John',
            'last_name'   => 'Doe',
            'email'       => 'digizn@io.com',
            'address'     => '185 Bear Mountain Drive',
            'city'        => 'Boulder',
            'state'       => 'CO',
            'zip'         => '80305',
            'country'     => 'United States',
        ]);

        $customer->save();

        dd($customer->charge('115'));

        dd($customer->get());
    }
}
