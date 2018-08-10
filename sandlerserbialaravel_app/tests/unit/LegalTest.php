<?php

use App\Client;
use App\Legal;
use App\Individual;

class LegalTest extends TestCase
{
    /**
     * Legal object
     *
     * @var App\Legal
     */
    protected static $legal;

    /**
     * Creates Legal
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(Legal::first())) {
            factory(Legal::class)->create();
        }
        self::$legal = Legal::first();
    }

    /**
     * Test If Legal Object Is An Instance of Legal Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_legal()
    {
        $this->assertInstanceOf('App\Legal', self::$legal);
    }

    /**
     * Test Legal Belgons To Client
     *
     * @test
     * @return void
    */
    public function legal_belongs_to_client()
    {
        $this->assertEquals(self::$legal->client->id, self::$legal->client_id);
    }

    /**
     * Test Legal Belongs To ClientStatus
     *
     * @test
     * @return void
    */
    public function legal_belongs_to_client_status()
    {
        $this->assertEquals(self::$legal->client_status->id, self::$legal->client_status_id);
    }
 
     /**
     * Test Legal Belongs To CompanySize
     *
     * @test
     * @return void
     */
    public function legal_belongs_to_company_size()
    {
        $this->assertEquals(self::$legal->company_size->id, self::$legal->company_size_id);
    }

     /**
     * Test if Method get_legals_meeting_date_range Meeting Date For The Passed Date Range
     *
     * @test
     * @return void
     */
    public function get_legals_meeting_date_range_returns_meeting_date_for_the_passed_date_range()
    {
        $from = '2017-02-01';
        $until = '2018-02-01';
        $this->assertEquals(
            self::$legal->get_legals_meeting_date_range($from, $until),
            Legal::select(
                'long_name as name',
                DB::raw('DATE_FORMAT(meeting_date, "%W, %e. %M %Y. u %H:%i") as meeting_date'),
                'client_id'
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
