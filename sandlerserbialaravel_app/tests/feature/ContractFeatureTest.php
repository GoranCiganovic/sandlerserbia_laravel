<?php

use App\Contract;
use App\ContractParticipant;
use App\Participant;
use App\Payment;
use App\Invoice;
use App\Legal;
use App\Individual;
use App\Client;
use App\Classes\Parse;

class ContractFeatureTest extends TestCase
{

    /**
     * Legal Client With Accept Meeting Client Status
     *
     * @var App\Legal
     */
    protected $accept_meeting_legal;

    /**
     * Individual Client With Accept Meeting Client Status
     *
     * @var App\Individual
     */
    protected $accept_meeting_individual;

    /**
     * Contracts With Status Unsigned
     *
     * @var App\Contract
     */
    protected $unsigned_contracts;

    /**
     * Legal Contract With Status Unsigned
     *
     * @var App\Contract
     */
    protected $unsigned_legal_contract;

    /**
     * Individual Contract With Status Unsigned
     *
     * @var App\Contract
     */
    protected $unsigned_individual_contract;

    /**
     * Contracts With Status In Progress
     *
     * @var App\Contract
     */
    protected $in_progress_contracts;

    /**
     * Legal Contract With Status In Progress
     *
     * @var App\Contract
     */
    protected $in_progress_legal_contract;

    /**
     * Individual Contract With Status In Progress
     *
     * @var App\Contract
     */
    protected $in_progress_individual_contract;

    /**
     * Contracts With Status Finished
     *
     * @var App\Contract
     */
    protected $finished_contracts;

    /**
     * Legal Contract With Status Finished
     *
     * @var App\Contract
     */
    protected $finished_legal_contract;

    /**
     * Individual Contract With Status Finished
     *
     * @var App\Contract
     */
    protected $finished_individual_contract;

    /**
     * Contracts With Status Broken
     *
     * @var App\Contract
     */
    protected $broken_contracts;

    /**
     * Legal Contract With Status Broken
     *
     * @var App\Contract
     */
    protected $broken_legal_contract;

    /**
     * Individual Contract With Status Broken
     *
     * @var App\Contract
     */
    protected $broken_individual_contract;

    /**
     * Faker
     *
     * @var Faker\Factory
     */
    protected $faker;

