<?php

use App\Contract;
use App\ContractParticipant;
use App\Participant;
use App\Payment;
use App\Invoice;
use App\Legal;
use App\Individual;
use App\Client;

class ContractTest extends TestCase
{
    /**
     * Faker object
     *
     * @var App\Faker
     */
    protected static $faker;

    /**
     * Contract object
     *
     * @var App\Contract
     */
    protected static $contract;

    /**
     * Creates Contracts
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(self::$faker)) {
            self::$faker = Faker\Factory::create();
        }

        if (is_null(Contract::first())) {
            $this->create_unsigned_contract();
            $this->create_contracts_with_all_statuses();
            $this->create_contracts_for_one_legal_client();
        }
        self::$contract = Contract::first();
    }

    /**
     * Create Legal Client Contract With Unsigned Status, Participants, Payments And Invoices
     *
     * @return void
    */
    public function create_unsigned_contract()
    {
        $contract_id = factory(Contract::class, 'testing_unsigned_legal')->create([
            'value' => $value = self::$faker->numberBetween(5000, 100000),
            'start_date' => '',
            'end_date' => '',
            'participants' => $participants = rand(12, 20),
            'payments' =>  $payments = rand(0, 12),
            'client_id' => $client_id = factory(Legal::class, 'accept_meeting')->create()->client_id
        ])->id;
        for ($i = 1; $i <= $participants; $i++) {
            $participant_id = factory(Participant::class)->create()->id;
            factory(ContractParticipant::class)->create([
                'contract_id' => $contract_id,
                'participant_id' => $participant_id
            ]);
        }
        for ($i = 1; $i <= $payments; $i++) {
            $payment_id = factory(Payment::class)->create([
                'value_euro' => $value_euro = round($value/$payments),
                'pay_date' => date('Y-m-d', strtotime("+".$i." month")),
                'contract_id' => $contract_id
            ])->id;
            factory(Invoice::class)->create([
                'value_euro' =>  $value_euro,
                'paid_date' => date('Y-m-d', strtotime("+".$i." month")),
                'payment_id' => $payment_id,
                'contract_id' => $contract_id,
                'client_id' => $client_id
            ]);
        }
    }

    /**
     * Create Contracts With All Statuses (Unsigned, In Progress, Finished And Broken)
     *
     * @return void
     */
    public function create_contracts_with_all_statuses()
    {
        factory(Contract::class, 'unsigned_legal', 3)->create();
        factory(Contract::class, 'in_progress_legal', 3)->create();
        factory(Contract::class, 'finished_legal', 3)->create();
        factory(Contract::class, 'broken_legal', 3)->create();
    }

    /**
     * Create Contracts For One Legal Client
     *
     * @return void
     */
    public function create_contracts_for_one_legal_client()
    {
        $client_id = factory(Legal::class, 'active')->create()->client_id;
        factory(Contract::class, 'in_progress_legal', 2)->create(['client_id' => $client_id]);
        factory(Contract::class, 'finished_legal', 2)->create(['client_id' => $client_id]);
    }

    /**
     * Test If Contract Object Is An Instance of Contract Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_contract()
    {
        $this->assertInstanceOf('App\Contract', self::$contract);
    }


    /**
     * Test Contract Belgons To Client
     *
     * @test
     * @return void
    */
    public function contract_belongs_to_client()
    {
        $this->assertEquals(self::$contract->client->id, self::$contract->client_id);
    }

    /**
     * Test Contract Belgons To ContractStatus
     *
     * @test
     * @return void
    */
    public function contract_belongs_to_contract_status()
    {
        $this->assertEquals(self::$contract->contract_status->id, self::$contract->contract_status_id);
    }

    /**
     * Test Contract Belgons To Many Participants
     *
     * @test
     * @return void
    */
    public function contract_belongs_to_many_participants()
    {
        $this->assertEquals(self::$contract->participants, self::$contract->participant()->count());
    }

