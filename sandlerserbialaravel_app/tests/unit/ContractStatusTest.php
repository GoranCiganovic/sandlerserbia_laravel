<?php

use App\ContractStatus;

class ContractStatusTest extends TestCase
{
    /**
     * ContractStatus object
     *
     * @var App\ContractStatus
     */
    protected static $contract_status;

    /**
     * Set ContractStatus
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        self::$contract_status = ContractStatus::first();
    }

     /**
     * Test If ContractStatus Object Is An Instance of ContractStatus Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_contract_status()
    {
        $this->assertInstanceOf('App\ContractStatus', self::$contract_status);
    }

     /**
     * Test If ContractStatus Table Returns 4 Records
     *
     * @test
     * @return void
     */
    public function if_contract_statuses_table_returns_4_records()
    {
        $this->assertEquals(4, ContractStatus::count());
    }

    /**
     * Test If ContractStatus 1 Is Unsigned Status
     *
     * @test
     * @return void
     */
    public function if_contractstatus_1_is_unsigned_status()
    {
        $this->assertEquals('Nepotpisan', ContractStatus::find(1)->name);
        $this->assertEquals('fa-pencil-square-o', ContractStatus::find(1)->icon);
        $this->assertEquals('default', ContractStatus::find(1)->color);
    }

    /**
     * Test If ContractStatus 2 Is In Progress Status
     *
     * @test
     * @return void
     */
    public function if_contractstatus_2_is_in_progress_status()
    {
        $this->assertEquals('U toku', ContractStatus::find(2)->name);
        $this->assertEquals('fa-star', ContractStatus::find(2)->icon);
        $this->assertEquals('info', ContractStatus::find(2)->color);
    }

    /**
     * Test If ContractStatus 3 Is Finished Status
     *
     * @test
     * @return void
     */
    public function if_contractstatus_3_is_finished_status()
    {
        $this->assertEquals('Ispunjen', ContractStatus::find(3)->name);
        $this->assertEquals('fa-star-o', ContractStatus::find(3)->icon);
        $this->assertEquals('success', ContractStatus::find(3)->color);
    }

    /**
     * Test If ContractStatus 4 Is Broken Status
     *
     * @test
     * @return void
     */
    public function if_contractstatus_4_is_broken_status()
    {
        $this->assertEquals('Raskinut', ContractStatus::find(4)->name);
        $this->assertEquals('fa-ban', ContractStatus::find(4)->icon);
        $this->assertEquals('danger', ContractStatus::find(4)->color);
    }

     /**
     * Test ContractStatus Has One Contract With Foreign Key Contract Status Id
     *
     * @test
     * @return void
     */
    public function contractstatus_has_one_contract_with_foreign_key_contract_status_id()
    {
        $this->assertEquals(self::$contract_status->contract(), self::$contract_status->hasOne('App\Contract', 'contract_status_id'));
    }
}
