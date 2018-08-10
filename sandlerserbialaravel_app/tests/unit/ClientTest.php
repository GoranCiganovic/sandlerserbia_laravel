<?php

use App\Client;

use App\Legal;
use App\Individual;

class ClientTest extends TestCase
{

    /**
     * Client object
     *
     * @var App\Client
     */
    protected static $client;

     /**
     * Legal object
     *
     * @var \App\Legal
     */
    protected static $legal;

     /**
     * Individual object
     *
     * @var \App\Individual
     */
    protected static $individual;

    /**
     * Creates Client
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(Legal::first())) {
            factory(Legal::class)->create();
        }
        if (is_null(Individual::first())) {
            factory(Individual::class)->create();
        }
        self::$client = Client::first();
        self::$legal = Legal::first();
        self::$individual = Individual::first();
    }

    /**
     * Test If Client Object Is An Instance of Client Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_client()
    {
        $this->assertInstanceOf('App\Client', self::$client);
    }

    /**
     * Test Number OF CLients Must Be Equal To Number of Legals And Individauls
     *
     * @test
     * @return void
    */
    public function number_of_clients_must_be_equal_to_number_of_legals_and_individuals()
    {
        $this->assertEquals(Client::count(), (Legal::count())+(Individual::count()));
    }

    /**
     * Test Client Belongs To LegalStatus
     *
     * @test
     * @return void
    */
    public function client_belongs_to_legal_status()
    {
        $this->assertEquals(self::$client->legal_status->id, self::$client->legal_status_id);
    }


     /**
     * Test Client Has One Legal With Foreign Key Client Id
     *
     * @test
     * @return void
     */
    public function client_has_one_legal_with_foreign_key_client_id()
    {
        $this->assertEquals(self::$client->legal(), self::$client->hasOne('App\Legal', 'client_id'));
    }

     /**
     * Test Client Has One Individual With Foreign Key Client Id
     *
     * @test
     * @return void
     */
    public function client_has_one_individual_with_foreign_key_client_id()
    {
        $this->assertEquals(self::$client->individual(), self::$client->hasOne('App\Individual', 'client_id'));
    }

     /**
     * Test Client Has Many Contracts With Foreign Key Client Id
     *
     * @test
     * @return void
     */
    public function client_has_many_contracts()
    {
        $this->assertEquals(self::$client->contract(), self::$client->hasMany('App\Contract', 'client_id'));
    }