    /**
     * Test Paginate Participants Of The Contract
     *
     * @test
     * @return void
    */
    public function paginate_participants_of_the_contract()
    {
        $this->assertEquals(
            self::$contract->participant_paginate(self::$contract, $paginate = 10),
            self::$contract->participant()->paginate($paginate)
        );
    }

    /**
     * Test Contract Has Many Payments With Foreign Key Contract Id
     *
     * @test
     * @return void
     */
    public function contract_has_many_payments()
    {
        $this->assertEquals(self::$contract->payment(), self::$contract->hasMany('App\Payment', 'contract_id'));
    }

    /**
     * Test Paginate Payments Of The Contract
     *
     * @test
     * @return void
    */
    public function paginate_payments_of_the_contract()
    {
        $this->assertEquals(
            self::$contract->payment_paginate(self::$contract, $paginate = 10),
            self::$contract->payment()->paginate($paginate)
        );
    }

    /**
     * Test Contract Has Many Invoices With Foreign Key Contract Id
     *
     * @test
     * @return void
     */
    public function contract_has_many_invoices()
    {
        $this->assertEquals(self::$contract->invoice(), self::$contract->hasMany('App\Invoice', 'contract_id'));
    }

    /**
     * Test Contract Boot Creates Start Date Column As Null If Empty
     *
     * @test
     * @return void
     */
    public function contract_boot_create_start_date_null_if_empty()
    {
        $this->assertNull(self::$contract->start_date);
    }

    /**
     * Test Contract Boot Creates End Date Column As Null If Empty
     *
     * @test
     * @return void
     */
    public function contract_boot_create_end_date_null_if_empty()
    {
        $this->assertNull(self::$contract->end_date);
    }

    /**
     * Test Contract Boot Updates Start Date Column As Null If Empty
     *
     * @test
     * @return void
     */
    public function contract_boot_update_start_date_null_if_empty()
    {
        self::$contract->update(['start_date' => '']);
        $this->assertNull(self::$contract->start_date);
    }

    /**
     * Test Contract Boot Updates End Date Column As Null If Empty
     *
     * @test
     * @return void
     */
    public function contract_boot_update_end_date_null_if_empty()
    {
        self::$contract->update(['end_date' => '']);
        $this->assertNull(self::$contract->end_date);
    }

    /**
     * Test Count Unsigned Conctracts Returns Number of Contracts With Unsigned Status
     *
     * @test
     * @return void
     */
    public function count_unsigned_contracts_returns_number_of_unsigned_contracts()
    {
        $this->assertEquals(
            self::$contract->count_unsigned_contracts(),
            Contract::where('contract_status_id', 1)->count()
        );
    }

    /**
     * Test Get Unsigned Contracts Pagination Returns Unsigned Contracts By Pagination
     *
     * @test
     * @return void
    */
    public function get_unsigned_contracts_pagination_returns_unsigned_contracts_by_pagination()
    {
        $this->assertEquals(
            self::$contract->get_unsigned_contracts_pagination($paginate = 10),
            Contract::where('contract_status_id', 1)->paginate($paginate)
        );
    }

    /**
     * Test Count In Progress Conctracts Returns Number of Contracts With In Progress Status
     *
     * @test
     * @return void
     */
    public function count_in_progress_contracts_returns_number_of_in_progress_contracts()
    {
        $this->assertEquals(
            self::$contract->count_in_progress_contracts(),
            Contract::where('contract_status_id', 2)->count()
        );
    }

    /**
     * Test Get In Progress Contracts Pagination Returns In Progress Contracts By Pagination
     *
     * @test
     * @return void
    */
    public function get_in_progress_contracts_pagination_returns_in_progress_contracts_by_pagination()
    {
        $this->assertEquals(
            self::$contract->get_in_progress_contracts_pagination($paginate = 10),
            Contract::where('contract_status_id', 2)->paginate($paginate)
        );
    }

    /**
     * Test Count Finished Conctracts Returns Number of Contracts With Finished Status
     *
     * @test
     * @return void
     */
    public function count_finished_contracts_returns_number_of_finished_contracts()
    {
        $this->assertEquals(
            self::$contract->count_finished_contracts(),
            Contract::where('contract_status_id', 3)->count()
        );
    }

