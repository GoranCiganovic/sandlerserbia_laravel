<?php

use App\Rate;

class RateTest extends TestCase
{
    /**
     * Rate object
     *
     * @var App\Rate
     */
    protected static $rate;

    /**
     * Set Rate
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        self::$rate = Rate::first();
    }

    /**
     * Test If Rate Object Is An Instance of Rate Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_rate()
    {
        $this->assertInstanceOf('App\Rate', self::$rate);
    }

    /**
     * Test If Rates Table Returns 1 Record
     *
     * @test
     * @return void
     */
    public function if_rates_table_returns_1_record()
    {
        $this->assertEquals(1, Rate::count());
    }

    /**
     * Test If Rate First Record Is Rate Record
     *
     * @test
     * @return void
     */
    public function if_rate_first_record_is_rate_record()
    {
        $this->assertEquals(1, Rate::find(1)->id);
    }

    /**
     * Test if Method get_rate Returns First Row From Rate Table
     *
     * @test
     * @return void
     */
    public function get_rate_returns_first_row_in_rate_table()
    {
        $this->assertEquals((new Rate)->get_rate()->id, Rate::first()->id);
    }

    /**
     * Test if Method get_sandler_percent Returns Sandler Column Value From Rate Object
     *
     * @test
     * @return void
     */
    public function get_sandler_percent_returns_sander_column_value_from_rate_object()
    {
        $this->assertEquals((new Rate)->get_sandler_percent(), Rate::first()->sandler);
    }

    /**
     * Test if Method get_sandler_paying_day Returns Sandler Paying Day Column Value From Rate Object
     *
     * @test
     * @return void
     */
    public function get_sandler_paying_day_returns_sander_paying_day_value_column_from_rate_object()
    {
        $this->assertEquals((new Rate)->get_sandler_paying_day(), Rate::first()->sandler_paying_day);
    }

    /**
     * Test if Method get_pdv_percent Returns Pdv Column Value From Rate Object
     *
     * @test
     * @return void
     */
    public function get_pdv_percent_returns_pdv_column_value_from_rate_object()
    {
        $this->assertEquals((new Rate)->get_pdv_percent(), Rate::first()->pdv);
    }

    /**
     * Test if Method get_pdv_percent_by_legal_status Returns Pdv Value From Rate Object For Status Legal
     *
     * @test
     * @return void
     */
    public function get_pdv_percent_by_legal_status_returns_pdv_column_value_from_rate_object_for_status_legal()
    {
        $this->assertEquals((new Rate)->get_pdv_percent_by_legal_status(1), Rate::first()->pdv);
        $this->assertEquals((new Rate)->get_pdv_percent_by_legal_status(1), (new Rate)->get_pdv_percent());
    }

    /**
     * Test if Method get_pdv_percent_by_legal_status Returns Pdv Value From Rate Object For Status Individual
     *
     * @test
     * @return void
     */
    public function get_pdv_percent_by_legal_status_returns_pdv_column_value_from_rate_object_for_status_individual()
    {
        $this->assertEquals((new Rate)->get_pdv_percent_by_legal_status(2), '0.00');
    }

    /**
     * Test if Method get_pdv_paying_day Returns Pdv Paying Day Column Value From Rate Object
     *
     * @test
     * @return void
     */
    public function get_pdv_paying_day_returns_pdv_paying_day_value_column_from_rate_object()
    {
        $this->assertEquals((new Rate)->get_pdv_paying_day(), Rate::first()->pdv_paying_day);
    }

    /**
     * Test if Method get_ppo_percent Returns Ppo Column Value From Rate Object
     *
     * @test
     * @return void
     */
    public function get_ppo_percent_returns_ppo_column_value_from_rate_object()
    {
        $this->assertEquals((new Rate)->get_ppo_percent(), Rate::first()->ppo);
    }

    /**
     * Test if Method get_disc Returns Disc Column Value From Rate Object
     *
     * @test
     * @return void
     */
    public function get_disc_returns_disc_column_value_from_rate_object()
    {
        $this->assertEquals((new Rate)->get_disc(), Rate::first()->disc);
    }

    /**
     * Test if Method get_devine Returns Devine Column Value From Rate Object
     *
     * @test
     * @return void
     */
    public function get_devine_returns_devine_column_value_from_rate_object()
    {
        $this->assertEquals((new Rate)->get_devine(), Rate::first()->devine);
    }

    /**
     * Test if Method get_disc_devine Returns Disc Devine Column Value From Rate Object
     *
     * @test
     * @return void
     */
    public function get_disc_devine_returns_disc_devine_column_value_from_rate_object()
    {
        $this->assertEquals((new Rate)->get_disc_devine(), Rate::first()->disc_devine);
    }

    /**
     * Test if Method get_dd_paying_day Returns Disc Devine Paying Day Column Value From Rate Object
     *
     * @test
     * @return void
     */
    public function get_dd_paying_day_returns_dd_paying_day_value_column_from_rate_object()
    {
        $this->assertEquals((new Rate)->get_dd_paying_day(), Rate::first()->dd_paying_day);
    }
}
