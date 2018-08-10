<?php

use App\ClientStatus;

class ClientStatusTest extends TestCase
{
    /**
     * ClientStatus object
     *
     * @var App\ClientStatus
     */
    protected static $client_status;

    /**
     * Set ClientStatus
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        self::$client_status = ClientStatus::first();
    }

     /**
     * Test If ClientStatus Object Is An Instance of ClientStatus Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_clientstatus()
    {
        $this->assertInstanceOf('App\ClientStatus', self::$client_status);
    }

    /**
     * Test If ClientStatuses Table Returns 6 Records
     *
     * @test
     * @return void
     */
    public function if_clientstatuses_table_returns_6_records()
    {
        $this->assertEquals(6, ClientStatus::count());
    }

    /**
     * Test If ClientStatus 1 Is Not Contacted Status
     *
     * @test
     * @return void
     */
    public function if_clientstatus_1_is_not_contacted_status()
    {
        $this->assertEquals('Nije kontaktiran', ClientStatus::find(1)->local_name);
        $this->assertEquals('fa-phone-square', ClientStatus::find(1)->local_icon);
        $this->assertEquals('Suspect', ClientStatus::find(1)->global_name);
        $this->assertEquals('fa-star-o', ClientStatus::find(1)->global_icon);
        $this->assertEquals('text-white', ClientStatus::find(1)->text_color);
    }

    /**
     * Test If ClientStatus 2 Is Disqualified Status
     *
     * @test
     * @return void
     */
    public function if_clientstatus_2_is_disqualified_status()
    {
        $this->assertEquals('Diskvalifikovan', ClientStatus::find(2)->local_name);
        $this->assertEquals('fa-ban', ClientStatus::find(2)->local_icon);
        $this->assertEquals('Suspect', ClientStatus::find(2)->global_name);
        $this->assertEquals('fa-star-o', ClientStatus::find(2)->global_icon);
        $this->assertEquals('text-danger', ClientStatus::find(2)->text_color);
    }

    /**
     * Test If ClientStatus 3 Is Accept Meeting Status
     *
     * @test
     * @return void
     */
    public function if_clientstatus_3_is_accept_meeting_status()
    {
        $this->assertEquals('Prihvatio sastanak', ClientStatus::find(3)->local_name);
        $this->assertEquals('fa-handshake-o', ClientStatus::find(3)->local_icon);
        $this->assertEquals('Prospect', ClientStatus::find(3)->global_name);
        $this->assertEquals('fa-star-half-o', ClientStatus::find(3)->global_icon);
        $this->assertEquals('text-success', ClientStatus::find(3)->text_color);
    }

    /**
     * Test If ClientStatus 4 Is JPB Status
     *
     * @test
     * @return void
     */
    public function if_clientstatus_4_is_jpb_status()
    {
        $this->assertEquals('JPB', ClientStatus::find(4)->local_name);
        $this->assertEquals('fa-thumbs-o-up', ClientStatus::find(4)->local_icon);
        $this->assertEquals('Prospect', ClientStatus::find(4)->global_name);
        $this->assertEquals('fa-star-half-o', ClientStatus::find(4)->global_icon);
        $this->assertEquals('text-info', ClientStatus::find(4)->text_color);
    }

    /**
     * Test If ClientStatus 5 Is Inactive Status
     *
     * @test
     * @return void
     */
    public function if_clientstatus_5_is_inactive_status()
    {
        $this->assertEquals('Neaktivan', ClientStatus::find(5)->local_name);
        $this->assertEquals('fa-toggle-off', ClientStatus::find(5)->local_icon);
        $this->assertEquals('Client', ClientStatus::find(5)->global_name);
        $this->assertEquals('fa-star', ClientStatus::find(5)->global_icon);
        $this->assertEquals('text-muted', ClientStatus::find(5)->text_color);
    }

    /**
     * Test If ClientStatus 6 Is Active Status
     *
     * @test
     * @return void
     */
    public function if_clientstatus_6_is_active_status()
    {
        $this->assertEquals('Aktivan', ClientStatus::find(6)->local_name);
        $this->assertEquals('fa-toggle-on', ClientStatus::find(6)->local_icon);
        $this->assertEquals('Client', ClientStatus::find(6)->global_name);
        $this->assertEquals('fa-star', ClientStatus::find(6)->global_icon);
        $this->assertEquals('text-primary', ClientStatus::find(6)->text_color);
    }

     /**
     * Test ClientStatus Has One Legal With Foreign Key Client Status Id
     *
     * @test
     * @return void
     */
    public function clientstatus_has_one_legal_with_foreign_key_client_status_id()
    {
        $this->assertEquals(self::$client_status->legal(), self::$client_status->hasOne('App\Legal', 'client_status_id'));
    }

     /**
     * Test ClientStatus Has One Individual With Foreign Key Client Status Id
     *
     * @test
     * @return void
     */
    public function clientstatus_has_one_individual_with_foreign_key_client_status_id()
    {
        $this->assertEquals(self::$client_status->individual(), self::$client_status->hasOne('App\Individual', 'client_status_id'));
    }

    /**
     * Test if Method get_client_status_by_client_status_id Returns Client Status By Passed Client Status Id
     *
     * @test
     * @return void
     */
    public function get_client_status_by_client_status_id_returns_client_status_by_passed_client_status_id()
    {
        $this->assertEquals(
            (new ClientStatus)->get_client_status_by_client_status_id(self::$client_status->client_status_id),
            ClientStatus::select('local_name', 'local_icon', 'global_name', 'global_icon')
                        ->where('client_statuses.id', self::$client_status->client_status_id)
                        ->first()
        );
    }
}