    /**
     * Creates Contract
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(Contract::first())) {
            factory(Contract::class, 'unsigned_legal', 3)->create();
            factory(Contract::class, 'unsigned_individual', 3)->create();
            factory(Contract::class, 'in_progress_legal')->create();
            factory(Contract::class, 'in_progress_individual')->create();
            factory(Contract::class, 'finished_legal')->create();
            factory(Contract::class, 'finished_individual')->create();
            factory(Contract::class, 'broken_legal')->create();
            factory(Contract::class, 'broken_individual')->create();
        }
        
        if (is_null($this->accept_meeting_legal)) {
            $this->accept_meeting_legal = Legal::where('client_status_id', 3)->first();
        }

        if (is_null($this->accept_meeting_individual)) {
            $this->accept_meeting_individual = Individual::where('client_status_id', 3)->first();
        }

        if (is_null($this->unsigned_contracts)) {
            $this->unsigned_contracts = Contract::where('contract_status_id', 1)->get();
        }
        if (is_null($this->unsigned_legal_contract)) {
            $this->unsigned_legal_contract = Contract::where('contract_status_id', 1)
                                                    ->where('legal_status_id', 1)->first();
        }
        if (is_null($this->unsigned_individual_contract)) {
            $this->unsigned_individual_contract = Contract::where('contract_status_id', 1)
                                                    ->where('legal_status_id', 2)->first();
        }

        if (is_null($this->in_progress_contracts)) {
            $this->in_progress_contracts = Contract::where('contract_status_id', 2)->get();
        }
        if (is_null($this->in_progress_legal_contract)) {
            $this->in_progress_legal_contract = Contract::where('contract_status_id', 2)
                                                    ->where('legal_status_id', 1)->first();
        }
        if (is_null($this->in_progress_individual_contract)) {
            $this->in_progress_individual_contract = Contract::where('contract_status_id', 2)
                                                    ->where('legal_status_id', 2)->first();
        }

        if (is_null($this->finished_contracts)) {
            $this->finished_contracts = Contract::where('contract_status_id', 3)->get();
        }
        if (is_null($this->finished_legal_contract)) {
            $this->finished_legal_contract = Contract::where('contract_status_id', 3)
                                                    ->where('legal_status_id', 1)->first();
        }
        if (is_null($this->finished_individual_contract)) {
            $this->finished_individual_contract = Contract::where('contract_status_id', 3)
                                                    ->where('legal_status_id', 2)->first();
        }

        if (is_null($this->broken_contracts)) {
            $this->broken_contracts = Contract::where('contract_status_id', 4)->get();
        }
        if (is_null($this->broken_legal_contract)) {
            $this->broken_legal_contract = Contract::where('contract_status_id', 4)
                                                    ->where('legal_status_id', 1)->first();
        }
        if (is_null($this->broken_individual_contract)) {
            $this->broken_individual_contract = Contract::where('contract_status_id', 4)
                                                    ->where('legal_status_id', 2)->first();
        }

        if (is_null($this->faker)) {
            $this->faker = Faker\Factory::create();
        }
    }

    /**
     * Test Admin Can See Unsigned Contracts In Home Page With Ajax (ContractsController@unsigned)
     *
     * @test
     * @return void
    */
    public function admin_can_see_unsigned_contracts_in_home_page_ajax()
    {
        $this->actingAs(self::$admin)
            ->call('GET', '/contracts/unsigned', [], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        foreach ($this->unsigned_contracts as $contract) {
            $this->see('/contract/' . $contract->id)
                ->see('Ugovor broj ' . $contract->contract_number . ' od ' . date("d.m.Y.", strtotime($contract->contract_date)) . ' godine.');
        }
    }

    /**
     * Test User Can See Unsigned Contracts In Home Page With Ajax (ContractsController@unsigned)
     *
     * @test
     * @return void
    */
    public function user_can_see_unsigned_contracts_in_home_page_ajax()
    {
        $this->actingAs(self::$user)
            ->call('GET', '/contracts/unsigned', [], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        foreach ($this->unsigned_contracts as $contract) {
            $this->see('/contract/' . $contract->id)
                ->see('Ugovor broj ' . $contract->contract_number . ' od ' . date("d.m.Y.", strtotime($contract->contract_date)) . ' godine.');
        }
    }

    /**
     * Test Admin Can See In Progress Contracts In Home Page With Ajax (ContractsController@in_progress)
     *
     * @test
     * @return void
    */
    public function admin_can_see_in_progress_contracts_in_home_page_ajax()
    {
        $this->actingAs(self::$admin)
            ->call('GET', '/contracts/in_progress', [], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        foreach ($this->in_progress_contracts as $contract) {
            $this->see('/contract/' . $contract->id)
                ->see('Ugovor broj ' . $contract->contract_number . ' od ' . date("d.m.Y.", strtotime($contract->contract_date)) . ' godine.');
        }
    }

    /**
     * Test User Can See In Progress Contracts In Home Page With Ajax (ContractsController@in_progress)
     *
     * @test
     * @return void
    */
    public function user_can_see_in_progress_contracts_in_home_page_ajax()
    {
        $this->actingAs(self::$user)
            ->call('GET', '/contracts/in_progress', [], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        foreach ($this->in_progress_contracts as $contract) {
            $this->see('/contract/' . $contract->id)
                ->see('Ugovor broj ' . $contract->contract_number . ' od ' . date("d.m.Y.", strtotime($contract->contract_date)) . ' godine.');
        }
    }

    /**
     * Test Admin Can See Finished Contracts In Home Page With Ajax (ContractsController@finished)
     *
     * @test
     * @return void
    */
    public function admin_can_see_finished_contracts_in_home_page_ajax()
    {
        $this->actingAs(self::$admin)
            ->call('GET', '/contracts/finished', [], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        foreach ($this->finished_contracts as $contract) {
            $this->see('/contract/' . $contract->id)
                ->see('Ugovor broj ' . $contract->contract_number . ' od ' . date("d.m.Y.", strtotime($contract->contract_date)) . ' godine.');
        }
    }

    /**
     * Test User Can See Finished Contracts In Home Page With Ajax (ContractsController@finished)
     *
     * @test
     * @return void
    */
    public function user_can_see_finished_contracts_in_home_page_ajax()
    {
        $this->actingAs(self::$user)
            ->call('GET', '/contracts/finished', [], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        foreach ($this->finished_contracts as $contract) {
            $this->see('/contract/' . $contract->id)
                ->see('Ugovor broj ' . $contract->contract_number . ' od ' . date("d.m.Y.", strtotime($contract->contract_date)) . ' godine.');
        }
    }

    /**
     * Test Admin Can See Broken Contracts In Home Page With Ajax (ContractsController@broken)
     *
     * @test
     * @return void
    */
    public function admin_can_see_broken_contracts_in_home_page_ajax()
    {
        $this->actingAs(self::$admin)
            ->call('GET', '/contracts/broken', [], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        foreach ($this->broken_contracts as $contract) {
            $this->see('/contract/' . $contract->id)
                ->see('Ugovor broj ' . $contract->contract_number . ' od ' . date("d.m.Y.", strtotime($contract->contract_date)) . ' godine.');
        }
    }

    /**
     * Test User Can See Broken Contracts In Home Page With Ajax (ContractsController@broken)
     *
     * @test
     * @return void
    */
    public function user_can_see_broken_contracts_in_home_page_ajax()
    {
        $this->actingAs(self::$user)
            ->call('GET', '/contracts/broken', [], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        foreach ($this->broken_contracts as $contract) {
            $this->see('/contract/' . $contract->id)
                ->see('Ugovor broj ' . $contract->contract_number . ' od ' . date("d.m.Y.", strtotime($contract->contract_date)) . ' godine.');
        }
    }

    /**
     * Test Admin Can See The Form For Creating New Legal Contract (ContractsController@create)
     *
     * @test
     * @return void
     */
    public function admin_can_see_the_form_for_creating_new_legal_contract()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->accept_meeting_legal->client_id)
            ->see('Ugovori')
            ->click('NOVI UGOVOR')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->assertViewHas(['client', 'current_time'])
            ->see('NOVI UGOVOR')
            ->see('POTVRDI');
    }

    /**
     * Test Admin Can See The Form For Creating New Inidividual Contract (ContractsController@create)
     *
     * @test
     * @return void
     */
    public function admin_can_see_the_form_for_creating_new_individual_contract()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->accept_meeting_individual->client_id)
            ->see('Ugovori')
            ->click('NOVI UGOVOR')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->assertViewHas(['client', 'current_time'])
            ->see('NOVI UGOVOR')
            ->see('POTVRDI');
    }

    /**
     * Test User Can See The Form For Creating New Legal Contract (ContractsController@create)
     *
     * @test
     * @return void
     */
    public function user_can_see_the_form_for_creating_new_legal_contract()
    {
        $this->actingAs(self::$user)
            ->visit('/client/' . $this->accept_meeting_legal->client_id)
            ->see('Ugovori')
            ->click('NOVI UGOVOR')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->assertViewHas(['client', 'current_time'])
            ->see('NOVI UGOVOR')
            ->see('POTVRDI');
    }

    /**
     * Test User Can See The Form For Creating New Individual Contract (ContractsController@create)
     *
     * @test
     * @return void
     */
    public function user_can_see_the_form_for_creating_new_individual_contract()
    {
        $this->actingAs(self::$user)
            ->visit('/client/' . $this->accept_meeting_individual->client_id)
            ->see('Ugovori')
            ->click('NOVI UGOVOR')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->assertViewHas(['client', 'current_time'])
            ->see('NOVI UGOVOR')
            ->see('POTVRDI');
    }

    /**
     * Test Admin Can Return From Page For Creating New Legal Contract To Client Profile Page (ClientsController@create)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_page_for_creating_new_legal_contract_to_client_profile_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->see('Novi Ugovor')
            ->click('#back_to_profile')
            ->seePageIs('/client/' . $this->accept_meeting_legal->client_id)
            ->see($this->accept_meeting_legal->long_name);
    }

    /**
     * Test Admin Can Return From Page For Creating New Individual Contract To Client Profile Page (ClientsController@create)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_page_for_creating_new_individual_contract_to_client_profile_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->see('Novi Ugovor')
            ->click('#back_to_profile')
            ->seePageIs('/client/' . $this->accept_meeting_individual->client_id)
            ->see($this->accept_meeting_individual->first_name . ' ' . $this->accept_meeting_individual->last_name);
    }

    /**
     * Test User Can Return From Page For Creating New Legal Contract To Client Profile Page (ClientsController@create)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_page_for_creating_new_legal_contract_to_client_profile_page()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->see('Novi Ugovor')
            ->click('#back_to_profile')
            ->seePageIs('/client/' . $this->accept_meeting_legal->client_id)
            ->see($this->accept_meeting_legal->long_name);
    }

    /**
     * Test User Can Return From Page For Creating New Individual Contract To Client Profile Page (ClientsController@create)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_page_for_creating_new_individual_contract_to_client_profile_page()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->see('Novi Ugovor')
            ->click('#back_to_profile')
            ->seePageIs('/client/' . $this->accept_meeting_individual->client_id)
            ->see($this->accept_meeting_individual->first_name . ' ' . $this->accept_meeting_individual->last_name);
    }

    /**
     * Test Admin Can Store New Legal Contract (ContractsController@store)
     *
     * @test
     * @return void
     */
    public function admin_can_store_new_legal_contract()
    {
        $next_contract_id = Contract::max('id') + 1;
        $next_contract_number = Contract::max('contract_number') + 1;
        $all_participants = Participant::count();
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type($value = $this->faker->numberBetween(20000, 50000), 'value')
            ->type($this->faker->text(30), 'value_letters')
            ->type($advance = rand(0, $value/10), 'advance')
            ->type($payments = rand(1, 12), 'payments')
            ->type($participants = rand(1, 10), 'participants')
            ->type($now = date('d.m.Y.'), 'format_contract_date')
            ->type(date('Y-m-d', strtotime($now)), 'contract_date')
            ->type($start = date('d.m.Y.', strtotime("+3 days")), 'format_start_date')
            ->type(date('Y-m-d', strtotime($start)), 'start_date')
            ->type($end = date('d.m.Y.', strtotime("+30 days")), 'format_end_date')
            ->type(date('Y-m-d', strtotime($end)), 'end_date')
            ->type($this->faker->text(50), 'event_place')
            ->type($this->faker->text(50), 'classes_number')
            ->type($this->faker->text(100), 'work_dynamics')
            ->type($this->faker->text(100), 'event_time')
            ->type($this->faker->text(1000), 'description')
            ->press('POTVRDI')
            ->seeInDatabase('contracts', ['id' => $next_contract_id, 'value' => $value])
            ->seePageIs("/client/" . $this->accept_meeting_legal->client_id)
            ->see('Ugovor broj ' . $next_contract_number . ' je uspešno kreiran.')
            ->see('NEPOTPISAN BR. ' . $next_contract_number . ' od ' . $now);

        $advance_payment = $advance ? 1 : 0;

        $this->assertEquals(
            $advance_payment,
            Payment::where('contract_id', $next_contract_id)->where('is_advance', 1)->count()
        );

        $this->assertEquals(
            $payments + $advance_payment,
            Payment::where('contract_id', $next_contract_id)->count()
        );

        $this->assertEquals(
            $value,
            Payment::where('contract_id', $next_contract_id)->sum('value_euro')
        );

        $this->assertEquals(
            $participants,
            ContractParticipant::where('contract_id', $next_contract_id)->count()
        );
        $this->assertEquals(
            $all_participants + $participants,
            Participant::count()
        );
    }

    /**
     * Test Admin Can Store New Individual Contract (ContractsController@store)
     *
     * @test
     * @return void
     */
    public function admin_can_store_new_individual_contract()
    {
        $next_contract_id = Contract::max('id') + 1;
        $next_contract_number = Contract::max('contract_number') + 1;
        $all_participants = Participant::count();
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type($value = $this->faker->numberBetween(20000, 50000), 'value')
            ->type($this->faker->text(30), 'value_letters')
            ->type($advance = rand(0, $value/10), 'advance')
            ->type($payments = rand(1, 12), 'payments')
            ->type($participants = rand(1, 10), 'participants')
            ->type($now = date('d.m.Y.'), 'format_contract_date')
            ->type(date('Y-m-d', strtotime($now)), 'contract_date')
            ->type($start = date('d.m.Y.', strtotime("+3 days")), 'format_start_date')
            ->type(date('Y-m-d', strtotime($start)), 'start_date')
            ->type($end = date('d.m.Y.', strtotime("+30 days")), 'format_end_date')
            ->type(date('Y-m-d', strtotime($end)), 'end_date')
            ->type($this->faker->text(50), 'event_place')
            ->type($this->faker->text(50), 'classes_number')
            ->type($this->faker->text(100), 'work_dynamics')
            ->type($this->faker->text(100), 'event_time')
            ->type($this->faker->text(1000), 'description')
            ->press('POTVRDI')
            ->seeInDatabase('contracts', ['id' => $next_contract_id, 'value' => $value])
            ->seePageIs("/client/" . $this->accept_meeting_individual->client_id)
            ->see('Ugovor broj ' . $next_contract_number . ' je uspešno kreiran.')
            ->see('NEDOGOVOREN BR. ' . $next_contract_number . ' od ' . $now);

        $advance_payment = $advance ? 1 : 0;

        $this->assertEquals(
            $advance_payment,
            Payment::where('contract_id', $next_contract_id)->where('is_advance', 1)->count()
        );

        $this->assertEquals(
            $payments + $advance_payment,
            Payment::where('contract_id', $next_contract_id)->count()
        );

        $this->assertEquals(
            $value,
            Payment::where('contract_id', $next_contract_id)->sum('value_euro')
        );

        $this->assertEquals(
            $participants,
            ContractParticipant::where('contract_id', $next_contract_id)->count()
        );
        $this->assertEquals(
            $all_participants + $participants,
            Participant::count()
        );
    }

    /**
     * Test User Can Not Store New Legal Contract (ContractsController@store)
     *
     * @test
     * @return void
     */
    public function user_can_not_store_new_legal_contract()
    {
        $next_contract_id = Contract::max('id') + 1;
        $next_contract_number = Contract::max('contract_number') + 1;
        $all_participants = Participant::count();
        $this->actingAs(self::$user)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type($value = $this->faker->numberBetween(20000, 50000), 'value')
            ->type($this->faker->text(30), 'value_letters')
            ->type($advance = rand(1000, $value/10), 'advance')
            ->type($payments = rand(1, 12), 'payments')
            ->type($participants = rand(1, 10), 'participants')
            ->type($now = date('d.m.Y.'), 'format_contract_date')
            ->type(date('Y-m-d', strtotime($now)), 'contract_date')
            ->type($start = date('d.m.Y.', strtotime("+3 days")), 'format_start_date')
            ->type(date('Y-m-d', strtotime($start)), 'start_date')
            ->type($end = date('d.m.Y.', strtotime("+30 days")), 'format_end_date')
            ->type(date('Y-m-d', strtotime($end)), 'end_date')
            ->type($this->faker->text(50), 'event_place')
            ->type($this->faker->text(50), 'classes_number')
            ->type($this->faker->text(100), 'work_dynamics')
            ->type($this->faker->text(100), 'event_time')
            ->type($this->faker->text(1000), 'description')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->dontSee('Ugovor broj ' . $next_contract_number . ' je uspešno kreiran.')
            ->dontSeeInDatabase('contracts', ['id' => $next_contract_id, 'value' => $value])
            ->dontSeeInDatabase('contract_participants', ['contract_id' => $next_contract_id])
            ->dontSeeInDatabase('payments', ['contract_id' => $next_contract_id])
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test User Can Not Store New Individual Contract (ContractsController@store)
     *
     * @test
     * @return void
     */
    public function user_can_not_store_new_individual_contract()
    {
        $next_contract_id = Contract::max('id') + 1;
        $next_contract_number = Contract::max('contract_number') + 1;
        $all_participants = Participant::count();
        $this->actingAs(self::$user)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type($value = $this->faker->numberBetween(20000, 50000), 'value')
            ->type($this->faker->text(30), 'value_letters')
            ->type($advance = rand(1000, $value/10), 'advance')
            ->type($payments = rand(1, 12), 'payments')
            ->type($participants = rand(1, 10), 'participants')
            ->type($now = date('d.m.Y.'), 'format_contract_date')
            ->type(date('Y-m-d', strtotime($now)), 'contract_date')
            ->type($start = date('d.m.Y.', strtotime("+3 days")), 'format_start_date')
            ->type(date('Y-m-d', strtotime($start)), 'start_date')
            ->type($end = date('d.m.Y.', strtotime("+30 days")), 'format_end_date')
            ->type(date('Y-m-d', strtotime($end)), 'end_date')
            ->type($this->faker->text(50), 'event_place')
            ->type($this->faker->text(50), 'classes_number')
            ->type($this->faker->text(100), 'work_dynamics')
            ->type($this->faker->text(100), 'event_time')
            ->type($this->faker->text(1000), 'description')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->dontSee('Ugovor broj ' . $next_contract_number . ' je uspešno kreiran.')
            ->dontSeeInDatabase('contracts', ['id' => $next_contract_id, 'value' => $value])
            ->dontSeeInDatabase('contract_participants', ['contract_id' => $next_contract_id])
            ->dontSeeInDatabase('payments', ['contract_id' => $next_contract_id])
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test False Store Contract With Get Method (ContractsController@store)
     *
     * @test
     * @return void
     */
    public function false_store_contract_with_get_method()
    {
        $this->actingAs(self::$admin)
        ->get('/contract/store/' . Client::first()->id, [
            'value' => $value = $this->faker->numberBetween(20000, 50000),
            'value_letters' => $this->faker->text(30),
            'advance' => $advance = rand(1000, $value/10),
            'payments' => $payments = rand(1, 12),
            'participants' => $participants = rand(1, 10),
            'format_contract_date' => $now = date('d.m.Y.'),
            'contract_date' => date('Y-m-d', strtotime($now)),
            'format_start_date' => $start = date('d.m.Y.', strtotime("+3 days")),
            'start_date' => date('Y-m-d', strtotime($start)),
            'format_end_date' => $end = date('d.m.Y.', strtotime("+30 days")),
            'end_date' => date('Y-m-d', strtotime($end)),
            'event_place' => $this->faker->text(50),
            'classes_number' => $this->faker->text(50),
            'work_dynamics' => $this->faker->text(100),
            'event_time' => $this->faker->text(100),
            'description' => $this->faker->text(1000)
            ])
        ->assertResponseStatus(405)
        ->see('405 Something Went Wrong');
    }

    /**
     * Test Admin Can See Created Legal Contract (ContractsController@show)
     *
     * @test
     * @return void
     */
    public function admin_can_see_created_legal_contract()
    {
        $contract = Contract::where('client_id', $this->accept_meeting_legal->client_id)->first();
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->accept_meeting_legal->client_id)
            ->click(mb_strtoupper($contract->contract_status->name) . ' BR. '. $contract->contract_number . ' od ' . date("d.m.Y.", strtotime($contract->contract_date)))
            ->seePageIs('/contract/' . $contract->id)
            ->assertViewHas(['contract', 'client', 'contract_status'])
            ->see('UGOVOR br.' . $contract->contract_number);
    }

    /**
     * Test Admin Can See Created Individual Contract (ContractsController@show)
     *
     * @test
     * @return void
     */
    public function admin_can_see_created_individual_contract()
    {
        $contract = Contract::where('client_id', $this->accept_meeting_individual->client_id)->first();
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->accept_meeting_individual->client_id)
            ->click('NEDOGOVOREN BR. '. $contract->contract_number . ' od ' . date("d.m.Y.", strtotime($contract->contract_date)))
            ->seePageIs('/contract/' . $contract->id)
            ->assertViewHas(['contract', 'client', 'contract_status'])
            ->see('UGOVOR br.' . $contract->contract_number);
    }

    /**
     * Test User Can See Created Legal Contract (ContractsController@show)
     *
     * @test
     * @return void
     */
    public function user_can_see_created_legal_contract()
    {
        $contract = Contract::where('client_id', $this->accept_meeting_legal->client_id)->first();
        $this->actingAs(self::$user)
            ->visit('/client/' . $this->accept_meeting_legal->client_id)
            ->click(mb_strtoupper($contract->contract_status->name) . ' BR. '. $contract->contract_number . ' od ' . date("d.m.Y.", strtotime($contract->contract_date)))
            ->seePageIs('/contract/' . $contract->id)
            ->assertViewHas(['contract', 'client', 'contract_status'])
            ->see('UGOVOR br.' . $contract->contract_number);
    }

    /**
     * Test User Can See Created Individual Contract (ContractsController@show)
     *
     * @test
     * @return void
     */
    public function user_can_see_created_individual_contract()
    {
        $contract = Contract::where('client_id', $this->accept_meeting_individual->client_id)->first();
        $this->actingAs(self::$user)
            ->visit('/client/' . $this->accept_meeting_individual->client_id)
            ->click('NEDOGOVOREN BR. '. $contract->contract_number . ' od ' . date("d.m.Y.", strtotime($contract->contract_date)))
            ->seePageIs('/contract/' . $contract->id)
            ->assertViewHas(['contract', 'client', 'contract_status'])
            ->see('UGOVOR br.' . $contract->contract_number);
    }

    /**
     * Test Admin Can See Form For Editing Unsigned Legal Contract (ContractsController@edit)
     *
     * @test
     * @return void
     */
    public function admin_can_see_form_for_editing_unsigned_legal_contract()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/' .  $this->unsigned_legal_contract->id)
            ->click('IZMENI UGOVOR')
            ->seePageIs('/contract/edit/' .  $this->unsigned_legal_contract->id)
            ->assertViewHas(['contract', 'client'])
            ->see('Izmena Ugovora br. ' .  $this->unsigned_legal_contract->contract_number);
    }

    /**
     * Test Admin Can See Form For Editing Unsigned Individual Contract (ContractsController@edit)
     *
     * @test
     * @return void
     */
    public function admin_can_see_form_for_editing_unsigned_individual_contract()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/' .  $this->unsigned_individual_contract->id)
            ->click('IZMENI UGOVOR')
            ->seePageIs('/contract/edit/' .  $this->unsigned_individual_contract->id)
            ->assertViewHas(['contract', 'client'])
            ->see('Izmena Ugovora br. ' .  $this->unsigned_individual_contract->contract_number);
    }

    /**
     * Test User Can See Form For Editing Unsigned Legal Contract (ContractsController@edit)
     *
     * @test
     * @return void
     */
    public function user_can_see_form_for_editing_unsigned_legal_contract()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/' .  $this->unsigned_legal_contract->id)
            ->click('IZMENI UGOVOR')
            ->seePageIs('/contract/edit/' .  $this->unsigned_legal_contract->id)
            ->assertViewHas(['contract', 'client'])
            ->see('Izmena Ugovora br. ' .  $this->unsigned_legal_contract->contract_number);
    }

    /**
     * Test User Can See Form For Editing Unsigned Individual Contract (ContractsController@edit)
     *
     * @test
     * @return void
     */
    public function user_can_see_form_for_editing_unsigned_individual_contract()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/' .  $this->unsigned_individual_contract->id)
            ->click('IZMENI UGOVOR')
            ->seePageIs('/contract/edit/' .  $this->unsigned_individual_contract->id)
            ->assertViewHas(['contract', 'client'])
            ->see('Izmena Ugovora br. ' .  $this->unsigned_individual_contract->contract_number);
    }


