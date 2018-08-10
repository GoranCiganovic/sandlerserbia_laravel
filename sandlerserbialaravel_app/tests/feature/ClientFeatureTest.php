<?php

use App\Client;
use App\Legal;
use App\Individual;

class ClientFeatureTest extends TestCase
{

    /**
     * Legal Object
     *
     * @var App\Legal
     */
    protected $legal;

    /**
     * Individual Object
     *
     * @var App\Individual
     */
    protected $individual;

    /**
     * Legals Not Clients (With Status Not Contacted, Disqualified, Acept Meeting And JPB)
     *
     * @var App\Legal
     */
    protected $legals_not_clients;

    /**
     * Individuals Not Clients (With Status Not Contacted, Disqualified, Acept Meeting And JPB)
     *
     * @var App\Individual
     */
    protected $individuals_not_clients;

    /**
     * Legals Can Not Be Deleted (With All Statuses But Not Contacted)
     *
     * @var App\Legal
     */
    protected $legals_cant_be_deleted;

    /**
     * Individuals Can Not Be Deleted (With All Statuses But Not Contacted)
     *
     * @var App\Individual
     */
    protected $individuals_cant_be_deleted;

    /**
     * Legals Clients (With Status Inactive And Active)
     *
     * @var App\Legal
     */
    protected $legals_clients;

    /**
     * Individuals  Clients (With Status Inactive And Active)
     *
     * @var App\Individual
     */
    protected $individuals_clients;

     /**
     * Legal Not Contacted
     *
     * @var App\Legal
     */
    protected $legal_uncontacted;

     /**
     * Individual Not Contacted
     *
     * @var App\Individual
     */
    protected $individual_uncontacted;