    /**
     * Test Get Finished Contracts Pagination Returns Finished Contracts By Pagination
     *
     * @test
     * @return void
    */
    public function get_finished_contracts_pagination_returns_finished_contracts_by_pagination()
    {
        $this->assertEquals(
            self::$contract->get_finished_contracts_pagination($paginate = 10),
            Contract::where('contract_status_id', 3)->paginate($paginate)
        );
    }

    /**
     * Test Count Broken Conctracts Returns Number of Contracts With Broken Status
     *
     * @test
     * @return void
     */
    public function count_broken_contracts_returns_number_of_broken_contracts()
    {
        $this->assertEquals(
            self::$contract->count_broken_contracts(),
            Contract::where('contract_status_id', 4)->count()
        );
    }

    /**
     * Test Get Broken Contracts Pagination Returns Broken Contracts By Pagination
     *
     * @test
     * @return void
    */
    public function get_broken_contracts_pagination_returns_broken_contracts_by_pagination()
    {
        $this->assertEquals(
            self::$contract->get_broken_contracts_pagination($paginate = 10),
            Contract::where('contract_status_id', 4)->paginate($paginate)
        );
    }

    /**
     * Test Get Last Contract Number Returns Last Contract Number
     *
     * @test
     * @return void
     */
    public function get_last_contract_number_last_contract_number()
    {
        $this->assertEquals(self::$contract->get_last_contract_number(), Contract::max('contract_number'));
    }

    /**
     * Test Count Clients With Contracts In Progress Status
     *
     * @test
     * @return void
     */
    public function count_clients_with_contracts_in_progress_status()
    {
        $this->assertEquals(
            self::$contract->count_clients_in_progress_contracts(self::$contract->client_id),
            Contract::where('client_id', self::$contract->client_id)->where('contract_status_id', 2)->count()
        );
    }

    /**
     * Test Count Clients With Contracts Other Than In Progress Status
     *
     * @test
     * @return void
     */
    public function count_clients_with_contracts_other_than_in_progress_status()
    {
        $this->assertEquals(
            self::$contract->count_clients_other_in_progress_contracts(self::$contract),
            Contract::where('client_id', self::$contract->client_id)
                    ->whereNotIn('contract_status_id', [self::$contract->id])
                    ->count()
        );
    }


    /**
     * Test Set Contract Status Updates Contracts Status With Passed Status Id
     *
     * @test
     * @return void
     */
    public function set_contract_status_updates_contract_status_with_passed_status_id()
    {
        $this->assertEquals(
            self::$contract->set_contract_status(self::$contract, $status_id = 2),
            self::$contract->update(['contract_status_id' => $status_id])
        );
    }

    /**
     * Test Update Contract Paid And Rest Updates Contracts Paid And Rest
     *
     * @test
     * @return void
     */
    public function update_contract_paid_and_rest_updates_contracts_paid_and_rest()
    {
        $paid = self::$contract->value_euro/4;
        $rest = self::$contract->value - $paid;
        $this->assertEquals(
            self::$contract->update_contract_paid_and_rest(self::$contract, $paid, $rest),
            self::$contract->update(['paid' => $paid, 'rest' => $rest])
        );
    }

   /**
     * Test Truncate Client, Individual, Legal, Inovice, Payment, Participant, Contract And ContractParticipant Table
     *
     * @test
     * @return void
    */
    public function truncate_all_tables_associated_with_contract_table()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ContractParticipant::truncate();
        Contract::truncate();
        Participant::truncate();
        Payment::truncate();
        Invoice::truncate();
        Legal::truncate();
        Individual::truncate();
        Client::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->assertNull(ContractParticipant::first());
        $this->assertNull(Contract::first());
        $this->assertNull(Participant::first());
        $this->assertNull(Payment::first());
        $this->assertNull(Invoice::first());
        $this->assertNull(Legal::first());
        $this->assertNull(Individual::first());
        $this->assertNull(Client::first());
    }
}