    /**
     * Test In Progress, Finished And Broken Contracts Can Not Edit (ContractsController@edit)
     *
     * @test
     * @return void
     */
    public function in_progress_finished_and_broken_contracts_can_not_edit()
    {
        $contracts= Contract::whereIn('contract_status_id', [2,3,4])->get();
        foreach ($contracts as $contract) {
            $this->actingAs(self::$admin)
                ->visit('/contract/' . $contract->id)
                ->dontSee('IZMENI UGOVOR')
                ->get('/contract/edit/' . $contract->id)
                ->assertRedirectedTo('/contract/' . $contract->id)
                ->dontSee('Izmena Ugovora br. ' . $contract->contract_number);
        }
    }

    /**
     * Test Admin Can Return From Edit Unsigned Legal Contract Page To Contract Page (LegalsController@edit)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_edit_unsigned_legal_contract_page_to_contract_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/' . $this->unsigned_legal_contract->id)
            ->visit('/contract/edit/' . $this->unsigned_legal_contract->id)
            ->click('Nazad')
            ->seePageIs('/contract/' . $this->unsigned_legal_contract->id);
    }

    /**
     * Test Admin Can Return From Edit Unsigned Individual Contract Page To Contract Page (LegalsController@edit)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_edit_unsigned_individual_contract_page_to_contract_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/' . $this->unsigned_individual_contract->id)
            ->visit('/contract/edit/' . $this->unsigned_individual_contract->id)
            ->click('Nazad')
            ->seePageIs('/contract/' . $this->unsigned_individual_contract->id);
    }

    /**
     * Test User Can Return From Edit Unsigned Legal Contract Page To Contract Page (LegalsController@edit)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_edit_unsigned_legal_contract_page_to_contract_page()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/' . $this->unsigned_legal_contract->id)
            ->visit('/contract/edit/' . $this->unsigned_legal_contract->id)
            ->click('Nazad')
            ->seePageIs('/contract/' . $this->unsigned_legal_contract->id);
    }

    /**
     * Test User Can Return From Edit Unsigned Individual Contract Page To Contract Page (LegalsController@edit)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_edit_unsigned_individual_contract_page_to_contract_page()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/' . $this->unsigned_individual_contract->id)
            ->visit('/contract/edit/' . $this->unsigned_individual_contract->id)
            ->click('Nazad')
            ->seePageIs('/contract/' . $this->unsigned_individual_contract->id);
    }

    /**
     * Test Admin Can Update Unsigned Legal Contract (ContractsController@update)
     *
     * @test
     * @return void
     */
    public function admin_can_update_unsigned_legal_contract()
    {
        $participants_number = Participant::count();
        $this->actingAs(self::$admin)
            ->visit('/contract/edit/' . $this->unsigned_legal_contract->id)
            ->see('IZMENA UGOVORA br. ' . $this->unsigned_legal_contract->contract_number)
            ->type($value = $this->faker->numberBetween(20000, 50000), 'value')
            ->type($this->faker->text(30), 'value_letters')
            ->type($advance = rand(0, $value/10), 'advance')
            ->type($payments = rand(1, 12), 'payments')
            ->type($participants = rand(1, 10), 'participants')
            ->type($now = date('d.m.Y.'), 'format_contract_date')
            ->type(date('Y-m-d', strtotime($now)), 'contract_date')
            ->type($start = date('d.m.Y.', strtotime("+3 days")), 'format_start_date')
            ->type(date('Y-m-d', strtotime($start)), 'start_date')
            ->type($end = date('d.m.Y.', strtotime("+30 days")), 'format_end_date')
            ->type(date('Y-m-d', strtotime($end)), 'end_date')
            ->type($this->faker->text(50), 'event_place')
            ->type($this->faker->text(50), 'classes_number')
            ->type($this->faker->text(100), 'work_dynamics')
            ->type($this->faker->text(100), 'event_time')
            ->type($this->faker->text(1000), 'description')
            ->press('POTVRDI IZMENU')
            ->seeInDatabase('contracts', ['id' => $this->unsigned_legal_contract->id, 'value' => $value])
            ->seePageIs('/contract/edit/' . $this->unsigned_legal_contract->id)
            ->see('Ugovor je uspešno izmenjen.');

        $advance_payment = $advance ? 1 : 0;

        $this->assertEquals(
            $advance_payment,
            Payment::where('contract_id', $this->unsigned_legal_contract->id)->where('is_advance', 1)->count()
        );

        $this->assertEquals(
            $payments + $advance_payment,
            Payment::where('contract_id', $this->unsigned_legal_contract->id)->count()
        );

        $this->assertEquals(
            $value,
            Payment::where('contract_id', $this->unsigned_legal_contract->id)->sum('value_euro')
        );

        $this->assertEquals(
            $participants,
            ContractParticipant::where('contract_id', $this->unsigned_legal_contract->id)->count()
        );
        $this->assertEquals(
            $participants_number + $participants,
            Participant::count()
        );
    }