    /**
     * Test if Method count_accept_meeting_clients Returns Number Of Clients With Accept Meeting Status
     *
     * @test
     * @return void
     */
    public function count_accept_meeting_clients_returns_number_of_clients_with_accept_meeting_status()
    {
        $this->assertEquals(
            (new Client)->count_accept_meeting_clients(),
            Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 3)
            ->orWhere('individuals.client_status_id', 3)
            ->count()
        );
    }

     /**
     * Test if Method count_jpb_clients Returns Number Of Clients With JPB Status
     *
     * @test
     * @return void
     */
    public function count_jpb_clients_returns_number_of_clients_with_jpb_status()
    {
        $this->assertEquals(
            (new Client)->count_jpb_clients(),
            Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 4)
            ->orWhere('individuals.client_status_id', 4)
            ->count()
        );
    }

     /**
     * Test if Method get_client Returns Legal When Passsing Client With Legal Status Id 1
     *
     * @test
     * @return void
     */
    public function get_client_returns_legal_when_passing_client_with_legal_status_1()
    {
        $legal_client = Client::where('legal_status_id', 1)->first();
        $this->assertEquals((new Client)->get_client($legal_client), self::$legal);
    }

     /**
     * Test if Method get_client Returns Individual When Passsing Client With Legal Status Id 2
     *
     * @test
     * @return void
     */
    public function get_client_returns_individual_when_passing_client_with_legal_status_2()
    {
        $individual_client = Client::where('legal_status_id', 2)->first();
        $this->assertEquals((new Client)->get_client($individual_client), self::$individual);
    }

     /**
     * Test if Method get_client Returns Client Based On Passed Client Id
     *
     * @test
     * @return void
     */
    public function get_client_by_client_id_returns_client_based_on_passed_client_id()
    {
        $this->assertEquals((new Client)->get_client_by_client_id(self::$client->id), Client::find(self::$client->id));
    }

     /**
     * Test if Method set_client_status Updates Legal Client Status Based On Passed Status Id
     *
     * @test
     * @return void
     */
    public function set_client_status_updates_legal_client_status_based_on_passed_status_id()
    {
        $legal_client = Legal::first();
        $status_id = rand(1, 6);
        $update = (new Client)->set_client_status($legal_client->client, $status_id);
        $this->assertTrue($update);
        $this->assertEquals($status_id, Legal::find($legal_client->id)->client_status_id);
    }

     /**
     * Test if Method set_client_status Updates Individual Client Status Based On Passed Status Id
     *
     * @test
     * @return void
     */
    public function set_client_status_updates_individual_client_status_based_on_passed_status_id()
    {
        $individual_client = Individual::first();
        $status_id = rand(1, 6);
        $update = (new Client)->set_client_status($individual_client->client, $status_id);
        $this->assertTrue($update);
        $this->assertEquals($status_id, Individual::find($individual_client->id)->client_status_id);
    }

     /**
     * Test if Method set_closing_date Updates Legal Client Closing Date
     *
     * @test
     * @return void
     */
    public function set_closing_date_updates_legal_client_closing_date()
    {
        $legal_client = Legal::first();
        $closing_date = date('Y-m-d');
        $update = (new Client)->set_closing_date($legal_client);
        $this->assertTrue($update);
        $this->assertEquals($closing_date, Legal::find($legal_client->id)->closing_date);
    }

    /**
     * Test if Method set_closing_date Updates Individual Client Closing Date
     *
     * @test
     * @return void
     */
    public function set_closing_date_updates_individual_client_closing_date()
    {
        $individual_client = Individual::first();
        $closing_date = date('Y-m-d');
        $update = (new Client)->set_closing_date($individual_client);
        $this->assertTrue($update);
        $this->assertEquals($closing_date, Individual::find($individual_client->id)->closing_date);
    }

    /**
     * Test if Method search_input_clients_pagination Returns Clients From Input Search
     *
     * @test
     * @return void
     */
    public function search_input_clients_pagination_returns_clients_from_input_search()
    {
        $input_search = self::$legal->long_name;
        $legal_status_array = [1,2];
        $legal_name = 'long_name';
        $individual_first_name = 'first_name';
        $individual_last_name = 'last_name';
        $order_by = 'ASC';
        $pagination = 10;
        $this->assertEquals(
            (new Client)->search_input_clients_pagination($input_search, $legal_status_array, $legal_name, $individual_first_name, $individual_last_name, $order_by, $pagination),
            Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->leftJoin('legal_statuses', 'clients.legal_status_id', '=', 'legal_statuses.id')
            ->select(
                'clients.id as id',
                'legals.id as legal_id',
                'legals.long_name as legal_name',
                DB::raw('CONCAT(first_name," ", last_name) AS individual_name'),
                'legal_statuses.icon as legal_icon'
            )
            ->where('legals.long_name', 'LIKE', "$input_search%")
            ->whereIn('clients.legal_status_id', $legal_status_array)
            ->orderByRaw("$legal_name $order_by")
            ->orWhere('individuals.first_name', 'LIKE', "$input_search%")
            ->whereIn('clients.legal_status_id', $legal_status_array)
            ->orderByRaw("$individual_first_name $order_by")
            ->orWhere('individuals.last_name', 'LIKE', "$input_search%")
            ->whereIn('clients.legal_status_id', $legal_status_array)
            ->orderByRaw("$individual_last_name $order_by")
            ->paginate($pagination)
        );
    }

    /**
     * Test if Method search_clients_by_client_status_pagination Returns Clients By Client Status
     *
     * @test
     * @return void
     */
    public function search_clients_by_client_status_pagination_returns_clients_by_client_status()
    {
        $search = self::$individual->last_name;
        $client_status = 1;
        $legal_status_array = [1,2];
        $legal_name = 'long_name';
        $individual_first_name = 'first_name';
        $individual_last_name = 'last_name';
        $order_by = 'ASC';
        $pagination = 10;
        $this->assertEquals(
            (new Client)->search_clients_by_client_status_pagination($search, $client_status, $legal_status_array, $legal_name, $individual_first_name, $individual_last_name, $order_by, $pagination),
            Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->leftJoin('legal_statuses', 'clients.legal_status_id', '=', 'legal_statuses.id')
            ->select(
                'clients.id as id',
                'legals.id as legal_id',
                'legals.long_name as legal_name',
                'individuals.id as individual_id',
                DB::raw('CONCAT(first_name," ", last_name) AS individual_name'),
                'legal_statuses.icon as legal_icon'
            )
            ->where('legals.long_name', 'LIKE', "$search%")
            ->where('legals.client_status_id', '=', "$client_status")
            ->whereIn('clients.legal_status_id', $legal_status_array)
            ->orderByRaw("$legal_name $order_by")
            ->orWhere('individuals.first_name', 'LIKE', "$search%")
            ->where('individuals.client_status_id', '=', "$client_status")
            ->whereIn('clients.legal_status_id', $legal_status_array)
            ->orderByRaw("$individual_first_name $order_by")
            ->orWhere('individuals.last_name', 'LIKE', "$search%")
            ->where('individuals.client_status_id', '=', "$client_status}")
            ->whereIn('clients.legal_status_id', $legal_status_array)
            ->orderByRaw("$individual_last_name $order_by")
            ->paginate($pagination)
        );
    }

    /**
     * Test Truncate Legal, Individual And CLient Table
     *
     * @test
     * @return void
     */
    public function turncate_legal_individual_and_client_table()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Legal::truncate();
        Individual::truncate();
        Client::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->assertNull(Legal::first());
        $this->assertNull(Individual::first());
        $this->assertNull(Client::first());
    }
}