    /**
     * Creates Client, Legal, Individual
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(Client::first())) {
            factory(Legal::class, 'uncontacted')->create();
            factory(Legal::class, 'disqualified_without_meeting')->create();
            factory(Legal::class, 'disqualified_after_meeting')->create();
            factory(Legal::class, 'accept_meeting')->create();
            factory(Legal::class, 'jpb')->create();
            factory(Legal::class, 'inactive')->create();
            factory(Legal::class, 'active')->create();
            factory(Individual::class, 'uncontacted')->create();
            factory(Individual::class, 'disqualified_without_meeting')->create();
            factory(Individual::class, 'disqualified_after_meeting')->create();
            factory(Individual::class, 'accept_meeting')->create();
            factory(Individual::class, 'jpb')->create();
            factory(Individual::class, 'inactive')->create();
            factory(Individual::class, 'active')->create();
        }
        

        if (is_null($this->legals_not_clients)) {
            $this->legals_not_clients = Legal::whereIn('client_status_id', [1,2,3,4])->get();
        }
        if (is_null($this->individuals_not_clients)) {
            $this->individuals_not_clients = Individual::whereIn('client_status_id', [1,2,3,4])->get();
        }
        if (is_null($this->legals_clients)) {
            $this->legals_clients = Legal::whereIn('client_status_id', [5,6])->get();
        }
        if (is_null($this->individuals_clients)) {
            $this->individuals_clients = Individual::whereIn('client_status_id', [5,6])->get();
        }
        if (is_null($this->legals_cant_be_deleted)) {
            $this->legals_cant_be_deleted = Legal::whereIn('client_status_id', [2,3,4,5,6])->get();
        }
        if (is_null($this->individuals_cant_be_deleted)) {
            $this->individuals_cant_be_deleted = Individual::whereIn('client_status_id', [2,3,4,5,6])->get();
        }

        if (is_null($this->legal)) {
            $this->legal = Legal::inRandomOrder()->first();
        }
        if (is_null($this->individual)) {
            $this->individual = Individual::inRandomOrder()->first();
        }

        if (is_null(Legal::where('client_status_id', 1)->first())) {
             factory(Legal::class, 'uncontacted')->create();
        }

        if (is_null($this->legal_uncontacted)) {
            $this->legal_uncontacted = Legal::where('client_status_id', 1)->first();
        }
        
        if (is_null(Individual::where('client_status_id', 1)->first())) {
             factory(Individual::class, 'uncontacted')->create();
        }

        if (is_null($this->individual_uncontacted)) {
            $this->individual_uncontacted = Individual::where('client_status_id', 1)->first();
        }
    }

    /**
     * Test Admin Can See Legal Client Profile (ClientsController@show)
     *
     * @test
     * @return void
    */
    public function admin_can_see_legal_client_profile()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->visit('/client/' . $this->legal->client_id)
            ->seePageIs('/client/' . $this->legal->client_id)
            ->see($this->legal->long_name)
            ->see('Pravno lice')
            ->see('IZMENI PROFIL');
    }

    /**
     * Test Http Get Request Show Legal Client Profile To Admin (ClientsController@show)
     *
     * @test
     * @return void
    */
    public function http_get_request_show_legal_client_profile_to_admin()
    {
        $this->actingAs(self::$admin)
           ->get('/client/' . $this->legal->client_id)
            ->assertResponseStatus(200)
            ->assertViewHas(['clientID', 'legal_status', 'legal', 'client_status', 'contracts', 'proinvoices', 'invoices']);
    }

    /**
     * Test Admin Can See Individual Client Profile (ClientsController@show)
     *
     * @test
     * @return void
    */
    public function admin_can_see_individual_client_profile()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->visit('/client/' . $this->individual->client_id)
            ->seePageIs('/client/' . $this->individual->client_id)
            ->see($this->individual->first_name . ' ' . $this->individual->last_name)
            ->see($this->individual->phone)
            ->see('Fizičko lice')
            ->see('IZMENI PROFIL');
    }

    /**
     * Test Http Get Request Show Individual Client Profile To Admin (ClientsController@show)
     *
     * @test
     * @return void
    */
    public function http_get_request_show_individual_client_profile_to_admin()
    {
        $this->actingAs(self::$admin)
           ->get('/client/' . $this->individual->client_id)
            ->assertResponseStatus(200)
            ->assertViewHas(['clientID', 'legal_status', 'individual', 'client_status', 'contracts', 'proinvoices', 'invoices']);
    }

     /**
     * Test User Can See Legal Client Profile (ClientsController@show)
     *
     * @test
     * @return void
    */
    public function user_can_see_legal_client_profile()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->visit('/client/' . $this->legal->client_id)
            ->seePageIs('/client/' . $this->legal->client_id)
            ->see($this->legal->long_name)
            ->see('Pravno lice')
            ->see('IZMENI PROFIL');
    }

    /**
     * Test Http Get Request Show Legal Client Profile To User (ClientsController@show)
     *
     * @test
     * @return void
    */
    public function http_get_request_show_legal_client_profile_to_user()
    {
        $this->actingAs(self::$user)
           ->get('/client/' . $this->legal->client_id)
            ->assertResponseStatus(200)
            ->assertViewHas(['clientID', 'legal_status', 'legal', 'client_status', 'contracts', 'proinvoices', 'invoices']);
    }

    /**
     * Test User Can See Individual Client Profile (ClientsController@show)
     *
     * @test
     * @return void
    */
    public function user_can_see_individual_client_profile()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->visit('/client/' . $this->individual->client_id)
            ->seePageIs('/client/' . $this->individual->client_id)
            ->see($this->individual->first_name . ' ' . $this->individual->last_name)
            ->see($this->individual->phone)
            ->see('Fizičko lice')
            ->see('IZMENI PROFIL');
    }

    /**
     * Test Http Get Request Show Individual Client Profile To User (ClientsController@show)
     *
     * @test
     * @return void
    */
    public function http_get_request_show_individual_client_profile_to_user()
    {
        $this->actingAs(self::$user)
           ->get('/client/' . $this->individual->client_id)
            ->assertResponseStatus(200)
            ->assertViewHas(['clientID', 'legal_status', 'individual', 'client_status', 'contracts', 'proinvoices', 'invoices']);
    }

    /**
     * Test Admin Can Return From Legal Client Profle Page To Home Page (ClientsController@show)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_legal_client_profile_page_to_home_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->legal->client_id)
            ->see($this->legal->long_name)
            ->click('Početna')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

     /**
     * Test Admin Can Return From Individual Client Profle Page To Home Page (ClientsController@show)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_individual_client_profile_page_to_home_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->individual->client_id)
            ->see($this->individual->first_name . ' ' . $this->individual->last_name)
            ->click('Početna')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

    /**
     * Test User Can Return From Legal Client Profle Page To Home Page (ClientsController@show)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_legal_client_profile_page_to_home_page()
    {
        $this->actingAs(self::$user)
            ->visit('/client/' . $this->legal->client_id)
            ->see($this->legal->long_name)
            ->click('Početna')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

    /**
     * Test User Can Return From Individual Client Profle Page To Home Page (ClientsController@show)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_individual_client_profile_page_to_home_page()
    {
        $this->actingAs(self::$user)
            ->visit('/client/' . $this->individual->client_id)
            ->see($this->individual->first_name . ' ' . $this->individual->last_name)
            ->click('Početna')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

    /**
     * Test Admin Can See The Form For Editing Legal Client Profile (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function admin_can_see_form_for_editing_legal_client_profile()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->legal->client_id)
            ->click('IZMENI PROFIL')
            ->seePageIs('/client/edit/' . $this->legal->client_id)
            ->see('IZMENA PROFIL')
            ->see($this->legal->long_name)
            ->see('POTVRDI');
    }

    /**
     * Test Http Get Request Edit Legal Client Profile As Admin (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_edit_legal_client_profile_as_admin()
    {
        $this->actingAs(self::$admin)
           ->get('/client/edit/' . $this->legal->client_id)
            ->assertResponseStatus(200)
            ->assertViewHas(['clientID', 'legal_status', 'legal', 'client_status', 'company_size', 'company_sizes']);
    }

    /**
     * Test Admin Can See The Form For Editing Individual Client Profile (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function admin_can_see_form_for_editing_individual_client_profile()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->individual->client_id)
            ->click('IZMENI PROFIL')
            ->seePageIs('/client/edit/' . $this->individual->client_id)
            ->see('IZMENA PROFIL')
            ->see($this->individual->first_name . ' ' . $this->individual->last_name)
            ->see('POTVRDI');
    }

    /**
     * Test Http Get Request Edit Individual Client Profile As Admin (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_edit_individual_client_profile_as_admin()
    {
        $this->actingAs(self::$admin)
           ->get('/client/edit/' . $this->individual->client_id)
            ->assertResponseStatus(200)
            ->assertViewHas(['clientID', 'legal_status', 'individual', 'client_status']);
    }

    /**
     * Test User Can See The Form For Editing Legal Client Profile (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function user_can_see_form_for_editing_legal_client_profile()
    {
        $this->actingAs(self::$user)
            ->visit('/client/' . $this->legal->client_id)
            ->click('IZMENI PROFIL')
            ->seePageIs('/client/edit/' . $this->legal->client_id)
            ->see('IZMENA PROFIL')
            ->see($this->legal->long_name)
            ->see('POTVRDI');
    }

    /**
     * Test Http Get Request Edit Legal Client Profile As User (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_edit_legal_client_profile_as_user()
    {
        $this->actingAs(self::$user)
           ->get('/client/edit/' . $this->legal->client_id)
            ->assertResponseStatus(200)
            ->assertViewHas(['clientID', 'legal_status', 'legal', 'client_status', 'company_size', 'company_sizes']);
    }

    /**
     * Test User Can See The Form For Editing Individual Client Profile (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function user_can_see_form_for_editing_individual_client_profile()
    {
        $this->actingAs(self::$user)
            ->visit('/client/' . $this->individual->client_id)
            ->click('IZMENI PROFIL')
            ->seePageIs('/client/edit/' . $this->individual->client_id)
            ->see('IZMENA PROFIL')
            ->see($this->individual->first_name . ' ' . $this->individual->last_name)
            ->see('POTVRDI');
    }

    /**
     * Test Http Get Request Edit Individual Client Profile As User (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_edit_individual_client_profile_as_user()
    {
        $this->actingAs(self::$user)
           ->get('/client/edit/' . $this->individual->client_id)
            ->assertResponseStatus(200)
            ->assertViewHas(['clientID', 'legal_status', 'individual', 'client_status']);
    }

    /**
     * Test Admin Can Change Legal Client Status To Accept Meeting If Current Status Is Not Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function admin_can_change_legal_client_status_to_accept_meeeting_if_client_is_not_active_or_inactive()
    {
        foreach ($this->legals_not_clients as $legal) {
            $this->actingAs(self::$admin)
                ->visit('/client/' . $legal->client_id)
                ->see('PRIHVATIO SASTANAK')
                ->see('JASNA PRECIZNA BUDUĆNOST')
                ->see('DISKVALIFIKOVAN')
                ->click('PRIHVATIO SASTANAK')
                ->seePageIs('/client/' . $legal->client_id)
                ->see('Status je uspešno promenjen.');
        }
    }

    /**
     * Test Http Get Request Can Change Legal Client Status To Accept Meeting As Admin If Current Status Is Not Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_change_legal_client_status_to_accept_meeting_if_client_is_not_active_or_inactive_as_admin()
    {
        foreach ($this->legals_not_clients as $legal) {
            $this->actingAs(self::$admin)
                ->get('/client/change_status/' . $legal->client_id . '/' . $am_status = 3)
                ->assertResponseStatus(302)
                ->seeInDatabase('legals', [
                    'id' => $legal->id,
                    'client_status_id' => $am_status,
                    'conversation_date' => date('Y-m-d'),
                    'accept_meeting_date' => date('Y-m-d')
                ])
                ->assertSessionHas('message', 'Status je uspešno promenjen.');
        }
    }

     /**
     * Test Admin Can Change Individual Client Status To Accept Meeting If Current Status Is Not Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function admin_can_change_individual_client_status_to_accept_meeeting_if_client_is_not_active_or_inactive()
    {
        foreach ($this->individuals_not_clients as $individual) {
            $this->actingAs(self::$admin)
                ->visit('/client/' . $individual->client_id)
                ->see('PRIHVATIO SASTANAK')
                ->see('JASNA PRECIZNA BUDUĆNOST')
                ->see('DISKVALIFIKOVAN')
                ->click('PRIHVATIO SASTANAK')
                ->seePageIs('/client/' . $individual->client_id)
                ->see('Status je uspešno promenjen.');
        }
    }

    /**
     * Test Http Get Request Can Change Individual Client Status To Accept Meeting As Admin If Current Status Is Not Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_change_individual_client_status_to_accept_meeting_if_client_is_not_active_or_inactive_as_admin()
    {
        foreach ($this->individuals_not_clients as $individual) {
            $this->actingAs(self::$admin)
                ->get('/client/change_status/' . $individual->client_id . '/' . $am_status = 3)
                ->assertResponseStatus(302)
                ->seeInDatabase('individuals', [
                    'id' => $individual->id,
                    'client_status_id' => $am_status,
                    'conversation_date' => date('Y-m-d'),
                    'accept_meeting_date' => date('Y-m-d')
                ])
                ->assertSessionHas('message', 'Status je uspešno promenjen.');
        }
    }

    /**
     * Test User Can Not Change Legal Client Status To Accept Meeting If Current Status Is Not Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function user_can_not_change_legal_client_status_to_accept_meeeting_if_client_is_not_active_or_inactive()
    {
        foreach ($this->legals_not_clients as $legal) {
            $this->actingAs(self::$user)
                ->visit('/client/' . $legal->client_id)
                ->see('PRIHVATIO SASTANAK')
                ->see('JASNA PRECIZNA BUDUĆNOST')
                ->see('DISKVALIFIKOVAN')
                ->click('PRIHVATIO SASTANAK')
                ->seePageIs('/client/' . $legal->client_id)
                ->see('Nemate ovlašćenje za ovu akciju!');
        }
    }

    /**
     * Test Http Get Request Can Not Change Legal Client Status To Accept Meeting As User If Current Status Is Not Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_not_change_legal_client_status_to_accept_meeting_if_client_is_not_active_or_inactive_as_user()
    {
        foreach ($this->legals_not_clients as $legal) {
            $this->actingAs(self::$user)
                ->get('/client/change_status/' . $legal->client_id . '/' . $am_status = 3)
                ->assertResponseStatus(302)
                ->seeInDatabase('legals', ['id' => $legal->id, 'client_status_id' => $legal->client_status_id])
                ->assertSessionHas('message', 'Nemate ovlašćenje za ovu akciju!');
        }
    }

    /**
     * Test User Can Not Not Change Individual Client Status To Accept Meeting If Current Status Is Not Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function user_can_not_change_individual_client_status_to_accept_meeeting_if_client_is_not_active_or_inactive()
    {
        foreach ($this->individuals_not_clients as $individual) {
            $this->actingAs(self::$user)
                ->visit('/client/' . $individual->client_id)
                ->see('PRIHVATIO SASTANAK')
                ->see('JASNA PRECIZNA BUDUĆNOST')
                ->see('DISKVALIFIKOVAN')
                ->click('PRIHVATIO SASTANAK')
                ->seePageIs('/client/' . $individual->client_id)
                ->see('Nemate ovlašćenje za ovu akciju!');
        }
    }

    /**
     * Test Http Get Request Can Not Change Individual Client Status To Accept Meeting As User If Current Status Is Not Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_not_change_individual_client_status_to_accept_meeting_if_client_is_not_active_or_inactive_as_user()
    {
        foreach ($this->individuals_not_clients as $individual) {
            $this->actingAs(self::$user)
                ->get('/client/change_status/' . $individual->client_id . '/' . $am_status = 3)
                ->assertResponseStatus(302)
                ->seeInDatabase('individuals', ['id' => $individual->id, 'client_status_id' => $individual->client_status_id])
                ->assertSessionHas('message', 'Nemate ovlašćenje za ovu akciju!');
        }
    }

    /**
     * Test Admin Can Change Legal Client Status To JPB If Current Status Is Not Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function admin_can_change_legal_client_status_to_jpb_if_client_is_not_active_or_inactive()
    {
        foreach ($this->legals_not_clients as $legal) {
            $this->actingAs(self::$admin)
                ->visit('/client/' . $legal->client_id)
                ->see('PRIHVATIO SASTANAK')
                ->see('JASNA PRECIZNA BUDUĆNOST')
                ->see('DISKVALIFIKOVAN')
                ->click('JASNA PRECIZNA BUDUĆNOST')
                ->seePageIs('/client/' . $legal->client_id)
                ->see('Status je uspešno promenjen.');
        }
    }

    /**
     * Test Http Get Request Can Change Legal Client Status To JPB As Admin If Current Status Is Not Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_change_legal_client_status_to_jpb_if_client_is_not_active_or_inactive_as_admin()
    {
        foreach ($this->legals_not_clients as $legal) {
            $this->actingAs(self::$admin)
                ->get('/client/change_status/' . $legal->client_id . '/' . $jpb_status = 4)
                ->assertResponseStatus(302)
                ->seeInDatabase('legals', [
                    'id' => $legal->id,
                    'client_status_id' => $jpb_status,
                    'conversation_date' => date('Y-m-d')
                ])
                ->assertSessionHas('message', 'Status je uspešno promenjen.');
        }
    }

    /**
     * Test Admin Can Change Individual Client Status To JPB If Current Status Is Not Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function admin_can_change_individual_client_status_to_jpb_if_client_is_not_active_or_inactive()
    {
        foreach ($this->individuals_not_clients as $individual) {
            $this->actingAs(self::$admin)
                ->visit('/client/' . $individual->client_id)
                ->see('PRIHVATIO SASTANAK')
                ->see('JASNA PRECIZNA BUDUĆNOST')
                ->see('DISKVALIFIKOVAN')
                ->click('JASNA PRECIZNA BUDUĆNOST')
                ->seePageIs('/client/' . $individual->client_id)
                ->see('Status je uspešno promenjen.');
        }
    }

    /**
     * Test Http Get Request Can Change Individual Client Status To JPB As Admin If Current Status Is Not Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_change_individual_client_status_to_jpb_if_client_is_not_active_or_inactive_as_admin()
    {
        foreach ($this->individuals_not_clients as $individual) {
            $this->actingAs(self::$admin)
                ->get('/client/change_status/' . $individual->client_id . '/' . $jpb_status = 4)
                ->assertResponseStatus(302)
                ->seeInDatabase('individuals', [
                    'id' => $individual->id,
                    'client_status_id' => $jpb_status,
                    'conversation_date' => date('Y-m-d')
                ])
                ->assertSessionHas('message', 'Status je uspešno promenjen.');
        }
    }

    /**
     * Test User Can Not Change Legal Client Status To JPB If Current Status Is Not Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function user_can_not_change_legal_client_status_to_jpb_if_client_is_not_active_or_inactive()
    {
        foreach ($this->legals_not_clients as $legal) {
            $this->actingAs(self::$user)
                ->visit('/client/' . $legal->client_id)
                ->see('PRIHVATIO SASTANAK')
                ->see('JASNA PRECIZNA BUDUĆNOST')
                ->see('DISKVALIFIKOVAN')
                ->click('JASNA PRECIZNA BUDUĆNOST')
                ->seePageIs('/client/' . $legal->client_id)
                ->see('Nemate ovlašćenje za ovu akciju!');
        }
    }

    /**
     * Test Http Get Request Can Not Change Legal Client Status To JPB As User If Current Status Is Not Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_not_change_legal_client_status_to_jpb_if_client_is_not_active_or_inactive_as_user()
    {
        foreach ($this->legals_not_clients as $legal) {
            $this->actingAs(self::$user)
                ->get('/client/change_status/' . $legal->client_id . '/' . $jpb_status = 4)
                ->assertResponseStatus(302)
                ->seeInDatabase('legals', ['id' => $legal->id, 'client_status_id' => $legal->client_status_id])
                ->assertSessionHas('message', 'Nemate ovlašćenje za ovu akciju!');
        }
    }

    /**
     * Test User Can Not Not Change Individual Client Status To JPB If Current Status Is Not Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function user_can_not_change_individual_client_status_to_jpb_if_client_is_not_active_or_inactive()
    {
        foreach ($this->individuals_not_clients as $individual) {
            $this->actingAs(self::$user)
                ->visit('/client/' . $individual->client_id)
                ->see('PRIHVATIO SASTANAK')
                ->see('JASNA PRECIZNA BUDUĆNOST')
                ->see('DISKVALIFIKOVAN')
                ->click('JASNA PRECIZNA BUDUĆNOST')
                ->seePageIs('/client/' . $individual->client_id)
                ->see('Nemate ovlašćenje za ovu akciju!');
        }
    }

    /**
     * Test Http Get Request Can Not Change Individual Client Status To JPB As User If Current Status Is Not Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_not_change_individual_client_status_to_jpb_if_client_is_not_active_or_inactive_as_user()
    {
        foreach ($this->individuals_not_clients as $individual) {
            $this->actingAs(self::$user)
                ->get('/client/change_status/' . $individual->client_id . '/' . $jpb_status = 4)
                ->assertResponseStatus(302)
                ->seeInDatabase('individuals', ['id' => $individual->id, 'client_status_id' => $individual->client_status_id])
                ->assertSessionHas('message', 'Nemate ovlašćenje za ovu akciju!');
        }
    }

    /**
     * Test Admin Can Change Legal Client Status To Disqualified If Current Status Is Not Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function admin_can_change_legal_client_status_to_disqualified_if_client_is_not_active_or_inactive()
    {
        foreach ($this->legals_not_clients as $legal) {
            $this->actingAs(self::$admin)
                ->visit('/client/' . $legal->client_id)
                ->see('PRIHVATIO SASTANAK')
                ->see('JASNA PRECIZNA BUDUĆNOST')
                ->see('DISKVALIFIKOVAN')
                ->click('DISKVALIFIKOVAN')
                ->seePageIs('/client/' . $legal->client_id)
                ->see('Status je uspešno promenjen.');
        }
    }

    /**
     * Test Http Get Request Can Change Legal Client Status To Disqualified As Admin If Current Status Is Not Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_change_legal_client_status_to_disqualified_if_client_is_not_active_or_inactive_as_admin()
    {
        foreach ($this->legals_not_clients as $legal) {
            $this->actingAs(self::$admin)
                ->get('/client/change_status/' . $legal->client_id . '/'. $dsq_status = 2)
                ->assertResponseStatus(302)
                ->seeInDatabase('legals', [
                    'id' => $legal->id,
                    'client_status_id' => $dsq_status,
                    'conversation_date' => date('Y-m-d')
                ])
                ->assertSessionHas('message', 'Status je uspešno promenjen.');
        }
    }

    /**
     * Test Admin Can Change Individual Client Status To Disqualified If Current Status Is Not Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function admin_can_change_individual_client_status_to_disqualified_if_client_is_not_active_or_inactive()
    {
        foreach ($this->individuals_not_clients as $individual) {
            $this->actingAs(self::$admin)
                ->visit('/client/' . $individual->client_id)
                ->see('PRIHVATIO SASTANAK')
                ->see('JASNA PRECIZNA BUDUĆNOST')
                ->see('DISKVALIFIKOVAN')
                ->click('DISKVALIFIKOVAN')
                ->seePageIs('/client/' . $individual->client_id)
                ->see('Status je uspešno promenjen.');
        }
    }

    /**
     * Test Http Get Request Can Change Individual Client Status To Disqualified As Admin If Current Status Is Not Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_change_individual_client_status_to_disqualified_if_client_is_not_active_or_inactive_as_admin()
    {
        foreach ($this->individuals_not_clients as $individual) {
            $this->actingAs(self::$admin)
                ->get('/client/change_status/' . $individual->client_id . '/' . $dsq_status = 2)
                ->assertResponseStatus(302)
                ->seeInDatabase('individuals', [
                    'id' => $individual->id,
                    'client_status_id' => $dsq_status,
                    'conversation_date' => date('Y-m-d')
                ])
                ->assertSessionHas('message', 'Status je uspešno promenjen.');
        }
    }

    /**
     * Test User Can Not Change Legal Client Status To Disqualified If Current Status Is Not Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function user_can_not_change_legal_client_status_to_disqualified_if_client_is_not_active_or_inactive()
    {
        foreach ($this->legals_not_clients as $legal) {
            $this->actingAs(self::$user)
                ->visit('/client/' . $legal->client_id)
                ->see('PRIHVATIO SASTANAK')
                ->see('JASNA PRECIZNA BUDUĆNOST')
                ->see('DISKVALIFIKOVAN')
                ->click('DISKVALIFIKOVAN')
                ->seePageIs('/client/' . $legal->client_id)
                ->see('Nemate ovlašćenje za ovu akciju!');
        }
    }

    /**
     * Test Http Get Request Can Not Change Legal Client Status To Disqualified As User If Current Status Is Not Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_not_change_legal_client_status_to_disqualified_if_client_is_not_active_or_inactive_as_user()
    {
        foreach ($this->legals_not_clients as $legal) {
            $this->actingAs(self::$user)
                ->get('/client/change_status/' . $legal->client_id . '/'. $dsq_status = 2)
                ->assertResponseStatus(302)
                ->seeInDatabase('legals', ['id' => $legal->id, 'client_status_id' => $legal->client_status_id])
                ->assertSessionHas('message', 'Nemate ovlašćenje za ovu akciju!');
        }
    }

    /**
     * Test User Can Not Not Change Individual Client Status To Disqualified If Current Status Is Not Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function user_can_not_change_individual_client_status_to_disqualified_if_client_is_not_active_or_inactive()
    {
        foreach ($this->individuals_not_clients as $individual) {
            $this->actingAs(self::$user)
                ->visit('/client/' . $individual->client_id)
                ->see('PRIHVATIO SASTANAK')
                ->see('JASNA PRECIZNA BUDUĆNOST')
                ->see('DISKVALIFIKOVAN')
                ->click('DISKVALIFIKOVAN')
                ->seePageIs('/client/' . $individual->client_id)
                ->see('Nemate ovlašćenje za ovu akciju!');
        }
    }

    /**
     * Test Http Get Request Can Not Change Individual Client Status To Disqualified As User If Current Status Is Not Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_not_change_individual_client_status_to_disqualified_if_client_is_not_active_or_inactive_as_user()
    {
        foreach ($this->individuals_not_clients as $individual) {
            $this->actingAs(self::$user)
                ->get('/client/change_status/' . $individual->client_id . '/' . $dsq_status = 2)
                ->assertResponseStatus(302)
                ->seeInDatabase('individuals', ['id' => $individual->id, 'client_status_id' => $individual->client_status_id])
                ->assertSessionHas('message', 'Nemate ovlašćenje za ovu akciju!');
        }
    }

    /**
     * Test Admin Can Not See Legal Client Statuses For Change If Current Status Is Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function admin_can_not_see_legal_client_statuses_for_change_if_current_status_is_active_or_inactive()
    {
        foreach ($this->legals_clients as $legal) {
            $this->actingAs(self::$admin)
                ->visit('/client/'.$legal->client_id)
                ->dontSee("/client/change_status/" . $legal->client_id . "/3")
                ->dontSee("/client/change_status/" . $legal->client_id . "/4")
                ->dontSee("/client/change_status/" . $legal->client_id . "/2");
        }
    }

    /**
     * Test Http Get Request Can Not Change Legal Client Status As Admin If Current Status Is Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_not_change_legal_client_status_if_current_status_is_active_or_inactive_as_admin()
    {
        foreach ($this->legals_clients as $legal) {
            $this->actingAs(self::$admin)
                ->get('/client/change_status/' . $legal->client_id . '/'. rand(1, 4))
                ->assertResponseStatus(302)
                ->seeInDatabase('legals', ['id' => $legal->id, 'client_status_id' => $legal->client_status_id]);
        }
    }

    /**
     * Test User Can Not See Legal Client Statuses For Change If Current Status Is Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function user_can_not_see_legal_client_statuses_for_change_if_current_status_is_active_or_inactive()
    {
        foreach ($this->legals_clients as $legal) {
            $this->actingAs(self::$user)
                ->visit('/client/' . $legal->client_id)
                ->dontSee("/client/change_status/" . $legal->client_id . "/3")
                ->dontSee("/client/change_status/" . $legal->client_id . "/4")
                ->dontSee("/client/change_status/" . $legal->client_id . "/2");
        }
    }

    /**
     * Test Http Get Request Can Not Change Legal Client Status As User If Current Status Is Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_not_change_legal_client_status_if_current_status_is_active_or_inactive_as_user()
    {
        foreach ($this->legals_clients as $legal) {
            $this->actingAs(self::$user)
                ->get('/client/change_status/' . $legal->client_id . '/'. rand(1, 4))
                ->assertResponseStatus(302)
                ->seeInDatabase('legals', ['id' => $legal->id, 'client_status_id' => $legal->client_status_id]);
        }
    }

    /**
     * Test Admin Can Not See Individual Client Statuses For Change If Current Status Is Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function admin_can_not_see_individual_client_statuses_for_change_if_current_status_is_active_or_inactive()
    {
        foreach ($this->individuals_clients as $individual) {
            $this->actingAs(self::$admin)
                ->visit('/client/' . $individual->client_id)
                ->dontSee("/client/change_status/" . $individual->client_id . "/3")
                ->dontSee("/client/change_status/" . $individual->client_id . "/4")
                ->dontSee("/client/change_status/" . $individual->client_id . "/2");
        }
    }

    /**
     * Test Http Get Request Can Not Change Individual Client Status As Admin If Current Status Is Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_not_change_individual_client_status_if_current_status_is_active_or_inactive_as_admin()
    {
        foreach ($this->individuals_clients as $individual) {
            $this->actingAs(self::$admin)
                ->get('/client/change_status/' . $individual->client_id . '/' . rand(1, 4))
                ->assertResponseStatus(302)
                ->seeInDatabase('individuals', ['id' => $individual->id, 'client_status_id' => $individual->client_status_id]);
        }
    }

    /**
     * Test User Can Not See Individual Client Statuses For Change If Current Status Is Active Or Inactive (ClientsController@change_status)
     *
     * @test
     * @return void
    */
    public function user_can_not_see_individual_client_statuses_for_change_if_current_status_is_active_or_inactive()
    {
        foreach ($this->individuals_clients as $individual) {
            $this->actingAs(self::$user)
                ->visit('/client/' . $individual->client_id)
                ->dontSee("/client/change_status/" . $individual->client_id . "/3")
                ->dontSee("/client/change_status/" . $individual->client_id . "/4")
                ->dontSee("/client/change_status/" . $individual->client_id . "/2");
        }
    }

    /**
     * Test Http Get Request Can Not Change Individual Client Status As User If Current Status Is Active Or Inactive (ClientsController@edit)
     *
     * @test
     * @return void
    */
    public function http_get_request_can_not_change_individual_client_status_if_current_status_is_active_or_inactive_as_user()
    {
        foreach ($this->individuals_clients as $individual) {
            $this->actingAs(self::$user)
                ->get('/client/change_status/' . $individual->client_id . '/' . rand(1, 4))
                ->assertResponseStatus(302)
                ->seeInDatabase('individuals', ['id' => $individual->id, 'client_status_id' => $individual->client_status_id]);
        }
    }

    /**
     * Test Admin Can Delete Legal Client With Client Status Not Contacted (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function admin_can_delete_legal_client_with_status_not_contacted()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->legal_uncontacted->client_id)
            ->see('Brisanje profila')
            ->click('OBRIŠI PROFIL')
            ->seePageIs('/home')
            ->see('Profil je uspešno obrisan.');
    }

    /**
     * Test Http Get Request Delete Legal Client With Client Status Not Contacted As Admin (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function http_get_request_delete_legal_client_with_status_not_contacted_as_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/client/delete/' . $this->legal_uncontacted->client_id . '/' . $this->legal_uncontacted->client_status_id)
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/home', ["message" => "Profil je uspešno obrisan."])
            ->notSeeInDatabase('legals', ['id' => $this->legal_uncontacted->id]);
    }

    /**
     * Test User Can Not Delete Legal Client With Client Status Not Contacted (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function user_can_not_delete_legal_client_with_status_not_contacted()
    {
        $this->actingAs(self::$user)
            ->visit('/client/' . $this->legal_uncontacted->client_id)
            ->see('Brisanje profila')
            ->click('OBRIŠI PROFIL')
            ->seePageIs('/client/' . $this->legal_uncontacted->client_id)
            ->see("Nemate ovlašćenje za ovu akciju!");
    }

    /**
     * Test Http Get Request Delete Legal Client With Client Status Not Contacted As User (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function http_get_request_delete_legal_client_with_status_not_contacted_as_user()
    {
        $this->actingAs(self::$user)
            ->get('/client/delete/' . $this->legal_uncontacted->client_id . '/' . $this->legal_uncontacted->client_status_id)
            ->assertResponseStatus(302)
            ->assertSessionHas(["message" => "Nemate ovlašćenje za ovu akciju!"]);
    }

        /**
     * Test Admin Can Delete Individual Client With Client Status Not Contacted (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function admin_can_delete_individual_client_with_status_not_contacted()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->individual_uncontacted->client_id)
            ->see('Brisanje profila')
            ->click('OBRIŠI PROFIL')
            ->seePageIs('/home')
            ->see('Profil je uspešno obrisan.');
    }

    /**
     * Test Http Get Request Delete Individual Client With Client Status Not Contacted As Admin (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function http_get_request_delete_individual_client_with_status_not_contacted_as_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/client/delete/' . $this->individual_uncontacted->client_id . '/' . $this->individual_uncontacted->client_status_id)
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/home', ["message" => "Profil je uspešno obrisan."])
            ->notSeeInDatabase('individuals', ['id' => $this->individual_uncontacted->id]);
    }

    /**
     * Test User Can Not Delete Individual Client With Client Status Not Contacted (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function user_can_delete_individual_client_with_status_not_contacted()
    {
        $this->actingAs(self::$user)
            ->visit('/client/' . $this->individual_uncontacted->client_id)
            ->see('Brisanje profila')
            ->click('OBRIŠI PROFIL')
            ->seePageIs('/client/' . $this->individual_uncontacted->client_id)
            ->see("Nemate ovlašćenje za ovu akciju!");
    }

    /**
     * Test Http Get Request Delete Individual Client With Client Status Not Contacted As User (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function http_get_request_delete_individual_client_with_status_not_contacted_as_user()
    {
        $this->actingAs(self::$user)
            ->get('/client/delete/' . $this->individual_uncontacted->client_id . '/' . $this->individual_uncontacted->client_status_id)
            ->assertResponseStatus(302)
            ->assertSessionHas(["message" => "Nemate ovlašćenje za ovu akciju!"]);
    }


    /**
     * Test Admin Can Not Delete Legal Client With Client Status Other Than Not Contacted (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function admin_can_not_delete_legal_client_with_status_other_than_not_contacted()
    {
        foreach ($this->legals_cant_be_deleted as $legal) {
            $this->actingAs(self::$admin)
                ->visit('/client/' . $legal->client_id)
                ->dontSee('Brisanje profila')
                ->dontSee('OBRIŠI PROFIL');
        }
    }

    /**
     * Test Http Get Request Delete Legal Client With Client Status Other Than Not Contacted As Admin (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function http_get_request_delete_legal_client_with_status_other_than_not_contacted_as_admin()
    {
        foreach ($this->legals_cant_be_deleted as $legal) {
            $this->actingAs(self::$admin)
                ->get('/client/delete/' . $legal->client_id . '/' . $legal->client_status_id)
                ->assertResponseStatus(302)
                ->assertRedirectedTo('/home')
                ->seeInDatabase('legals', ['id' => $legal->id]);
        }
    }

    /**
     * Test User Can Not Delete Legal Client With Client Status Other Than Not Contacted (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function user_can_not_delete_legal_client_with_status_other_than_not_contacted()
    {
        foreach ($this->legals_cant_be_deleted as $legal) {
            $this->actingAs(self::$user)
                ->visit('/client/' . $legal->client_id)
                ->dontSee('Brisanje profila')
                ->dontSee('OBRIŠI PROFIL');
        }
    }

    /**
     * Test Http Get Request Delete Legal Client With Client Status Other Than Not Contacted As User (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function http_get_request_delete_legal_client_with_status_other_than_not_contacted_as_user()
    {
        foreach ($this->legals_cant_be_deleted as $legal) {
            $this->actingAs(self::$user)
                ->get('/client/delete/' . $legal->client_id . '/' . $legal->client_status_id)
                ->assertResponseStatus(302)
                ->assertSessionHas(["message" => "Nemate ovlašćenje za ovu akciju!"]);
        }
    }


    /**
     * Test Admin Can Not Delete Individual Client With Client Status Other Than Not Contacted (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function admin_can_not_delete_individual_client_with_status_other_than_not_contacted()
    {
        foreach ($this->individuals_cant_be_deleted as $individual) {
            $this->actingAs(self::$admin)
                ->visit('/client/'.$individual->client_id)
                ->dontSee('Brisanje profila')
                ->dontSee('OBRIŠI PROFIL');
        }
    }

    /**
     * Test Http Get Request Delete Individual Client With Client Status Other Than Not Contacted As Admin (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function http_get_request_delete_individual_client_with_status_other_than_not_contacted_as_admin()
    {
        foreach ($this->individuals_cant_be_deleted as $individual) {
            $this->actingAs(self::$admin)
                ->get('/client/delete/' . $individual->client_id . '/' . $individual->client_status_id)
                ->assertResponseStatus(302)
                ->assertRedirectedTo('/home')
                ->seeInDatabase('individuals', ['id' => $individual->id]);
        }
    }

    /**
     * Test User Can Not Delete Individual Client With Client Status Other Than Not Contacted (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function user_can_not_delete_individual_client_with_status_other_than_not_contacted()
    {
        foreach ($this->individuals_cant_be_deleted as $individual) {
            $this->actingAs(self::$user)
                ->visit('/client/' . $individual->client_id)
                ->dontSee('Brisanje profila')
                ->dontSee('OBRIŠI PROFIL');
        }
    }

    /**
     * Test Http Get Request Delete Individual Client With Client Status Other Than Not Contacted As User (ClientController@destroy)
     *
     * @test
     * @return void
    */
    public function http_get_request_delete_individual_client_with_status_other_than_not_contacted_as_user()
    {
        foreach ($this->individuals_cant_be_deleted as $individual) {
            $this->actingAs(self::$user)
                ->get('/client/delete/' . $individual->client_id . '/' . $individual->client_status_id)
                ->assertResponseStatus(302)
                ->assertSessionHas(["message" => "Nemate ovlašćenje za ovu akciju!"]);
        }
    }

    /**
     * Test Admin Can See Clients Based On Input Search (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function admin_can_see_clients_based_on_input_search()
    {
        $this->create_ten_clients();
        $this->actingAs(self::$admin)
        ->call('GET', '/search/0/0', ['search' => ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/0/0')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter']);
        foreach (Client::all() as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test User Can See Clients Based On Input Search (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function user_can_see_clients_based_on_input_search()
    {
        $this->create_ten_clients();
        $this->actingAs(self::$user)
        ->call('GET', '/search/0/0', ['search' => ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/0/0')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter']);
        foreach (Client::all() as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test Admin Can See Legal Client Based On First Letter Long Name In Input Search (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function admin_can_see_legal_client_based_on_first_letter_long_name_in_input_search()
    {
        $this->actingAs(self::$admin)
        ->call('GET', '/search/0/0', ['search' => $this->legal->long_name[0]], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/0/0')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter'])
        ->see('/client/'.$this->legal->client_id)
        ->see($this->legal->long_name);
    }

    /**
     * Test User Can See Legal Client Based On First Letter Long Name In Input Search (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function user_can_see_legal_client_based_on_first_letter_long_name_in_input_search()
    {
        $this->actingAs(self::$user)
        ->call('GET', '/search/0/0', ['search' => $this->legal->long_name[0]], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/0/0')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter'])
        ->see('/client/'.$this->legal->client_id)
        ->see($this->legal->long_name);
    }

    /**
     * Test Admin Can See Individual Client Based On First Letter First Name In Input Search (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function admin_can_see_individual_client_based_on_first_letter_first_name_in_input_search()
    {
        $this->actingAs(self::$admin)
        ->call('GET', '/search/0/0', ['search' => $this->individual->first_name[0]], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/0/0')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter'])
        ->see('/client/'.$this->individual->client_id)
        ->see($this->individual->first_name);
    }

    /**
     * Test User Can See Individual Client Based On First Letter First Name In Input Search (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function user_can_see_individual_client_based_on_first_letter_first_name_in_input_search()
    {
        $this->actingAs(self::$user)
        ->call('GET', '/search/0/0', ['search' => $this->individual->first_name[0]], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/0/0')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter'])
        ->see('/client/'.$this->individual->client_id)
        ->see($this->individual->first_name);
    }

    /**
     * Test Admin Can See Only Legal Clients Based On Input Search (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function admin_can_see_only_legal_clients_based_on_input_search()
    {
        $this->actingAs(self::$admin)
        ->call('GET', '/search/1/0', ['search' => ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/1/0')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter']);
        foreach (Legal::all() as $legal) {
            $this->see('/client/'.$legal->client_id)
                ->see($legal->long_name);
        }
    }

    /**
     * Test User Can See Only Legal Clients Based On Input Search (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function user_can_see_only_legal_clients_based_on_input_search()
    {
        $this->actingAs(self::$user)
        ->call('GET', '/search/1/0', ['search' => ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/1/0')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter']);
        foreach (Legal::all() as $legal) {
            $this->see('/client/'.$legal->client_id)
                ->see($legal->long_name);
        }
    }

    /**
     * Test Admin Can See Only Individual Clients Based On Input Search (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function admin_can_see_only_individual_clients_based_on_input_search()
    {
        $this->actingAs(self::$admin)
        ->call('GET', '/search/2/0', ['search' => ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/2/0')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter']);
        foreach (Individual::all() as $individual) {
            $this->see('/client/'.$individual->client_id)
                ->see($this->individual->first_name .' ' . $this->individual->last_name);
        }
    }

    /**
     * Test User Can See Only Individual Clients Based On Input Search (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function user_can_see_only_individual_clients_based_on_input_search()
    {
        $this->actingAs(self::$user)
        ->call('GET', '/search/2/0', ['search' => ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/2/0')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter']);
        foreach (Individual::all() as $individual) {
            $this->see('/client/'.$individual->client_id)
                ->see($this->individual->first_name .' ' . $this->individual->last_name);
        }
    }

    /**
     * Test Admin Can See Clients Based On Input Search Sort By Name Asc (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function admin_can_see_clients_based_on_input_search_sort_by_name_asc()
    {
        $this->actingAs(self::$admin)
        ->call('GET', '/search/0/1', ['search' => $search = ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/0/1')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter']);
        $clients = (new Client)->search_input_clients_pagination($search, [1,2], 'long_name', 'first_name', 'last_name', 'ASC', 10);
        foreach ($clients as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test User Can See Clients Based On Input Search Sort By Name Asc (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function user_can_see_clients_based_on_input_search_sort_by_name_asc()
    {
        $this->actingAs(self::$user)
        ->call('GET', '/search/0/1', ['search' => $search = ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/0/1')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter']);
        $clients = (new Client)->search_input_clients_pagination($search, [1,2], 'long_name', 'first_name', 'last_name', 'ASC', 10);
        foreach ($clients as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test Admin Can See Clients Based On Input Search Sort By Name Desc (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function admin_can_see_clients_based_on_input_search_sort_by_name_desc()
    {
        $this->actingAs(self::$admin)
        ->call('GET', '/search/0/2', ['search' => $search = ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/0/2')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter']);
        $clients = (new Client)->search_input_clients_pagination($search, [1,2], 'long_name', 'first_name', 'last_name', 'DESC', 10);
        foreach ($clients as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test User Can See Clients Based On Input Search Sort By Name Desc (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function user_can_see_clients_based_on_input_search_sort_by_name_desc()
    {
        $this->actingAs(self::$user)
        ->call('GET', '/search/0/2', ['search' => $search = ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/0/2')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter']);
        $clients = (new Client)->search_input_clients_pagination($search, [1,2], 'long_name', 'first_name', 'last_name', 'DESC', 10);
        foreach ($clients as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test Admin Can See Clients Based On Input Search Sort By ID Asc (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function admin_can_see_clients_based_on_input_search_sort_by_id_asc()
    {
        $this->actingAs(self::$admin)
        ->call('GET', '/search/0/3', ['search' => $search = ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/0/3')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter']);
        $clients = (new Client)->search_input_clients_pagination($search, [1,2], 'laravel_legals.id', 'laravel_individuals.id', 'laravel_individuals.id', 'ASC', 10);
        foreach ($clients as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test User Can See Clients Based On Input Search Sort By ID Asc (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function user_can_see_clients_based_on_input_search_sort_by_id_asc()
    {
        $this->actingAs(self::$user)
        ->call('GET', '/search/0/3', ['search' => $search = ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/0/3')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter']);
        $clients = (new Client)->search_input_clients_pagination($search, [1,2], 'laravel_legals.id', 'laravel_individuals.id', 'laravel_individuals.id', 'ASC', 10);
        foreach ($clients as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test Admin Can See Clients Based On Input Search Sort By ID Desc (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function admin_can_see_clients_based_on_input_search_sort_by_id_desc()
    {
        $this->actingAs(self::$admin)
        ->call('GET', '/search/0/4', ['search' => $search = ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/0/4')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter']);
        $clients = (new Client)->search_input_clients_pagination($search, [1,2], 'laravel_legals.id', 'laravel_individuals.id', 'laravel_individuals.id', 'DESC', 10);
        foreach ($clients as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test User Can See Clients Based On Input Search Sort By ID Desc (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function user_can_see_clients_based_on_input_search_sort_by_id_desc()
    {
        $this->actingAs(self::$user)
        ->call('GET', '/search/0/4', ['search' => $search = ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->seePageIs('search/0/4')
        ->assertResponseStatus(200)
        ->assertViewHas(['clients', 'search', 'legal_filter', 'sort_filter']);
        $clients = (new Client)->search_input_clients_pagination($search, [1,2], 'laravel_legals.id', 'laravel_individuals.id', 'laravel_individuals.id', 'DESC', 10);
        foreach ($clients as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test Input Search Value Is Not Valid (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function input_search_value_is_not_valid()
    {
        $input_array = ['$', '_', '<', '>', '"', ';', '/', '\'', '?', '!', '-'];
        foreach ($input_array as $search) {
            $this->actingAs(self::$admin)
            ->call('GET', '/search/0/0', ['search' => $search], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
             $this->see('Format polja search nije validan.');
        }
    }

    /**
     * Test Input Search Legal Filter Must Be Numeric (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function input_search_legal_filter_must_be_numeric()
    {
        $this->actingAs(self::$admin)
        ->call('GET', '/search/search/0', ['search' => ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
         $this->see('Polje legal filter mora biti broj.');
         $this->see('Polje legal filter mora biti izem\u0111u 1 i 2 cifri.');
    }

     /**
     * Test Input Search Sort Filter Must Be Numeric (ClientsController@search_all)
     *
     * @test
     * @return void
    */
    public function input_search_sort_filter_must_be_numeric()
    {
        $this->actingAs(self::$admin)
        ->call('GET', '/search/0/search', ['search' => ''], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
         $this->see('Polje sort filter mora biti broj.');
         $this->see('Polje sort filter mora biti izem\u0111u 0 i 4 cifri.');
    }

    /**
     * Test Admin Can See Not Contacted Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function admin_can_see_not_contacted_clients_in_home_page_ajax()
    {
        $not_contacted = Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 1)
            ->orWhere('individuals.client_status_id', 1)
            ->limit(10)
            ->get();
        $this->actingAs(self::$admin)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 1, 'local_search' => '', 'legal_filter' => 0, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($not_contacted as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test User Can See Not Contacted Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function user_can_see_not_contacted_clients_in_home_page_ajax()
    {
        $not_contacted = Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 1)
            ->orWhere('individuals.client_status_id', 1)
            ->limit(10)
            ->get();
        $this->actingAs(self::$user)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 1, 'local_search' => '', 'legal_filter' => 0, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($not_contacted as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test Admin Can See Disqualified Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function admin_can_see_disqualified_clients_in_home_page_ajax()
    {
        $disqualified = Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 2)
            ->orWhere('individuals.client_status_id', 2)
            ->limit(10)
            ->get();
        $this->actingAs(self::$admin)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 2, 'local_search' => '', 'legal_filter' => 0, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($disqualified as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test User Can See Disqualified Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function user_can_see_disqualified_clients_in_home_page_ajax()
    {
        $disqualified = Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 2)
            ->orWhere('individuals.client_status_id', 2)
            ->limit(10)
            ->get();
        $this->actingAs(self::$user)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 2, 'local_search' => '', 'legal_filter' => 0, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($disqualified as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test Admin Can See Accept Meeting Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function admin_can_see_accept_meeting_clients_in_home_page_ajax()
    {
        $accept_meeting = Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 3)
            ->orWhere('individuals.client_status_id', 3)
            ->limit(10)
            ->get();
        $this->actingAs(self::$admin)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 3, 'local_search' => '', 'legal_filter' => 0, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($accept_meeting as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test User Can See Accept Meeting Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function user_can_see_accept_meeting_clients_in_home_page_ajax()
    {
        $accept_meeting = Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 3)
            ->orWhere('individuals.client_status_id', 3)
            ->limit(10)
            ->get();
        $this->actingAs(self::$user)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 3, 'local_search' => '', 'legal_filter' => 0, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($accept_meeting as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test Admin Can See JPB Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function admin_can_see_jpb_clients_in_home_page_ajax()
    {
        $jpb = Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 4)
            ->orWhere('individuals.client_status_id', 4)
            ->limit(10)
            ->get();
        $this->actingAs(self::$admin)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 4, 'local_search' => '', 'legal_filter' => 0, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($jpb as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test User Can See JPB Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function user_can_see_jpb_clients_in_home_page_ajax()
    {
        $jpb = Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 4)
            ->orWhere('individuals.client_status_id', 4)
            ->limit(10)
            ->get();
        $this->actingAs(self::$user)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 4, 'local_search' => '', 'legal_filter' => 0, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($jpb as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test Admin Can See Inactive Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function admin_can_see_inactive_clients_in_home_page_ajax()
    {
        $inactive = Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 5)
            ->orWhere('individuals.client_status_id', 5)
            ->limit(10)
            ->get();
        $this->actingAs(self::$admin)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 5, 'local_search' => '', 'legal_filter' => 0, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($inactive as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test User Can See Inactive Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function user_can_see_inactive_clients_in_home_page_ajax()
    {
        $inactive = Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 5)
            ->orWhere('individuals.client_status_id', 5)
            ->limit(10)
            ->get();
        $this->actingAs(self::$user)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 5, 'local_search' => '', 'legal_filter' => 0, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($inactive as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test Admin Can See Active Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function admin_can_see_active_clients_in_home_page_ajax()
    {
        $active = Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 6)
            ->orWhere('individuals.client_status_id', 6)
            ->limit(10)
            ->get();
        $this->actingAs(self::$admin)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 6, 'local_search' => '', 'legal_filter' => 0, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($active as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test User Can See Active Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function user_can_see_active_clients_in_home_page_ajax()
    {
        $active = Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
            ->where('legals.client_status_id', 6)
            ->orWhere('individuals.client_status_id', 6)
            ->limit(10)
            ->get();
        $this->actingAs(self::$user)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 6, 'local_search' => '', 'legal_filter' => 0, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($active as $client) {
            $this->see('/client/'.$client->id);
        }
    }

    /**
     * Test Admin Can See Legal Not Contacted Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function admin_can_see_legal_not_contacted_clients_in_home_page_ajax()
    {
        $legals = Legal::where('client_status_id', 1)->limit(10)->get();
        $this->actingAs(self::$admin)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 1, 'local_search' => '', 'legal_filter' => 1, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($legals as $legal) {
            $this->see('/client/'.$legal->client_id)
            ->see($legal->long_name);
        }
    }

    /**
     * Test User Can See Legal Not Contacted Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function user_can_see_legal_not_contacted_clients_in_home_page_ajax()
    {
        $legals = Legal::where('client_status_id', 1)->limit(10)->get();
        $this->actingAs(self::$user)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 1, 'local_search' => '', 'legal_filter' => 1, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($legals as $legal) {
            $this->see('/client/'.$legal->client_id)
            ->see($legal->long_name);
        }
    }

    /**
     * Test Admin Can See Individual Not Contacted Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function admin_can_see_individual_not_contacted_clients_in_home_page_ajax()
    {
        $individuals = Individual::where('client_status_id', 1)->limit(10)->get();
        $this->actingAs(self::$admin)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 1, 'local_search' => '', 'legal_filter' => 2, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($individuals as $individual) {
            $this->see('/client/'.$individual->client_id)
            ->see($individual->first_name . ' ' . $individual->last_name);
        }
    }

    /**
     * Test User Can See Individual Not Contacted Clients In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function user_can_see_individual_not_contacted_clients_in_home_page_ajax()
    {
        $individuals = Individual::where('client_status_id', 1)->limit(10)->get();
        $this->actingAs(self::$user)
            ->call(
                'GET',
                '/clients',
                ['client_status' => 1, 'local_search' => '', 'legal_filter' => 2, 'sort_filter' => 0],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($individuals as $individual) {
            $this->see('/client/'.$individual->client_id)
             ->see($individual->first_name . ' ' . $individual->last_name);
        }
    }

    /**
     * Test Admin Can See Not Contacted Clients Based On Input Search In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function admin_can_see_not_contacted_clients_based_on_input_search_in_home_page_ajax()
    {
        $clients = (new Client)->search_clients_by_client_status_pagination($search = $this->legal->long_name[0], $client_status = 1, $legal_status = [1,2], 'long_name', 'first_name', 'last_name', 'ASC', $pagination = 10);
        $this->actingAs(self::$admin)
            ->call(
                'GET',
                '/clients',
                ['client_status' => $client_status, 'local_search' => $search, 'legal_filter' => $legal_status, 'sort_filter' => 1],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($clients as $client) {
            $this->see($client->id);
        }
    }

    /**
     * Test User Can See Not Contacted Clients Based On Input Search In Home Page With Ajax (ContractsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function user_can_see_not_contacted_clients_based_on_input_search_in_home_page_ajax()
    {
        $clients = (new Client)->search_clients_by_client_status_pagination($search = '', $client_status = 1, $legal_status = [1,2], 'long_name', 'first_name', 'last_name', 'ASC', $pagination = 10);
        $this->actingAs(self::$user)
            ->call(
                'GET',
                '/clients',
                ['client_status' => $client_status, 'local_search' => $search, 'legal_filter' => $legal_status, 'sort_filter' => 1],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($clients as $client) {
            $this->see($client->id);
        }
    }

    /**
     * Test Admin Can See Not Contacted Clients Based On Input Search Sort By Name Asc (ClientsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function admin_can_see_not_contacted_clients_based_on_input_search_sort_by_name_asc()
    {
        $clients = (new Client)->search_clients_by_client_status_pagination($search = '', $client_status = 1, $legal_status = [1,2], 'long_name', 'first_name', 'last_name', 'ASC', $pagination = 10);
        $this->actingAs(self::$admin)
            ->call(
                'GET',
                '/clients',
                ['client_status' => $client_status, 'local_search' => $search, 'legal_filter' => $legal_status, 'sort_filter' => 1],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($clients as $client) {
            $this->see($client->id);
        }
    }

    /**
     * Test User Can See Not Contacted Clients Based On Input Search Sort By Name Asc (ClientsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function user_can_see_not_contacted_clients_based_on_input_search_sort_by_name_asc()
    {
        $clients = (new Client)->search_clients_by_client_status_pagination($search = '', $client_status = 1, $legal_status = [1,2], 'long_name', 'first_name', 'last_name', 'ASC', $pagination = 10);
        $this->actingAs(self::$user)
            ->call(
                'GET',
                '/clients',
                ['client_status' => $client_status, 'local_search' => $search, 'legal_filter' => $legal_status, 'sort_filter' => 1],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($clients as $client) {
            $this->see($client->id);
        }
    }

    /**
     * Test Admin Can See Not Contacted Clients Based On Input Search Sort By Name DESC (ClientsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function admin_can_see_not_contacted_clients_based_on_input_search_sort_by_name_desc()
    {
        $clients = (new Client)->search_clients_by_client_status_pagination($search = '', $client_status = 1, $legal_status = [1,2], 'long_name', 'first_name', 'last_name', 'DESC', $pagination = 10);
        $this->actingAs(self::$admin)
            ->call(
                'GET',
                '/clients',
                ['client_status' => $client_status, 'local_search' => $search, 'legal_filter' => $legal_status, 'sort_filter' => 2],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($clients as $client) {
            $this->see($client->id);
        }
    }

    /**
     * Test User Can See Not Contacted Clients Based On Input Search Sort By Name DESC (ClientsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function user_can_see_not_contacted_clients_based_on_input_search_sort_by_name_desc()
    {
        $clients = (new Client)->search_clients_by_client_status_pagination($search = '', $client_status = 1, $legal_status = [1,2], 'long_name', 'first_name', 'last_name', 'DESC', $pagination = 10);
        $this->actingAs(self::$user)
            ->call(
                'GET',
                '/clients',
                ['client_status' => $client_status, 'local_search' => $search, 'legal_filter' => $legal_status, 'sort_filter' => 2],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($clients as $client) {
            $this->see($client->id);
        }
    }

    /**
     * Test Admin Can See Not Contacted Clients Based On Input Search Sort By ID ASC (ClientsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function admin_can_see_not_contacted_clients_based_on_input_search_sort_by_id_asc()
    {
        $clients = (new Client)->search_clients_by_client_status_pagination($search = '', $client_status = 1, $legal_status = [1,2], 'laravel_legals.id', 'laravel_individuals.id', 'laravel_individuals.id', 'ASC', $pagination = 10);
        $this->actingAs(self::$admin)
            ->call(
                'GET',
                '/clients',
                ['client_status' => $client_status, 'local_search' => $search, 'legal_filter' => $legal_status, 'sort_filter' => 3],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($clients as $client) {
            $this->see($client->id);
        }
    }

    /**
     * Test User Can See Not Contacted Clients Based On Input Search Sort By ID ASC (ClientsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function user_can_see_not_contacted_clients_based_on_input_search_sort_by_id_asc()
    {
        $clients = (new Client)->search_clients_by_client_status_pagination($search = '', $client_status = 1, $legal_status = [1,2], 'laravel_legals.id', 'laravel_individuals.id', 'laravel_individuals.id', 'ASC', $pagination = 10);
        $this->actingAs(self::$user)
            ->call(
                'GET',
                '/clients',
                ['client_status' => $client_status, 'local_search' => $search, 'legal_filter' => $legal_status, 'sort_filter' => 3],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($clients as $client) {
            $this->see($client->id);
        }
    }

    /**
     * Test Admin Can See Not Contacted Clients Based On Input Search Sort By ID DESC (ClientsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function admin_can_see_not_contacted_clients_based_on_input_search_sort_by_id_desc()
    {
        $clients = (new Client)->search_clients_by_client_status_pagination($search = '', $client_status = 1, $legal_status = [1,2], 'laravel_legals.id', 'laravel_individuals.id', 'laravel_individuals.id', 'DESC', $pagination = 10);
        $this->actingAs(self::$admin)
            ->call(
                'GET',
                '/clients',
                ['client_status' => $client_status, 'local_search' => $search, 'legal_filter' => $legal_status, 'sort_filter' => 4],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($clients as $client) {
            $this->see($client->id);
        }
    }

    /**
     * Test User Can See Not Contacted Clients Based On Input Search Sort By ID DESC (ClientsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function user_can_see_not_contacted_clients_based_on_input_search_sort_by_id_desc()
    {
        $clients = (new Client)->search_clients_by_client_status_pagination($search = '', $client_status = 1, $legal_status = [1,2], 'laravel_legals.id', 'laravel_individuals.id', 'laravel_individuals.id', 'DESC', $pagination = 10);
        $this->actingAs(self::$user)
            ->call(
                'GET',
                '/clients',
                ['client_status' => $client_status, 'local_search' => $search, 'legal_filter' => $legal_status, 'sort_filter' => 4],
                [],
                [],
                ['HTTP_X-Requested-With' => 'XMLHttpRequest']
            );
        foreach ($clients as $client) {
            $this->see($client->id);
        }
    }

    /**
     * Test Clients Search By Status Local Search Value Is Not Valid (ClientsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function clients_search_by_status_local_search_value_is_not_valid()
    {
        $input_array = ['$', '_', '<', '>', '"', ';', '/', '\'', '?', '!', '-'];
        foreach ($input_array as $search) {
            $this->actingAs(self::$admin)
                ->call(
                    'GET',
                    '/clients',
                    ['client_status' => 1, 'local_search' => $search, 'legal_filter' => [1,2], 'sort_filter' => 0],
                    [],
                    [],
                    ['HTTP_X-Requested-With' => 'XMLHttpRequest']
                );
            $this->assertResponseStatus(500);
        }
    }

    /**
     * Test Clients Search By Status Legal Filter Must Be Numeric (ClientsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function clients_search_by_status_legal_filter_must_be_numeric()
    {
        $this->actingAs(self::$admin)
        ->call(
            'GET',
            '/clients',
            ['client_status' => 1, 'local_search' => '', 'legal_filter' => 'filter', 'sort_filter' => 0],
            [],
            [],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']
        );
        $this->see('Polje legal filter mora biti broj.');
        $this->see('Polje legal filter mora biti izem\u0111u 1 i 2 cifri.');
    }

     /**
     * Test Clients Search By Status Sort Filter Must Be Numeric (ClientsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function clients_search_by_status_sort_filter_must_be_numeric()
    {
        $this->actingAs(self::$admin)
        ->call(
            'GET',
            '/clients',
            ['client_status' => 1, 'local_search' => '', 'legal_filter' => 1, 'sort_filter' => 'filter'],
            [],
            [],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']
        );
        $this->see('Polje sort filter mora biti broj.');
        $this->see('Polje sort filter mora biti izem\u0111u 0 i 4 cifri.');
    }

    /**
     * Test Clients Search By Status Client Status Field Is Required (ClientsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function clients_search_by_status_client_status_field_is_required()
    {
        $this->actingAs(self::$admin)
        ->call(
            'GET',
            '/clients',
            ['client_status' => '', 'local_search' => '', 'legal_filter' => 1, 'sort_filter' => 0],
            [],
            [],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']
        );
        $this->see('Polje client status je obavezno.');
    }

     /**
     * Test Clients Search By Status Client Status Field Must Be Numeric(ClientsController@search_by_status)
     *
     * @test
     * @return void
    */
    public function clients_search_by_status_client_status_field_must_be_numeric()
    {
        $this->actingAs(self::$admin)
        ->call(
            'GET',
            '/clients',
            ['client_status' => 'status', 'local_search' => '', 'legal_filter' => 1, 'sort_filter' => 0],
            [],
            [],
            ['HTTP_X-Requested-With' => 'XMLHttpRequest']
        );
        $this->see('Polje client status mora biti broj.');
        $this->see('Polje client status mora biti izem\u0111u 1 i 6 cifri.');
    }


    /**
     * Create 10 Clients (Legal And Individual)
     *
     * @return void
     */
    public function create_ten_clients()
    {
        $this->truncate_legal_individual_and_client_table();
        factory(Legal::class, 5)->create();
        factory(Individual::class, 5)->create();
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