    /**
     * Test Admin Can Update Unsigned Individual Contract (ContractsController@update)
     *
     * @test
     * @return void
     */
    public function admin_can_update_unsigned_individual_contract()
    {
        $participants_number = Participant::count();
        $this->actingAs(self::$admin)
            ->visit('/contract/edit/' . $this->unsigned_individual_contract->id)
            ->see('IZMENA UGOVORA br. ' . $this->unsigned_individual_contract->contract_number)
            ->type($value = $this->faker->numberBetween(20000, 50000), 'value')
            ->type($this->faker->text(30), 'value_letters')
            ->type($advance = rand(0, $value/10), 'advance')
            ->type($payments = rand(1, 12), 'payments')
            ->type($participants = rand(1, 10), 'participants')
            ->type($now = date('d.m.Y.'), 'format_contract_date')
            ->type(date('Y-m-d', strtotime($now)), 'contract_date')
            ->type($start = date('d.m.Y.', strtotime("+3 days")), 'format_start_date')
            ->type(date('Y-m-d', strtotime($start)), 'start_date')
            ->type($end = date('d.m.Y.', strtotime("+30 days")), 'format_end_date')
            ->type(date('Y-m-d', strtotime($end)), 'end_date')
            ->type($this->faker->text(50), 'event_place')
            ->type($this->faker->text(50), 'classes_number')
            ->type($this->faker->text(100), 'work_dynamics')
            ->type($this->faker->text(100), 'event_time')
            ->type($this->faker->text(1000), 'description')
            ->press('POTVRDI IZMENU')
            ->seeInDatabase('contracts', ['id' => $this->unsigned_individual_contract->id, 'value' => $value])
            ->seePageIs('/contract/edit/' . $this->unsigned_individual_contract->id)
            ->see('Ugovor je uspešno izmenjen.');

        $advance_payment = $advance ? 1 : 0;

        $this->assertEquals(
            $advance_payment,
            Payment::where('contract_id', $this->unsigned_individual_contract->id)->where('is_advance', 1)->count()
        );

        $this->assertEquals(
            $payments + $advance_payment,
            Payment::where('contract_id', $this->unsigned_individual_contract->id)->count()
        );

        $this->assertEquals(
            $value,
            Payment::where('contract_id', $this->unsigned_individual_contract->id)->sum('value_euro')
        );

        $this->assertEquals(
            $participants,
            ContractParticipant::where('contract_id', $this->unsigned_individual_contract->id)->count()
        );
        $this->assertEquals(
            $participants_number + $participants,
            Participant::count()
        );
    }

    /**
     * Test User Can Not Update Unsigned Legal Contract (ContractsController@update)
     *
     * @test
     * @return void
     */
    public function user_can_not_update_unsigned_legal_contract()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/edit/' . $this->unsigned_legal_contract->id)
            ->see('IZMENA UGOVORA br. ' . $this->unsigned_legal_contract->contract_number)
            ->type($value = $this->faker->numberBetween(20000, 50000), 'value')
            ->type($this->faker->text(30), 'value_letters')
            ->type($advance = rand(0, $value/10), 'advance')
            ->type($payments = rand(1, 12), 'payments')
            ->type($participants = rand(1, 10), 'participants')
            ->type($now = date('d.m.Y.'), 'format_contract_date')
            ->type(date('Y-m-d', strtotime($now)), 'contract_date')
            ->type($start = date('d.m.Y.', strtotime("+3 days")), 'format_start_date')
            ->type(date('Y-m-d', strtotime($start)), 'start_date')
            ->type($end = date('d.m.Y.', strtotime("+30 days")), 'format_end_date')
            ->type(date('Y-m-d', strtotime($end)), 'end_date')
            ->type($this->faker->text(50), 'event_place')
            ->type($this->faker->text(50), 'classes_number')
            ->type($this->faker->text(100), 'work_dynamics')
            ->type($this->faker->text(100), 'event_time')
            ->type($this->faker->text(1000), 'description')
            ->press('POTVRDI IZMENU')
            ->dontSeeInDatabase('contracts', ['id' => $this->unsigned_legal_contract->id, 'value' => $value])
            ->seePageIs('/contract/edit/' . $this->unsigned_legal_contract->id)
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test User Can Not Update Unsigned Individual Contract (ContractsController@update)
     *
     * @test
     * @return void
     */
    public function user_can_not_update_unsigned_individual_contract()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/edit/' . $this->unsigned_individual_contract->id)
            ->see('IZMENA UGOVORA br. ' . $this->unsigned_individual_contract->contract_number)
            ->type($value = $this->faker->numberBetween(20000, 50000), 'value')
            ->type($this->faker->text(30), 'value_letters')
            ->type($advance = rand(0, $value/10), 'advance')
            ->type($payments = rand(1, 12), 'payments')
            ->type($participants = rand(1, 10), 'participants')
            ->type($now = date('d.m.Y.'), 'format_contract_date')
            ->type(date('Y-m-d', strtotime($now)), 'contract_date')
            ->type($start = date('d.m.Y.', strtotime("+3 days")), 'format_start_date')
            ->type(date('Y-m-d', strtotime($start)), 'start_date')
            ->type($end = date('d.m.Y.', strtotime("+30 days")), 'format_end_date')
            ->type(date('Y-m-d', strtotime($end)), 'end_date')
            ->type($this->faker->text(50), 'event_place')
            ->type($this->faker->text(50), 'classes_number')
            ->type($this->faker->text(100), 'work_dynamics')
            ->type($this->faker->text(100), 'event_time')
            ->type($this->faker->text(1000), 'description')
            ->press('POTVRDI IZMENU')
            ->dontSeeInDatabase('contracts', ['id' => $this->unsigned_individual_contract->id, 'value' => $value])
            ->seePageIs('/contract/edit/' . $this->unsigned_individual_contract->id)
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test False Update Unsigned Legal Contract With Get Method (ContractsController@update)
     *
     * @test
     * @return void
     */
    public function false_update_unsigned_legal_contract_with_get_method()
    {
        $this->actingAs(self::$admin)
        ->get('/contract/update/' . $this->unsigned_legal_contract->id, [
            'value' => $value = $this->faker->numberBetween(20000, 50000),
            'value_letters' => $this->faker->text(30),
            'advance' => $advance = rand(1000, $value/10),
            'payments' => $payments = rand(1, 12),
            'participants' => $participants = rand(1, 10),
            'format_contract_date' => $now = date('d.m.Y.'),
            'contract_date' => date('Y-m-d', strtotime($now)),
            'format_start_date' => $start = date('d.m.Y.', strtotime("+3 days")),
            'start_date' => date('Y-m-d', strtotime($start)),
            'format_end_date' => $end = date('d.m.Y.', strtotime("+30 days")),
            'end_date' => date('Y-m-d', strtotime($end)),
            'event_place' => $this->faker->text(50),
            'classes_number' => $this->faker->text(50),
            'work_dynamics' => $this->faker->text(100),
            'event_time' => $this->faker->text(100),
            'description' => $this->faker->text(1000)
            ])
        ->assertResponseStatus(405)
        ->see('405 Something Went Wrong');
    }

