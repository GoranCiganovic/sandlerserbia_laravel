<?php

use App\Contract;
use App\ContractParticipant;
use App\Participant;
use App\Payment;
use App\Invoice;
use App\Legal;
use App\Individual;
use App\Client;

class ParticipantTest extends TestCase
{
    /**
     * Participant
     *
     * @var App\Participant
     */
    protected $participant;

    /**
     * Creates Participant
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(Participant::first())) {
            $participant_id = factory(Participant::class)->create(['dd_date' => date('Y-m-d')])->id;
            factory(App\ContractParticipant::class)->create([
                'contract_id' => factory(Contract::class, 'unsigned_legal')->create(['participants' => 1])->id,
                'participant_id' => $participant_id
            ]);
            factory(App\ContractParticipant::class)->create([
                'contract_id' => factory(Contract::class, 'unsigned_legal')->create(['participants' => 1])->id,
                'participant_id' => $participant_id
            ]);
        }
        $this->participant = Participant::first();
    }

    /**
     * Test If Participant Object Is An Instance of Participant Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_participant()
    {
        $this->assertInstanceOf('App\Participant', $this->participant);
    }

    /**
     * Test Participant Belgons To Many Contracts
     *
     * @test
     * @return void
    */
    public function participant_belongs_to_many_contracts()
    {
        $this->assertEquals(
            ContractParticipant::where('participant_id', $this->participant->id)->count(),
            Contract::count()
        );
    }

    /**
     * Test Participant Has One Disc Devine With Foreign Key Client Id
     *
     * @test
     * @return void
     */
    public function participant_has_one_disc_devine()
    {
        $this->assertEquals($this->participant->disc_devine(), $this->participant->hasOne('App\DiscDevine', 'participant_id'));
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
