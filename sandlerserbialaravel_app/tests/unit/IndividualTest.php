<?php

use App\Client;
use App\Individual;
use App\Legal;

class IndividualTest extends TestCase
{
    /**
     * Individual object
     *
     * @var sApp\Individual
     */
    protected static $individual;

    /**
     * Creates Individual
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(Individual::first())) {
            factory(Individual::class)->create();
        }
        self::$individual = Individual::first();
    }

    /**
     * Test If Individual Object Is An Instance of Individual Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_individual()
    {
        $this->assertInstanceOf('App\Individual', self::$individual);
    }

    /**
     * Test Individual Belongs To Client
     *
     * @test
     * @return void
    */
    public function individual_belongs_to_client()
    {
        $this->assertEquals(self::$individual->client->id, self::$individual->client_id);
    }

    /**
     * Test Individual Belongs To ClientStatus
     *
     * @test
     * @return void
    */
    public function individual_belongs_to_client_status()
    {
        $this->assertEquals(self::$individual->client_status->id, self::$individual->client_status_id);
    }
 
     /**
     * Test if Method get_individuals_meeting_date_range Meeting Date For The Passed Date Range
     *
     * @test
     * @return void
     */
    public function get_individuals_meeting_date_range_returns_meeting_date_for_the_passed_date_range()
    {
        $from = '2017-02-01';
        $until = '2018-02-01';
        $this->assertEquals(
            self::$individual->get_individuals_meeting_date_range($from, $until),
            Individual::select(
                'client_id',
                DB::raw('CONCAT(first_name," ", last_name) AS name'),
                DB::raw('DATE_FORMAT(meeting_date, "%W, %e. %M %Y. u %H:%i") as meeting_date')
            )
                    ->whereBetween('meeting_date', [$from, $until])
                    ->get()
        );
    }
  
    /**
     * Test Truncate Legal, Individual And CLient Table
     *
     * @test
     * @return void
   */
    public function truncate_legal_individual_and_client_table()
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