    /**
     * Test False Update Unsigned Individual Contract With Get Method (ContractsController@update)
     *
     * @test
     * @return void
     */
    public function false_update_unsigned_individual_contract_with_get_method()
    {
        $this->actingAs(self::$admin)
        ->get('/contract/update/' . $this->unsigned_individual_contract->id, [
            'value' => $value = $this->faker->numberBetween(20000, 50000),
            'value_letters' => $this->faker->text(30),
            'advance' => $advance = rand(1000, $value/10),
            'payments' => $payments = rand(1, 12),
            'participants' => $participants = rand(1, 10),
            'format_contract_date' => $now = date('d.m.Y.'),
            'contract_date' => date('Y-m-d', strtotime($now)),
            'format_start_date' => $start = date('d.m.Y.', strtotime("+3 days")),
            'start_date' => date('Y-m-d', strtotime($start)),
            'format_end_date' => $end = date('d.m.Y.', strtotime("+30 days")),
            'end_date' => date('Y-m-d', strtotime($end)),
            'event_place' => $this->faker->text(50),
            'classes_number' => $this->faker->text(50),
            'work_dynamics' => $this->faker->text(100),
            'event_time' => $this->faker->text(100),
            'description' => $this->faker->text(1000)
            ])
        ->assertResponseStatus(405)
        ->see('405 Something Went Wrong');
    }

