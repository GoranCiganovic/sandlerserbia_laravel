<?php

use App\LegalStatus;

class LegalStatusTest extends TestCase
{
    /**
     * LegalStatus object
     *
     * @var App\LegalStatus
     */
    protected static $legal_status;

    /**
     * Set LegalStatus
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        self::$legal_status = LegalStatus::first();
    }

     /**
     * Test If LegalStatus Object Is An Instance of LegalStatus Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_legalstatus()
    {
        $this->assertInstanceOf('App\LegalStatus', self::$legal_status);
    }

    /**
     * Test If LegalStatuses Table Returns 2 Records
     *
     * @test
     * @return void
     */
    public function if_legalstatuses_table_returns_2_records()
    {
        $this->assertEquals(2, LegalStatus::count());
    }

     /**
     * Test If LegalStatus First Record Is Legal Status
     *
     * @test
     * @return void
     */
    public function if_legalstatus_first_record_is_legal_status()
    {
        $this->assertEquals('Pravno lice', LegalStatus::find(1)->name);
        $this->assertEquals('fa-building-o', LegalStatus::find(1)->icon);
    }

     /**
     * Test If LegalStatus Second Record Is Individual Status
     *
     * @test
     * @return void
     */
    public function if_legalstatus_second_record_is_individual_status()
    {
        $this->assertEquals('Fizičko lice', LegalStatus::find(2)->name);
        $this->assertEquals('fa-user', LegalStatus::find(2)->icon);
    }

     /**
     * Test ClientStatus Has One Client With Foreign Key Legal Status Id
     *
     * @test
     * @return void
     */
    public function clientstatus_has_one_client_with_foreign_key_legal_status_id()
    {
        $this->assertEquals(self::$legal_status->client(), self::$legal_status->hasOne('App\Client', 'legal_status_id'));
    }
}