    /**
     * Test Admin Can See Form For Add Descirption In Progress Legal Contract (ContractsController@add_description)
     *
     * @test
     * @return void
     */
    public function admin_can_see_form_for_add_description_in_progress_legal_contract()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/' . $this->in_progress_legal_contract->id)
            ->click('IZMENI OPIS UGOVORA')
            ->seePageIs('/contract/add_description/' . $this->in_progress_legal_contract->id)
            ->see('Izmena opisa Ugovora br. ' . $this->in_progress_legal_contract->contract_number);
    }

    /**
     * Test Admin Can See Form For Add Descirption In Progress Individual Contract (ContractsController@add_description)
     *
     * @test
     * @return void
     */
    public function admin_can_see_form_for_add_description_in_progress_individual_contract()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/' . $this->in_progress_individual_contract->id)
            ->click('IZMENI OPIS UGOVORA')
            ->seePageIs('/contract/add_description/' . $this->in_progress_individual_contract->id)
            ->see('Izmena opisa Ugovora br. ' . $this->in_progress_individual_contract->contract_number);
    }

    /**
     * Test User Can See Form For Add Descirption In Progress Legal Contract (ContractsController@add_description)
     *
     * @test
     * @return void
     */
    public function user_can_see_form_for_add_description_in_progress_legal_contract()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/' . $this->in_progress_legal_contract->id)
            ->click('IZMENI OPIS UGOVORA')
            ->seePageIs('/contract/add_description/' . $this->in_progress_legal_contract->id)
            ->see('Izmena opisa Ugovora br. ' . $this->in_progress_legal_contract->contract_number);
    }

    /**
     * Test User Can See Form For Add Descirption In Progress Individual Contract (ContractsController@add_description)
     *
     * @test
     * @return void
     */
    public function user_can_see_form_for_add_description_in_progress_individual_contract()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/' . $this->in_progress_individual_contract->id)
            ->click('IZMENI OPIS UGOVORA')
            ->seePageIs('/contract/add_description/' . $this->in_progress_individual_contract->id)
            ->see('Izmena opisa Ugovora br. ' . $this->in_progress_individual_contract->contract_number);
    }

    /**
     * Test Unsigned, Finished And Broken Contracts Can Not Add Description(ContractsController@add_description)
     *
     * @test
     * @return void
     */
    public function unsigned_finished_and_broken_contracts_can_not_add_description()
    {
        $contracts= Contract::whereIn('contract_status_id', [1,3,4])->get();
        foreach ($contracts as $contract) {
            $this->actingAs(self::$admin)
                ->visit('/contract/' . $contract->id)
                ->dontSee('IZMENI OPIS UGOVORA')
                ->get('/contract/add_description/' . $contract->id)
                ->assertRedirectedTo('/contract/' . $contract->id)
                ->dontSee('Izmena opisa Ugovora br. ' . $contract->contract_number);
        }
    }

    /**
     * Test Admin Can Return From Add Description In Progress Legal Contract Page To Contract Page (LegalsController@edit)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_add_description_in_progress_legal_contract_page_to_contract_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/' . $this->in_progress_legal_contract->id)
            ->visit('/contract/add_description/' . $this->in_progress_legal_contract->id)
            ->click('Nazad')
            ->seePageIs('/contract/' . $this->in_progress_legal_contract->id);
    }

    /**
     * Test Admin Can Return From Add Description In Progress Individual Contract Page To Contract Page (LegalsController@edit)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_add_description_in_progress_individual_contract_page_to_contract_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/' . $this->in_progress_individual_contract->id)
            ->visit('/contract/add_description/' . $this->in_progress_individual_contract->id)
            ->click('Nazad')
            ->seePageIs('/contract/' . $this->in_progress_individual_contract->id);
    }

    /**
     * Test User Can Return From Add Description In Progress Legal Contract Page To Contract Page (LegalsController@edit)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_add_description_in_progress_legal_contract_page_to_contract_page()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/' . $this->in_progress_legal_contract->id)
            ->visit('/contract/add_description/' . $this->in_progress_legal_contract->id)
            ->click('Nazad')
            ->seePageIs('/contract/' . $this->in_progress_legal_contract->id);
    }

    /**
     * Test User Can Return From Add Description In Progress Individual Contract Page To Contract Page (LegalsController@edit)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_add_description_in_progress_individual_contract_page_to_contract_page()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/' . $this->in_progress_individual_contract->id)
            ->visit('/contract/add_description/' . $this->in_progress_individual_contract->id)
            ->click('Nazad')
            ->seePageIs('/contract/' . $this->in_progress_individual_contract->id);
    }

    /**
     * Test Admin Can Update Description In Progress Legal Contract (ContractsController@update_description)
     *
     * @test
     * @return void
     */
    public function admin_can_update_description_in_progress_legal_contract()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/add_description/' . $this->in_progress_legal_contract->id)
            ->type($description = $this->faker->text(1000), 'description')
            ->press('POTVRDI IZMENU')
            ->seeInDatabase('contracts', ['id' => $this->in_progress_legal_contract->id, 'description' => $description])
            ->seePageIs('/contract/add_description/' . $this->in_progress_legal_contract->id)
            ->see('Opis Ugovora je uspešno izmenjen.');
    }

    /**
     * Test Admin Can Update Description In Progress Individual Contract (ContractsController@update_description)
     *
     * @test
     * @return void
     */
    public function admin_can_update_description_in_progress_individual_contract()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/add_description/' . $this->in_progress_individual_contract->id)
            ->type($description = $this->faker->text(1000), 'description')
            ->press('POTVRDI IZMENU')
            ->seeInDatabase('contracts', ['id' => $this->in_progress_individual_contract->id, 'description' => $description])
            ->seePageIs('/contract/add_description/' . $this->in_progress_individual_contract->id)
            ->see('Opis Ugovora je uspešno izmenjen.');
    }

    /**
     * Test User Can Not Update Description In Progress Legal Contract (ContractsController@update_description)
     *
     * @test
     * @return void
     */
    public function user_can_not_update_description_in_progress_legal_contract()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/add_description/' . $this->in_progress_legal_contract->id)
            ->type($description = $this->faker->text(1000), 'description')
            ->press('POTVRDI IZMENU')
            ->dontSeeInDatabase('contracts', ['id' => $this->in_progress_legal_contract->id, 'description' => $description])
            ->seePageIs('/contract/add_description/' . $this->in_progress_legal_contract->id)
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test User Can Not Update Description In Progress Individual Contract (ContractsController@update_description)
     *
     * @test
     * @return void
     */
    public function user_can_not_update_description_in_progress_individual_contract()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/add_description/' . $this->in_progress_individual_contract->id)
            ->type($description = $this->faker->text(1000), 'description')
            ->press('POTVRDI IZMENU')
            ->dontSeeInDatabase('contracts', ['id' => $this->in_progress_individual_contract->id, 'description' => $description])
            ->seePageIs('/contract/add_description/' . $this->in_progress_individual_contract->id)
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test False Update Add Description In Progress Legal Contract With Get Method (ContractsController@update_description)
     *
     * @test
     * @return void
     */
    public function false_update_update_description_in_progress_legal_contract_with_get_method()
    {
        $this->actingAs(self::$admin)
        ->get('/contract/update_description/' . $this->in_progress_legal_contract->id, [
            'description' => $this->faker->text(1000)
            ])
        ->assertResponseStatus(405)
        ->see('405 Something Went Wrong');
    }

    /**
     * Test False Update Add Description In Progress Individual Contract With Get Method (ContractsController@update_description)
     *
     * @test
     * @return void
     */
    public function false_update_update_description_in_progress_individual_contract_with_get_method()
    {
        $this->actingAs(self::$admin)
        ->get('/contract/update_description/' . $this->in_progress_individual_contract->id, [
            'description' => $this->faker->text(1000)
            ])
        ->assertResponseStatus(405)
        ->see('405 Something Went Wrong');
    }

    /**
     * Test Update Add Description In Progress Legal Contract Description  Must Be Maximum 5000 characters long (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function update_add_description_in_progress_legal_contract_description_must_be_maximum_5000_characters_long()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/add_description/' . $this->in_progress_legal_contract->id)
            ->type($description = $this->faker->text(6000), 'description')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/contract/add_description/' . $this->in_progress_legal_contract->id)
            ->dontSeeInDatabase(
                'contracts',
                [ 'id' => $this->in_progress_legal_contract->id,'description' => $description ]
            )
            ->see('Polje Opis Ugovora mora sadržati manje od 5000 karaktera.');
    }

    /**
     * Test Update Add Description In Progress Individual Contract Description  Must Be Maximum 5000 characters long (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function update_add_description_in_progress_individual_contract_description_must_be_maximum_5000_characters_long()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/add_description/' . $this->in_progress_individual_contract->id)
            ->type($description = $this->faker->text(6000), 'description')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/contract/add_description/' . $this->in_progress_individual_contract->id)
            ->dontSeeInDatabase(
                'contracts',
                [ 'id' => $this->in_progress_individual_contract->id,'description' => $description ]
            )
            ->see('Polje Opis Ugovora mora sadržati manje od 5000 karaktera.');
    }

    /**
     * Test Store And Update Legal And Individual Contract Value Is Required (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_contract_value_is_required()
    {
        $data['field_name'] = 'value';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Vrednost Ugovora (EUR) je obavezno.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Value Must Be Numeric (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_contract_value_must_be_numeric()
    {
        $data['field_name'] = 'value';
        $data['field_value'] = 'value';
        $data['error_message'] = "Polje Vrednost Ugovora (EUR) mora biti broj.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Value Must Be Between 0 And 10 Digits (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_contract_value_must_be_between_0_and_10_digits()
    {
        $data['field_name'] = 'value';
        $data['field_value'] = 100000000000;
        $data['error_message'] = "Polje Vrednost Ugovora (EUR) mora biti izemđu 0 i 10 cifri.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Value Must Be Minimum 0 (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_and_individual_contract_value_must_be_minimum_0()
    {
        $data['field_name'] = 'value';
        $data['field_value'] = -200;
        $data['error_message'] = "Polje Vrednost Ugovora (EUR) mora biti najmanje 0.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Value Letters Is Required (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_contract_value_letters_is_required()
    {
        $data['field_name'] = 'value_letters';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Vrednost Ugovora slovima je obavezno.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Value Letters Must Contain Only Letters, Spaces, Dots And Hyphens (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_and_individual_contract_value_letters_must_contain_only_letters_spaces_dots_and_hyphens()
    {
        $data['field_name'] = 'value_letters';
        $data['field_value'] =  'a$_(*&^)';
        $data['error_message'] = "Polje Vrednost Ugovora slovima može sadržati samo slova, razmake, tačke, srednje crte i apostrofe.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Value Letters Must Be Maximimum 255 Characters Long (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_contract_value_letters_must_be_maximum_255_characters_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', 'a', str_random(256));
        $data['field_name'] = 'value_letters';
        $data['field_value'] =  $too_long_name;
        $data['error_message'] = "Polje Vrednost Ugovora slovima mora sadržati manje od 255 karaktera.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Advance Is Required (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_contract_advance_is_required()
    {
        $data['field_name'] = 'advance';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Avans (EUR) je obavezno.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Advance Must Be Numeric (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_contract_advance_must_be_numeric()
    {
        $data['field_name'] = 'advance';
        $data['field_value'] = 'advance';
        $data['error_message'] = "Polje Avans (EUR) mora biti broj.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Advance Must Be Between 0 And 10 Digits (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_contract_advance_must_be_between_0_and_10_digits()
    {
        $data['field_name'] = 'advance';
        $data['field_value'] = 100000000000;
        $data['error_message'] = "Polje Avans (EUR) mora biti izemđu 0 i 10 cifri.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal Contract Advance Must Be Less Or Equal Than Contract Value (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_contract_advance_must_be_less_or_equal_than_contract_value()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type(4000, 'value')
            ->type($advance = 5000, 'advance')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->dontSeeInDatabase(
                'contracts',
                [ 'client_id' => $this->accept_meeting_legal->client_id, 'advance' => $advance ]
            )
            ->see("Polje Avans mora biti jednako ili manje od polja Vrednost Ugovora.");
    }

    /**
     * Test Store And Update Individual Contract Advance Must Be Less Or Equal Than Contract Value (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_individual_contract_advance_must_be_less_or_equal_than_contract_value()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type(4000, 'value')
            ->type($advance = 5000, 'advance')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->dontSeeInDatabase(
                'contracts',
                [ 'client_id' => $this->accept_meeting_individual->client_id, 'advance' => $advance ]
            )
            ->see("Polje Avans mora biti jednako ili manje od polja Vrednost Ugovora.");
    }

    /**
     * Test Store And Update Legal Contract Advance Must Be Equal To Contract Value If Payments Is 0 (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_contract_advance_must_be_equal_to_contract_value_if_payments_is_0()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type(20000, 'value')
            ->type(0, 'payments')
            ->type($advance = 5000, 'advance')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->dontSeeInDatabase(
                'contracts',
                [ 'client_id' => $this->accept_meeting_legal->client_id, 'advance' => $advance ]
            )
            ->see("Polje Avans mora imati vrednost polja Vrednost Ugovora (EUR) ako polje Broj rata ima vrednost 0");
    }

    /**
     * Test Store And Update Individual Contract Advance Must Be Equal To Contract Value If Payments Is 0 (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_individual_contract_advance_must_be_equal_to_contract_value_if_payments_is_0()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type(20000, 'value')
            ->type(0, 'payments')
            ->type($advance = 5000, 'advance')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->dontSeeInDatabase(
                'contracts',
                [ 'client_id' => $this->accept_meeting_individual->client_id, 'advance' => $advance ]
            )
            ->see("Polje Avans mora imati vrednost polja Vrednost Ugovora (EUR) ako polje Broj rata ima vrednost 0");
    }

    /**
     * Test Store And Update Legal And Individual Contract Payments Is Required (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_contract_payments_is_required()
    {
        $data['field_name'] = 'payments';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Broj rata je obavezno.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Payments Must Be Numeric (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_contract_payments_must_be_numeric()
    {
        $data['field_name'] = 'payments';
        $data['field_value'] = 'payments';
        $data['error_message'] = "Polje Broj rata mora biti broj.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Payments Must Be Between 0 And 4 Digits (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_contract_payments_must_be_between_0_and_4_digits()
    {
        $data['field_name'] = 'payments';
        $data['field_value'] = 10000;
        $data['error_message'] = "Polje Broj rata mora biti izemđu 0 i 4 cifri.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Payments Must Be Minimum 0 (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_and_individual_contract_payments_must_be_minimum_0()
    {
        $data['field_name'] = 'payments';
        $data['field_value'] = -2;
        $data['error_message'] = "Polje Broj rata mora biti najmanje 0.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal Contract Payments Must Be Greater Than 0 If Advance Is 0 (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_contract_payments_must_be_greater_than_0_if_advance_is_0()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type($payments = 0, 'payments')
            ->type(0, 'advance')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->dontSeeInDatabase(
                'contracts',
                [ 'client_id' => $this->accept_meeting_legal->client_id, 'payments' => $payments ]
            )
            ->see("Polje Broj rata mora biti veće od 0 ako polje Avans (EUR) ima vrednost 0");
    }

    /**
     * Test Store And Update Individual Contract Payments Must Be Greater Than 0 If Advance Is 0 (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_individual_contract_payments_must_be_greater_than_0_if_advance_is_0()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type($payments = 0, 'payments')
            ->type(0, 'advance')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->dontSeeInDatabase(
                'contracts',
                [ 'client_id' => $this->accept_meeting_individual->client_id, 'payments' => $payments ]
            )
            ->see("Polje Broj rata mora biti veće od 0 ako polje Avans (EUR) ima vrednost 0");
    }

    /**
     * Test Store And Update Legal And Individual Contract Participants Is Required (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_contract_participants_is_required()
    {
        $data['field_name'] = 'participants';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Broj učesnika je obavezno.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Participants Must Be Numeric (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_contract_participants_must_be_numeric()
    {
        $data['field_name'] = 'participants';
        $data['field_value'] = 'participants';
        $data['error_message'] = "Polje Broj učesnika mora biti broj.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Participants Must Be Minimum 0 (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_and_individual_contract_participants_must_be_minimum_0()
    {
        $data['field_name'] = 'participants';
        $data['field_value'] = -200;
        $data['error_message'] = "Polje Broj učesnika mora biti najmanje 0.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Individual Contract Participants Must Be Maximum 10000 (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_and_individual_contract_participants_must_be_maximum_10000()
    {
        $data['field_name'] = 'participants';
        $data['field_value'] = 15000;
        $data['error_message'] = "Polje Broj učesnika mora biti manje od 10000.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal Contract Date Is Required (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_contract_date_is_required()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type('', 'format_contract_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->see("Polje Datum Ugovora je obavezno.");
    }

    /**
     * Test Store And Update Individual Contract Date Is Required (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_contract_date_is_required()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type('', 'format_contract_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->see("Polje Datum Ugovora je obavezno.");
    }

    /**
     * Test Store And Update Legal Contract Date Is In Invalid Format (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_contract_date_is_in_invalid_format()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type(date('Y-m-d'), 'format_contract_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->see("Polje Datum Ugovora ne odgovora prema formatu d.m.Y..");
    }

    /**
     * Test Store And Update Individual Contract Date Is In Invalid Format (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_contract_date_is_in_invalid_format()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type(date('Y-m-d'), 'format_contract_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->see("Polje Datum Ugovora ne odgovora prema formatu d.m.Y..");
    }

    /**
     * Test Store And Update Legal Contract Date Must Be Today Or From Today (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_contract_date_must_be_today_or_after_today()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type(date("d.m.Y.", strtotime("-1 month")), 'format_contract_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->see("Polje Datum Ugovora mora biti današnji datum ili posle današnjeg datuma.");
    }

    /**
     * Test Store And Update Individual Contract Date Must Be Today Or From Today (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_contract_date_must_be_today_or_after_today()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type(date("d.m.Y.", strtotime("-1 month")), 'format_contract_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->see("Polje Datum Ugovora mora biti današnji datum ili posle današnjeg datuma.");
    }

    /**
     * Test Store And Update Legal Contract Start Date Is In Invalid Format (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_contract_start_date_is_in_invalid_format()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type(date('Y-m-d'), 'format_start_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->see("Polje Datum početka ne odgovora prema formatu d.m.Y..");
    }

    /**
     * Test Store And Update Individual Contract Start Date Is In Invalid Format (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_contract_start_date_is_in_invalid_format()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type(date('Y-m-d'), 'format_start_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->see("Polje Datum početka ne odgovora prema formatu d.m.Y..");
    }

    /**
     * Test Store And Update Legal Contract Start Date Must Be Today Or From Today (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_contract_start_date_must_be_today_or_after_today()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type(date("d.m.Y.", strtotime("-1 month")), 'format_start_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->see("Polje Datum početka mora biti današnji datum ili posle današnjeg datuma.");
    }

    /**
     * Test Store And Update Individual Contract Start Date Must Be Today Or From Today (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_contract_start_date_must_be_today_or_after_today()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type(date("d.m.Y.", strtotime("-1 month")), 'format_start_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->see("Polje Datum početka mora biti današnji datum ili posle današnjeg datuma.");
    }

    /**
     * Test Store And Update Legal Contract Start Date Must Be On Contract Date Or After (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_contract_start_date_must_be_on_contract_date_or_after()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type(date("Y-m-d", strtotime("+2 months")), 'contract_date')
            ->type(date("d.m.Y.", strtotime("+1 months")), 'format_start_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->see("Polje Datum početka mora biti datum koji ne sme biti pre polja Datum Ugovora.");
    }

    /**
     * Test Store And Update Individual Contract Start Date Must Be On Contract Date Or After (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_contract_start_date_must_be_on_contract_date_or_after()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type(date("Y-m-d", strtotime("+2 months")), 'contract_date')
            ->type(date("d.m.Y.", strtotime("+1 months")), 'format_start_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->see("Polje Datum početka mora biti datum koji ne sme biti pre polja Datum Ugovora.");
    }

    /**
     * Test Store And Update Legal Contract End Date Is In Invalid Format (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_contract_end_date_is_in_invalid_format()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type(date('Y-m-d'), 'format_end_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->see("Polje Datum završetka ne odgovora prema formatu d.m.Y..");
    }

    /**
     * Test Store And Update Individual Contract End Date Is In Invalid Format (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_contract_end_date_is_in_invalid_format()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type(date('Y-m-d'), 'format_end_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->see("Polje Datum završetka ne odgovora prema formatu d.m.Y..");
    }

    /**
     * Test Store And Update Legal Contract End Date Must Be Today Or From Today (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_contract_end_date_must_be_today_or_after_today()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type(date("d.m.Y.", strtotime("-1 month")), 'format_end_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->see("Polje Datum završetka mora biti današnji datum ili posle današnjeg datuma.");
    }

    /**
     * Test Store And Update Individual Contract End Date Must Be Today Or From Today (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_contract_end_date_must_be_today_or_after_today()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type(date("d.m.Y.", strtotime("-1 month")), 'format_end_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->see("Polje Datum završetka mora biti današnji datum ili posle današnjeg datuma.");
    }

    /**
     * Test Store And Update Legal Contract End Date Must Be On Contract Date Or After (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_contract_end_date_must_be_on_contract_date_or_after()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type(date("Y-m-d", strtotime("+2 months")), 'contract_date')
            ->type(date("d.m.Y.", strtotime("+1 months")), 'format_end_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->see("Polje Datum završetka mora biti datum koji ne sme biti pre polja Datum Ugovora.");
    }

    /**
     * Test Store And Update Individual Contract End Date Must Be On Contract Date Or After (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_contract_end_date_must_be_on_contract_date_or_after()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type(date("Y-m-d", strtotime("+2 months")), 'contract_date')
            ->type(date("d.m.Y.", strtotime("+1 months")), 'format_end_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->see("Polje Datum završetka mora biti datum koji ne sme biti pre polja Datum Ugovora.");
    }

    /**
     * Test Store And Update Legal Contract End Date Must Be On Start Date Or After (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_contract_end_date_must_be_on_start_date_or_after()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type(date("Y-m-d", strtotime("+2 months")), 'start_date')
            ->type(date("d.m.Y.", strtotime("+1 months")), 'format_end_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->see("Polje Datum završetka mora biti datum koji ne sme biti pre polja Datum početka.");
    }

    /**
     * Test Store And Update Individaul Contract End Date Must Be On Start Date Or After (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_contract_end_date_must_be_on_start_date_or_after()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type(date("Y-m-d", strtotime("+2 months")), 'start_date')
            ->type(date("d.m.Y.", strtotime("+1 months")), 'format_end_date')
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->see("Polje Datum završetka mora biti datum koji ne sme biti pre polja Datum početka.");
    }
    /**
     * Test Store And Update Legal And Inidvidual Event Place Must Be Maximimum 255 Characters Long (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_event_place_must_be_maximum_255_characters_long()
    {
        $data['field_name'] = 'event_place';
        $data['field_value'] =  str_random(256);
        $data['error_message'] = "Polje Mesto održavanja mora sadržati manje od 255 karaktera.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }

    /**
     * Test Store And Update Legal And Inidvidual Classes Number Must Be Maximimum 255 Characters Long (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_classes_number_must_be_maximum_255_characters_long()
    {
        $data['field_name'] = 'classes_number';
        $data['field_value'] =  str_random(256);
        $data['error_message'] = "Polje Broj časova mora sadržati manje od 255 karaktera.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }
    
    /**
     * Test Store And Update Legal And Inidvidual Work Dynamics Must Be Maximimum 255 Characters Long (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_work_dynamics_must_be_maximum_255_characters_long()
    {
        $data['field_name'] = 'work_dynamics';
        $data['field_value'] =  str_random(256);
        $data['error_message'] = "Polje Dinamika rada mora sadržati manje od 255 karaktera.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }
    
    /**
     * Test Store And Update Legal And Inidvidual Event Time Must Be Maximimum 255 Characters Long (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_event_time_must_be_maximum_255_characters_long()
    {
        $data['field_name'] = 'event_time';
        $data['field_value'] =  str_random(256);
        $data['error_message'] = "Polje Vreme održavanja mora sadržati manje od 255 karaktera.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }
    
    /**
     * Test Store And Update Legal And Inidvidual Description Must Be Maximimum 5000 Characters Long (ContractsController@store, ContractsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_and_individual_description_must_be_maximum_5000_characters_long()
    {
        $data['field_name'] = 'description';
        $data['field_value'] =  str_random(5001);
        $data['error_message'] = "Polje Opis Ugovora mora sadržati manje od 5000 karaktera.";
        $this->store_new_legal_contract_validation($data);
        $this->store_new_individual_contract_validation($data);
        $this->update_unsigned_legal_contract_validation($data);
        $this->update_unsigned_individual_contract_validation($data);
    }


    /**
     *  Validate Store New Legal Contract (ContractsController@store)
     *
     * @param array $data
     * @return void
     */
    public function store_new_legal_contract_validation($data)
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->type($data['field_value'], $data['field_name'])
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_legal->client_id)
            ->dontSeeInDatabase(
                'contracts',
                [ 'client_id' => $this->accept_meeting_legal->client_id, $data['field_name'] => $data['field_value'] ]
            )
            ->see($data['error_message']);
    }

    /**
     *  Validate Store New Inidvidual Contract (ContractsController@store)
     *
     * @param array $data
     * @return void
     */
    public function store_new_individual_contract_validation($data)
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->type($data['field_value'], $data['field_name'])
            ->press('POTVRDI')
            ->seePageIs('/contract/create/' . $this->accept_meeting_individual->client_id)
            ->dontSeeInDatabase(
                'contracts',
                [ 'client_id' => $this->accept_meeting_individual->client_id, $data['field_name'] => $data['field_value'] ]
            )
            ->see($data['error_message']);
    }
    /**
     *  Validate Update Unsigned Legal And Individual Contract (ContractsController@update)
     *
     * @param array $data
     * @return void
     */
    public function update_unsigned_legal_contract_validation($data)
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/edit/' . $this->unsigned_legal_contract->id)
            ->type($data['field_value'], $data['field_name'])
            ->press('POTVRDI')
            ->seePageIs('/contract/edit/' . $this->unsigned_legal_contract->id)
            ->dontSeeInDatabase(
                'contracts',
                [ 'id' => $this->unsigned_legal_contract->id, $data['field_name'] => $data['field_value'] ]
            )
            ->see($data['error_message']);
    }

    /**
     *  Validate Update Unsigned Individual Contract (ContractsController@update)
     *
     * @param array $data
     * @return void
     */
    public function update_unsigned_individual_contract_validation($data)
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/edit/' . $this->unsigned_individual_contract->id)
            ->type($data['field_value'], $data['field_name'])
            ->press('POTVRDI')
            ->seePageIs('/contract/edit/' . $this->unsigned_individual_contract->id)
            ->dontSeeInDatabase(
                'contracts',
                [ 'id' => $this->unsigned_individual_contract->id, $data['field_name'] => $data['field_value'] ]
            )
            ->see($data['error_message']);
    }

    /**
     * Test Admin Can Not Change Unsigned Legal Contract To In Progress Legal Contract If PDF Contract Is Not Created(ContractsController@sign)
     *
     * @test
     * @return void
     */
    public function admin_can_not_change_unsigned_legal_contract_to_in_progress_legal_contract_if_pdf_contract_is_not_created()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/' . $this->unsigned_legal_contract->id)
            ->see('Ugovor br. ' . $this->unsigned_legal_contract->contract_number)
            ->get('/contract/sign/' . $this->unsigned_legal_contract->id);
        $this->assertRedirectedTo('/contract/' . $this->unsigned_legal_contract->id, ['message' => 'Ugovor broj ' . $this->unsigned_legal_contract->contract_number . ' nije odštampan u PDF formatu!']);
     
        $pdf_file = (new Parse)->get_pdf_contract_path(true, $this->unsigned_legal_contract->client_id, $this->unsigned_legal_contract->id, 'Ugovor_' . $this->unsigned_legal_contract->contract_number . '.pdf');
        $this->assertFalse(file_exists($pdf_file));
    }

    /**
     * Test Admin Can Not Change Unsigned Individaul Contract To In Progress Individaul Contract If PDF Contract Is Not Created(ContractsController@sign)
     *
     * @test
     * @return void
     */
    public function admin_can_not_change_unsigned_individaul_contract_to_in_progress_individaul_contract_if_pdf_contract_is_not_created()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/' . $this->unsigned_individual_contract->id)
            ->see('Neformalan Ugovor')
            ->get('/contract/sign/' . $this->unsigned_individual_contract->id);
        $this->assertRedirectedTo('/contract/' . $this->unsigned_individual_contract->id, ['message' => 'Ugovor broj ' . $this->unsigned_individual_contract->contract_number . ' nije odštampan u PDF formatu!']);
     
        $pdf_file = (new Parse)->get_pdf_contract_path(true, $this->unsigned_individual_contract->client_id, $this->unsigned_individual_contract->id, 'Ugovor_' . $this->unsigned_individual_contract->contract_number . '.pdf');
        $this->assertFalse(file_exists($pdf_file));
    }

    /**
     * Test Admin Can Change Unsigned Legal Contract To In Progress Legal Contract If PDF Contract Is Created(ContractsController@sign)
     *
     * @test
     * @return void
     */
    public function admin_can_change_unsigned_legal_contract_to_in_progress_legal_contract_if_pdf_contract_is_created()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/' . $this->unsigned_legal_contract->id)
            ->see('Ugovor br. ' . $this->unsigned_legal_contract->contract_number)
            ->click('DEFAULT UGOVOR PDF');

        $pdf_file = (new Parse)->get_pdf_contract_path(true, $this->unsigned_legal_contract->client_id, $this->unsigned_legal_contract->id, 'Ugovor_' . $this->unsigned_legal_contract->contract_number . '.pdf');
        $this->assertTrue(file_exists($pdf_file));

        $this->actingAs(self::$admin)
            ->visit('/contract/' . $this->unsigned_legal_contract->id)
            ->see('Ugovor br. ' . $this->unsigned_legal_contract->contract_number)
            ->click('POTPISAN UGOVOR')
            ->seeInDatabase('contracts', [ 'id' => $this->unsigned_legal_contract->id, 'contract_status_id' => 2 ])
            ->seeInDatabase(
                'legals',
                [
                    'client_id' => $this->unsigned_legal_contract->client_id,
                    'client_status_id' => 6,
                    'closing_date' => date('Y-m-d')
                ]
            )
            ->seePageIs('/client/'.$this->unsigned_legal_contract->client_id)
            ->see('Ugovor broj ' . $this->unsigned_legal_contract->contract_number . ' je potpisan.');

        if (file_exists($pdf_file)) {
            unlink($pdf_file);
        }
    }

    /**
     * Test Admin Can Change Unsigned Individaul Contract To In Progress Individual Contract If PDF Contract Is Created(ContractsController@sign)
     *
     * @test
     * @return void
     */
    public function admin_can_change_unsigned_individual_contract_to_in_progress_individual_contract_if_pdf_contract_is_created()
    {
        $this->actingAs(self::$admin)
            ->visit('/contract/' . $this->unsigned_individual_contract->id)
            ->see('Neformalan Ugovor')
            ->click('DEFAULT UGOVOR PDF');

        $pdf_file = (new Parse)->get_pdf_contract_path(true, $this->unsigned_individual_contract->client_id, $this->unsigned_individual_contract->id, 'Ugovor_' . $this->unsigned_individual_contract->contract_number . '.pdf');
        $this->assertTrue(file_exists($pdf_file));

        $this->actingAs(self::$admin)
            ->visit('/contract/' . $this->unsigned_individual_contract->id)
            ->see('Neformalan Ugovor')
            ->click('DOGOVOREN UGOVOR')
            ->seeInDatabase('contracts', [ 'id' => $this->unsigned_individual_contract->id, 'contract_status_id' => 2 ])
            ->seeInDatabase(
                'individuals',
                [
                    'client_id' => $this->unsigned_individual_contract->client_id,
                    'client_status_id' => 6,
                    'closing_date' => date('Y-m-d')
                    
                ]
            )
            ->seePageIs('/client/'.$this->unsigned_individual_contract->client_id)
            ->see('Ugovor broj ' . $this->unsigned_individual_contract->contract_number . ' je dogovoren.');

        if (file_exists($pdf_file)) {
            unlink($pdf_file);
        }
    }


    /**
     * Test User Can Not Change Unsigned Legal Contract To In Progress Legal Contract (ContractsController@sign)
     *
     * @test
     * @return void
     */
    public function user_can_not_change_unsigned_legal_contract_to_in_progress_legal_contract()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/' . $this->unsigned_legal_contract->id)
            ->see('Ugovor br. ' . $this->unsigned_legal_contract->contract_number)
            ->click('POTPISAN UGOVOR')
            ->dontSeeInDatabase('contracts', [ 'id' => $this->unsigned_legal_contract->id, 'contract_status_id' => 2 ])
            ->seePageIs('/contract/'.$this->unsigned_legal_contract->id)
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test User Can Not Change Unsigned Individual Contract To In Progress Individual Contract (ContractsController@sign)
     *
     * @test
     * @return void
     */
    public function user_can_not_change_unsigned_individual_contract_to_in_progress_individual_contract()
    {
        $this->actingAs(self::$user)
            ->visit('/contract/' . $this->unsigned_individual_contract->id)
            ->see('Neformalan Ugovor')
            ->click('DOGOVOREN UGOVOR')
            ->dontSeeInDatabase('contracts', [ 'id' => $this->unsigned_individual_contract->id, 'contract_status_id' => 2 ])
            ->seePageIs('/contract/'.$this->unsigned_individual_contract->id)
            ->see('Nemate ovlašćenje za ovu akciju!');
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
