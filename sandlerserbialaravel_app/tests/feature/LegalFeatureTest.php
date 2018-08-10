<?php

use App\Legal;
use App\Individual;
use App\Client;
use Illuminate\Http\UploadedFile;

class LegalFeatureTest extends TestCase
{
    /**
     * Legal Client
     *
     * @var App\Legal
     */
    protected $legal;

    /**
     * Accept Meeting Legal
     *      *
     * @var App\Legal
     */
    protected $accept_meeting_legal;

    /**
     * Non Accept Meeting Legals
     *      *
     * @var App\Legal
     */
    protected $non_accept_meeting_legals;
    
    /**
     * Faker
     *
     * @var Faker\Factory
     */
    protected $faker;

    /**
     * Excel File Path
     *
     * @var string
     */
    protected $excel_file;


    /**
     * Creates Legal Client, Accept Meeting Legal, Non Accept Meeting Legals, Faker And Excel File
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(Legal::first())) {
            factory(Legal::class)->create();
            factory(Legal::class, 'disqualified_without_meeting')->create();
            factory(Legal::class, 'disqualified_after_meeting')->create();
            factory(Legal::class, 'accept_meeting')->create();
            factory(Legal::class, 'jpb')->create();
            factory(Legal::class, 'inactive')->create();
            factory(Legal::class, 'active')->create();
        }

        if (is_null($this->legal)) {
            $this->legal = Legal::first();
        }

        if (is_null($this->accept_meeting_legal)) {
            $this->accept_meeting_legal = Legal::where('client_status_id', 3)->first();
        }

        if (is_null($this->non_accept_meeting_legals)) {
            $this->non_accept_meeting_legals = Legal::whereNotIn('client_status_id', [3])->get();
        }

        if (is_null($this->faker)) {
            $this->faker = Faker\Factory::create();
        }

        if (is_null($this->excel_file)) {
            $this->excel_file = base_path('\tests\tmp\upload\excel_file.xlsx');
        }

        if (!file_exists($this->excel_file)) {
            \File::copy(base_path('\tests\tmp\excel\excel_file.xlsx'), $this->excel_file);
        }
    }

    /**
     * Test Admin Can See The Form For Creating Legal Client (LegalsController@create)
     *
     * @test
     * @return void
    */
    public function admin_can_see_the_form_for_creating_legal_client()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->click('Pravno lice')
            ->seePageIs('/legal/create')
            ->see('Suspect - Pravno lice')
            ->see('POTVRDI');
    }

    /**
     * Test Http Get Request Show The Form For Creating Legal Client As Admin (LegalsController@create)
     *
     * @test
     * @return void
    */
    public function http_get_request_show_the_form_for_creating_legal_client_as_admin()
    {
        $this->actingAs(self::$admin)
           ->get('/legal/create')
            ->assertResponseStatus(200)
            ->assertViewHas(['company_sizes', 'current_time']);
    }

     /**
     * Test User Can See The Form For Creating Legal Client (LegalsController@create)
     *
     * @test
     * @return void
    */
    public function user_can_see_the_form_for_creating_legal_client()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->click('Pravno lice')
            ->seePageIs('/legal/create')
            ->see('Suspect - Pravno lice')
            ->see('POTVRDI');
    }

    /**
     * Test Http Get Request Show The Form For Creating Legal Client As User (LegalsController@create)
     *
     * @test
     * @return void
    */
    public function http_get_request_show_the_form_for_creating_legal_client_as_user()
    {
        $this->actingAs(self::$user)
           ->get('/legal/create')
            ->assertResponseStatus(200)
            ->assertViewHas(['company_sizes', 'current_time']);
    }

    /**
     * Test Admin Can Return From Create Legal Client Page To Previous Page (LegalsController@create)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_create_legal_client_page_to_previous_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/taxes/edit')
            ->visit('/legal/create')
            ->click('Nazad')
            ->seePageIs('/taxes/edit')
            ->see('Porez');
    }

    /**
     * Test User Can Return From Create Legal Client Page To Previous Page (LegalsController@create)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_create_legal_client_page_to_previous_page()
    {
        $this->actingAs(self::$user)
            ->visit('/sandler/edit')
            ->visit('/legal/create')
            ->click('Nazad')
            ->seePageIs('/sandler/edit')
            ->see('Sandler procenat');
    }

    /**
     * Test Admin Can See The Form For Creating Legal Client From File (LegalsController@create_from_file)
     *
     * @test
     * @return void
    */
    public function admin_can_see_the_form_for_creating_legal_client_from_file()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->click('Preko fajla')
            ->seePageIs('/legals/create_from_file')
            ->see('Suspects - pravna lica preko fajla')
            ->see('Izaberi Excel fajl')
            ->see('POTVRDI');
    }

    /**
     * Test Http Get Request Show The Form For Creating Legal Client From File As Admin (LegalsController@create_from_file)
     *
     * @test
     * @return void
    */
    public function http_get_request_show_the_form_for_creating_legal_client_from_file_as_admin()
    {
        $this->actingAs(self::$admin)
           ->get('/legals/create_from_file')
            ->assertResponseStatus(200)
            ->assertViewHas(['current_time']);
    }

     /**
     * Test User Can See The Form For Creating Legal Client From File (LegalsController@create_from_file)
     *
     * @test
     * @return void
    */
    public function user_can_see_the_form_for_creating_legal_client_from_file()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->click('Preko fajla')
            ->seePageIs('/legals/create_from_file')
            ->see('Suspects - pravna lica preko fajla')
            ->see('Izaberi Excel fajl')
            ->see('POTVRDI');
    }

    /**
     * Test Http Get Request Show The Form For Creating Legal Client From File As User (LegalsController@create_from_file)
     *
     * @test
     * @return void
    */
    public function http_get_request_show_the_form_for_creating_legal_client_from_file_as_user()
    {
        $this->actingAs(self::$user)
           ->get('/legals/create_from_file')
            ->assertResponseStatus(200)
            ->assertViewHas(['current_time']);
    }

    /**
     * Test Admin Can Return From Create Legal Client From File Page To Previous Page (LegalsController@create_from_file)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_create_legal_client_from_file_page_to_previous_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/disc_devine/edit')
            ->visit('/legals/create_from_file')
            ->click('Nazad')
            ->seePageIs('/disc_devine/edit')
            ->see('DISC/Devine');
    }

    /**
     * Test User Can Return From Create Legal Client From File Page To Previous Page (LegalsController@create_from_file)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_create_legal_client_from_file_page_to_previous_page()
    {
        $this->actingAs(self::$user)
            ->visit('/exchange')
            ->visit('/legals/create_from_file')
            ->click('Nazad')
            ->seePageIs('/exchange')
            ->see('Kursna lista na dan ' . date('d.m.Y.'));
    }

    /**
     * Test Admin Can Store Legal Client (LegalsController@store)
     *
     * @test
     * @return void
     */
    public function admin_can_store_legal_client()
    {
        $this->actingAs(self::$admin)
            ->visit('/legal/create')
            ->type($company = $this->faker->company, 'long_name')
            ->press('POTVRDI')
            ->seePageIs('/legal/create')
            ->see('Suspect ' . $company . ' je uspešno unet.');
    }

    /**
     * Test User Can Not Store Legal Client (LegalsController@store)
     *
     * @test
     * @return void
     */
    public function user_can_not_store_legal_client()
    {
        $this->actingAs(self::$user)
            ->visit('/legal/create')
            ->type($company = $this->faker->company, 'long_name')
            ->press('POTVRDI')
            ->seePageIs('/legal/create')
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test Store And Update Legal Client Long Name Is Required (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_client_long_name_is_required()
    {
        $data['field_name'] = 'long_name';
        $data['field_value'] =  '';
        $data['error_message'] = "Polje Naziv je obavezno.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Long Name Must Be Maximimum 255 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_client_long_name_must_be_maximum_255_characters_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', 'a', str_random(256));
        $data['field_name'] = 'long_name';
        $data['field_value'] =  $too_long_name;
        $data['error_message'] = "Polje Naziv mora sadržati manje od 255 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Long Name Must Be Unique (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_client_long_name_must_be_unique()
    {
        $data['field_name'] = 'long_name';
        $data['field_value'] =  Legal::where('id', '!=', $this->legal->id)->first()->long_name;
        $data['error_message'] = "Polje Naziv već postoji.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Short Name Must Be Maximimum 100 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_client_short_name_must_be_maximum_100_characters_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', 'a', str_random(101));
        $data['field_name'] = 'short_name';
        $data['field_value'] =  $too_long_name;
        $data['error_message'] = "Polje Kraći naziv mora sadržati manje od 100 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Short Name Must Be Unique (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_client_short_name_must_be_unique()
    {
        $data['field_name'] = 'short_name';
        $data['field_value'] =  Legal::where('id', '!=', $this->legal->id)->first()->short_name;
        $data['error_message'] = "Polje Kraći naziv već postoji.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Ceo Must Contain Only Letters, Spaces, Dots And Hyphens (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_ceo_must_contain_only_letters_spaces_dots_and_hyphens()
    {
        $data['field_name'] = 'ceo';
        $data['field_value'] =  'a$_(*&^)';
        $data['error_message'] = "Polje Direktor može sadržati samo slova, razmake, tačke, srednje crte i apostrofe.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Ceo Must Be Minimum 2 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_ceo_must_be_minimum_2_characters_long()
    {
        $data['field_name'] = 'ceo';
        $data['field_value'] =  'a';
        $data['error_message'] = "Polje Direktor mora sadržati najmanje 2 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Ceo Must Be Maximimum 45 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_ceo_must_be_maximum_45_characters_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', 'a', str_random(46));
        $data['field_name'] = 'ceo';
        $data['field_value'] =  $too_long_name;
        $data['error_message'] = "Polje Direktor mora sadržati manje od 45 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Phone Must Be Between 6 And 30 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_phone_must_be_between_6_and_30_chartacters_long()
    {
        $data['field_name'] = 'phone';
        $data['field_value'] = array_rand([rand(1, 5), rand(31, 100)]);
        $data['error_message'] = "Polje Telefon mora biti između 6 - 30 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Phone Must Contain Only Numbers, Spaces And Plus Sign (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_phone_must_contain_only_numbers_spaces_and_plus_sign()
    {
        $data['field_name'] = 'phone';
        $data['field_value'] = rand(100000, 999999999) . "@_$";
        $data['error_message'] = "Polje Telefon mora biti broj ili razmak.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Email Must Be Minimum 7 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_email_must_be_minimum_7_characters_long()
    {
        $data['field_name'] = 'email';
        $data['field_value'] = 'a@r.rs';
        $data['error_message'] = "Polje Email adresa mora sadržati najmanje 7 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Email Must Be Maximimum 150 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_email_must_be_maximum_150_characters_long()
    {
        $data['field_name'] = 'email';
        $data['field_value'] = str_random(151).'@gmail.com';
        $data['error_message'] = "Format polja Email adresa nije validan.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Email Format Is Invalid (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_email_format_is_invalid()
    {
        $data['field_name'] = 'email';
        $data['field_value'] = 'someemailadress.com';
        $data['error_message'] = "Format polja Email adresa nije validan.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Contact Person Must Contain Only Letters, Spaces, Dots And Hyphens (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_contact_person_must_contain_only_letters_spaces_dots_and_hyphens()
    {
        $data['field_name'] = 'contact_person';
        $data['field_value'] = 'a$_(*&^)';
        $data['error_message'] = "Polje Lice za razgovor može sadržati samo slova, razmake, tačke, srednje crte i apostrofe.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Contact Person Must Be Minimum 2 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_contact_person_must_be_minimum_2_characters_long()
    {
        $data['field_name'] = 'contact_person';
        $data['field_value'] = 'a';
        $data['error_message'] = "Polje Lice za razgovor mora sadržati najmanje 2 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Contact Person Must Be Maximimum 45 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_contact_person_must_be_maximum_45_characters_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', 'a', str_random(46));
        $data['field_name'] = 'contact_person';
        $data['field_value'] = $too_long_name;
        $data['error_message'] = "Polje Lice za razgovor mora sadržati manje od 45 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Contact Person Phone Must Be Between 6 And 30 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_contact_person_phone_must_be_between_6_and_30_chartacters_long()
    {
        $data['field_name'] = 'contact_person_phone';
        $data['field_value'] = array_rand([rand(1, 5), rand(31, 100)]);
        $data['error_message'] = "Polje Telefon lica za razgovor mora biti između 6 - 30 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Contact Person Phone Must Contain Only Numbers, Spaces And Plus Sign (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_contact_person_phone_must_contain_only_numbers_spaces_and_plus_sign()
    {
        $data['field_name'] = 'contact_person_phone';
        $data['field_value'] = rand(100000, 999999999) . "@_$";
        $data['error_message'] = "Polje Telefon lica za razgovor mora biti broj ili razmak.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Identification Must Be Numeric (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_identification_must_be_numeric()
    {
        $data['field_name'] = 'identification';
        $data['field_value'] = 'identification';
        $data['error_message'] = "Polje Matični broj firme mora biti broj.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Identification Must Be Between 6 And 45 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_identification_must_be_between_6_and_45_digits()
    {
        $data['field_name'] = 'identification';
        $data['field_value'] = array_rand([rand(1, 5), rand(46, 100)]);
        $data['error_message'] = "Polje Matični broj firme mora biti izemđu 6 i 45 cifri.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Identification Must Be Unique (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_identification_must_be_unique()
    {
        $data['field_name'] = 'identification';
        $data['field_value'] =  Legal::where('id', '!=', $this->legal->id)->first()->identification;
        $data['error_message'] = "Polje Matični broj firme već postoji.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client PIB Must Be Numeric (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_pib_must_be_numeric()
    {
        $data['field_name'] = 'pib';
        $data['field_value'] =  'numberpib';
        $data['error_message'] = "Polje PIB mora biti broj.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client PIB Must Be Between 6 And 45 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_pib_must_be_between_6_and_45_digits()
    {
        $data['field_name'] = 'pib';
        $data['field_value'] =  array_rand([rand(1, 5), rand(46, 100)]);
        $data['error_message'] = "Polje PIB mora biti izemđu 6 i 45 cifri.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client PIB Must Be Unique (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_pib_must_be_unique()
    {
        $data['field_name'] = 'pib';
        $data['field_value'] =  Legal::where('id', '!=', $this->legal->id)->first()->pib;
        $data['error_message'] = "Polje PIB već postoji.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Activity Must Be Maximimum 45 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_client_activity_must_be_maximum_255_characters_long()
    {
        $data['field_name'] = 'activity';
        $data['field_value'] =  str_random(256);
        $data['error_message'] = "Polje Delatnost mora sadržati manje od 255 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Address Must Be Minimum 2 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_address_must_be_minimum_2_characters_long()
    {
        $data['field_name'] = 'address';
        $data['field_value'] =  'a';
        $data['error_message'] = "Polje Adresa mora sadržati najmanje 2 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Address Must Be Maximimum 150 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_address_must_be_maximum_150_characters_long()
    {
        $data['field_name'] = 'address';
        $data['field_value'] =  str_random(151);
        $data['error_message'] = "Polje Adresa mora sadržati manje od 150 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client County Must Contain Only Letters, Spaces, Dots And Hyphens (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_county_must_contain_only_letters_spaces_dots_and_hyphens()
    {
        $data['field_name'] = 'county';
        $data['field_value'] =  'a$_(*&^)';
        $data['error_message'] = "Polje Opština može sadržati samo slova, razmake, tačke, srednje crte i apostrofe.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client County Must Be Minimum 2 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_county_must_be_minimum_2_characters_long()
    {
        $data['field_name'] = 'county';
        $data['field_value'] =  'a';
        $data['error_message'] = "Polje Opština mora sadržati najmanje 2 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client County Must Be Maximimum 45 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_client_county_must_be_maximum_45_characters_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', 'a', str_random(46));
        $data['field_name'] = 'county';
        $data['field_value'] =  $too_long_name;
        $data['error_message'] = "Polje Opština mora sadržati manje od 45 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Postal Must Be Numeric (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_postal_must_be_numeric()
    {
        $data['field_name'] = 'postal';
        $data['field_value'] =  'postal';
        $data['error_message'] = "Polje Poštanski broj mora biti broj.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Postal Must Contain 5 Digits (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_postal_must_contain_5_digits()
    {
        $data['field_name'] = 'postal';
        $data['field_value'] =  rand(1000, 9999);
        $data['error_message'] = "Polje Poštanski broj mora sadržati 5 cifri.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client City Must Contain Only Letters, Spaces, Dots And Hyphens (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_city_must_contain_only_letters_spaces_dots_and_hyphens()
    {
        $data['field_name'] = 'city';
        $data['field_value'] =  'a$_(*&^)';
        $data['error_message'] = "Polje Grad može sadržati samo slova, razmake, tačke, srednje crte i apostrofe.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client City Must Be Minimum 2 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_city_must_be_minimum_2_characters_long()
    {
        $data['field_name'] = 'city';
        $data['field_value'] =  'a';
        $data['error_message'] = "Polje Grad mora sadržati najmanje 2 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client City Must Be Maximimum 45 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_client_city_must_be_maximum_45_characters_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', 'a', str_random(46));
        $data['field_name'] = 'city';
        $data['field_value'] =  $too_long_name;
        $data['error_message'] = "Polje Grad mora sadržati manje od 45 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Website Must Be Maximimum 45 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_client_website_must_be_maximum_45_characters_long()
    {
        $data['field_name'] = 'website';
        $data['field_value'] = str_random(46);
        $data['error_message'] = "Polje Website mora sadržati manje od 45 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Comment Must Be Maximimum 5000 Characters Long (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_client_comment_must_be_maximum_5000_characters_long()
    {
        $data['field_name'] = 'comment';
        $data['field_value'] = str_random(5001);
        $data['error_message'] = "Polje Komentar mora sadržati manje od 5000 karaktera.";
        $this->store_legal_client_validation($data);
        $this->update_legal_client_validation($data);
    }

    /**
     * Test Store And Update Legal Client Company Size Id Must Be Numeric (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_client_company_size_id_must_be_integer()
    {
        $this->actingAs(self::$admin)
            ->post('/legal/create', [
                'company_size_id' => $company_size_id = 'a'])
            ->dontSeeInDatabase('legals', [
                'company_size_id' => $company_size_id
            ]);
        $this->actingAs(self::$admin)
            ->post('/legal/update/'. $this->legal->id, [
                'company_size_id' => $company_size_id = 'a'])
            ->dontSeeInDatabase('legals', [
                'id' => $this->legal->id,
                'company_size_id' => $company_size_id
            ]);
    }

    /**
     * Test Store And Update Legal Client Company Size Id Must Be Minimum 0 (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_company_size_id_must_be_minimum_0()
    {
        $this->actingAs(self::$admin)
            ->post('/legal/create', [
                'company_size_id' => $company_size_id = rand(-10, -1)])
            ->dontSeeInDatabase('legals', [
                'company_size_id' => $company_size_id
            ]);
        $this->actingAs(self::$admin)
            ->post('/legal/update/'. $this->legal->id, [
                'company_size_id' => $company_size_id = rand(-10, -1)])
            ->dontSeeInDatabase('legals', [
                'id' => $this->legal->id,
                'company_size_id' => $company_size_id
            ]);
    }

    /**
     * Test Store And Update Legal Client Company Size Id Must Be Maximimum 5 (LegalsController@store, LegalsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_client_company_size_id_must_be_maximum_5()
    {
        $this->actingAs(self::$admin)
            ->post('/legal/create', [
                'company_size_id' => $company_size_id = rand(6, 30)])
            ->dontSeeInDatabase('legals', [
                'company_size_id' => $company_size_id
            ]);
        $this->actingAs(self::$admin)
            ->post('/legal/update/'. $this->legal->id, [
                'company_size_id' => $company_size_id = rand(6, 30)])
            ->dontSeeInDatabase('legals', [
                'id' => $this->legal->id,
                'company_size_id' => $company_size_id
            ]);
    }

    /**
     * Test Store Legal Client Single Submit Must Be Numeric (LegalsController@store)
     *
     * @test
     * @return void
     */
    public function store_legal_client_single_submit_must_be_numeric()
    {
        $this->actingAs(self::$admin)
            ->visit('/legal/create')
            ->type('single_submit', 'single_submit')
            ->press('POTVRDI')
            ->seePageIs('/legal/create')
            ->see("Polje single submit mora biti broj.");
    }

    /**
     * Test Store Legal Client Single Submit Must Be Valid Time Value (LegalsController@store)
     *
     * @test
     * @return void
     */
    public function store_legal_client_single_submit_must_be_valid_time_value()
    {
        $this->actingAs(self::$admin)
            ->visit('/legal/create')
            ->type(time()+1, 'single_submit')
            ->press('POTVRDI')
            ->seePageIs('/legal/create')
            ->see("Onemogućeno je korišćenje dvoklika!");
    }


    /**
     *  Validate Store Legal Client (LegalsController@store)
     *
     * @param array $data
     * @return void
     */
    public function store_legal_client_validation($data)
    {
        $this->actingAs(self::$admin)
            ->visit('/legal/create')
            ->type($data['field_value'], $data['field_name'])
            ->press('POTVRDI')
            ->seePageIs('/legal/create')
            ->dontSeeInDatabase(
                'legals',
                [ 'id' => $this->legal->id, $data['field_name'] => $data['field_value'] ]
            )
            ->see($data['error_message']);
    }

    /**
     * Test False Store Legal Client With Get Method (LegalsController@store)
     *
     * @test
     * @return void
     */
    public function false_store_legal_client_with_get_method()
    {
        $this->actingAs(self::$admin)
        ->get('/legal/store', ['long_name' => $this->faker->company])
        ->assertResponseStatus(405)
        ->see('405 Something Went Wrong');
    }

    /**
     * Test Admin Can Store Legal Clients From File (LegalsController@store_file)
     *
     * @test
     * @return void
     */
    public function admin_can_store_legal_clients_from_file()
    {
        $this->actingAs(self::$admin)
        ->visit('/legals/create_from_file')
        ->attach($this->excel_file, 'excel_file')
        ->press('POTVRDI')
        ->see('Podaci su uspešno uneti u bazu.');
        $this->truncate_legal_individual_and_client_table();
    }

    /**
     * Test User Can Not Store Legal Clients From File (LegalsController@store_file)
     *
     * @test
     * @return void
     */
    public function user_can_not_store_legal_clients_from_file()
    {
        $this->actingAs(self::$user)
        ->visit('/legals/create_from_file')
        ->attach($this->excel_file, 'excel_file')
        ->press('POTVRDI')
        ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test Excel File Is Empty When Trying To Store Legal Clients From File As Admin (LegalsController@store_file)
     *
     * @test
     * @return void
    */
    public function excel_file_is_empty_when_trying_to_store_legal_clients_from_file_as_admin()
    {
        $original_empty_file = base_path('\tests\tmp\excel\empty_excel_file.xlsx');
        $empty_file = base_path('\tests\tmp\upload\empty_excel_file.xlsx');
        \File::copy($original_empty_file, $empty_file);
        $uploaded_file = new UploadedFile($empty_file, 'empty_excel_file.xlsx', 'xlsx', 2048000, null, $test = true);
        $this->actingAs(self::$admin)
            ->visit('/legals/create_from_file')
            ->attach($uploaded_file, 'excel_file')
            ->press('POTVRDI')
            ->see('Dokument je prazan!');
    }

    /**
     * Test  Excel File Invalid Header When Trying To Store Legal Clients From File As Admin (LegalsController@store_file)
     *
     * @test
     * @return void
    */
    public function excel_file_invalid_header_when_trying_to_store_legal_clients_from_file_as_admin()
    {
        $original_invalid_header = base_path('\tests\tmp\excel\invalid_header_excel_file.xlsx');
        $invalid_header = base_path('\tests\tmp\upload\invalid_header_excel_file.xlsx');
        \File::copy($original_invalid_header, $invalid_header);
        $uploaded_file = new UploadedFile($invalid_header, 'invalid_header_excel_file.xlsx', 'xlsx', 2048000, null, $test = true);
        $this->actingAs(self::$admin)
            ->visit('/legals/create_from_file')
            ->attach($uploaded_file, 'excel_file')
            ->press('POTVRDI')
            ->see('Greška! Neispravan naziv polja: Nazi');
    }


    /**
     * Test Store Legal Client From File Excel File Is Required (LegalsController@store_file)
     *
     * @test
     * @return void
     */
    public function store_legal_client_from_file_excel_file_is_required()
    {
        $this->actingAs(self::$admin)
            ->visit('/legals/create_from_file')
            ->attach('', 'excel_file')
            ->press('POTVRDI')
            ->see('Polje Excel je obavezno.');
    }

    /**
     * Test Store Legal Client From File Excel File Must Be File (LegalsController@store_file)
     *
     * @test
     * @return void
     */
    public function store_legal_client_from_file_excel_file_must_be_file()
    {
        $this->actingAs(self::$admin)
            ->visit('/legals/create_from_file')
            ->attach(rand(1, 5), 'excel_file')
            ->press('POTVRDI')
            ->see('Polje Excel je obavezno.');
    }

    /**
     * Test Store Legal Client From File Excel File Must Be File (LegalsController@store_file)
     *
     * @test
     * @return void
     */
    public function store_legal_client_from_file_excel_file_must_be_maximum_2048kb()
    {
        $file = base_path('\tests\tmp\excel\big_excel_file.xlsx');
        \File::put($file, $this->faker->text(3000000));
        $uploaded_file = new UploadedFile($file, 'big_excel_file.xlsx', 'xlsx', 2048000, null, $test = true);
        $this->actingAs(self::$admin)
            ->visit('/legals/create_from_file')
            ->attach($uploaded_file, 'excel_file')
            ->press('POTVRDI')
            ->see('Polje Excel mora biti manje od 2048 kilobajta.');
    }

    /**
     * Test Store Legal Client From File Excel File Must Be Valid Myme Type (LegalsController@store_file)
     *
     * @test
     * @return void
     */
    public function store_legal_client_from_file_excel_file_must_be_valid_myme_type()
    {
        $file = base_path('\tests\tmp\excel\wrong_myme_type.txt');
        \File::put($file, $this->faker->word);
        $uploaded_file = new UploadedFile($file, 'wrong_myme_type.txt', 'txt', 2048000, null, $test = true);
        $this->actingAs(self::$admin)
            ->visit('/legals/create_from_file')
            ->attach($uploaded_file, 'excel_file')
            ->press('POTVRDI')
            ->see('Polje Excel mora biti fajl tipa: xlsx, xls, xla, xlam, xlsm, xlt, xltx, xltm.');
    }

    /**
     * Test Store Legal Client From File Single Submit Must Be Numeric (LegalsController@store_file)
     *
     * @test
     * @return void
     */
    public function store_legal_client_from_file_single_submit_must_be_numeric()
    {
        $this->actingAs(self::$admin)
            ->visit('/legals/create_from_file')
            ->type('single_submit', 'single_submit')
            ->press('POTVRDI')
            ->seePageIs('/legals/create_from_file')
            ->see("Polje single submit mora biti broj.");
    }

    /**
     * Test Store Legal Client From File Single Submit Must Be Valid Time Value (LegalsController@store_file)
     *
     * @test
     * @return void
     */
    public function store_legal_client_from_file_single_submit_must_be_valid_time_value()
    {
        $this->actingAs(self::$admin)
            ->visit('/legals/create_from_file')
            ->type(time()+1, 'single_submit')
            ->press('POTVRDI')
            ->seePageIs('/legals/create_from_file')
            ->see("Onemogućeno je korišćenje dvoklika!");
    }

    /**
     * Test False Store Legal Clients From File With Get Method (LegalsController@store_file)
     *
     * @test
     * @return void
     */
    public function false_store_legal_clients_from_file_with_get_method()
    {
        $file = new UploadedFile($this->excel_file, 'excel_file.xlsx', 'xlsx', 2048000, null, $test = true);
        $this->actingAs(self::$admin)
             ->call('GET', '/legal/store_file', [], [], ['excel_file' => $file], []);
        $this->assertResponseStatus(405)
             ->see('405 Something Went Wrong');
    }

    /**
     * Test Admin Can Update Legal Client (LegalsController@update)
     *
     * @test
     * @return void
    */
    public function admin_can_update_legal_client()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/edit/' . $this->legal->id)
            ->type($ceo = $this->faker->name, 'ceo')
            ->press('POTVRDI')
            ->seePageIs('/client/edit/' . $this->legal->id)
            ->seeInDatabase('legals', ['id' => $this->legal->id, 'ceo' => $ceo])
            ->see('Profil je uspešno izmenjen.');
    }

    /**
     * Test User Can Not Update Legal Client (LegalsController@update)
     *
     * @test
     * @return void
    */
    public function user_can_not_update_legal_client()
    {
        $this->actingAs(self::$user)
            ->visit('/client/edit/' . $this->legal->id)
            ->type($ceo = $this->faker->name, 'ceo')
            ->press('POTVRDI')
            ->seePageIs('/client/edit/' . $this->legal->id)
            ->dontSeeInDatabase('legals', ['id' => $this->legal->id, 'ceo' => $ceo])
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     *  Validate Update Legal Client (LegalsController@update)
     *
     * @param array $data
     * @return void
     */
    public function update_legal_client_validation($data)
    {
        $this->actingAs(self::$admin)
            ->visit('/client/edit/' . $this->legal->client->id)
            ->type($data['field_value'], $data['field_name'])
            ->press('POTVRDI')
            ->seePageIs('/client/edit/' . $this->legal->client->id)
            ->dontSeeInDatabase(
                'legals',
                [ 'id' => $this->legal->id, $data['field_name'] => $data['field_value'] ]
            )
            ->see($data['error_message']);
    }

    /**
     * Test False Update Legal Client With Get Method (LegalsController@update)
     *
     * @test
     * @return void
     */
    public function false_update_legal_client_with_get_method()
    {
        $this->actingAs(self::$admin)
            ->get('/legal/update/' . $this->legal->id, ['long_name' => $this->faker->company])
            ->assertResponseStatus(405)
            ->see('405 Something Went Wrong');
    }

    /**
     * Test Admin Can Update Meeting Date For Legal With Accept Meeting Status (LegalsController@add_meeting_date)
     *
     * @test
     * @return void
    */
    public function admin_can_update_meeting_date_for_legal_with_accept_meeting_status()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->accept_meeting_legal->id)
            ->type($format_meeting_date = date("d.m.Y. H:i", strtotime("+1 day")), 'format_meeting_date')
            ->type($meeting_date = date("Y-m-d H:i", strtotime($format_meeting_date)), 'meeting_date')
            ->press('POTVRDI DATUM SASTANKA')
            ->seePageIs('/client/' . $this->accept_meeting_legal->id)
            ->seeInDatabase('legals', ['id' => $this->accept_meeting_legal->id, 'meeting_date' => $meeting_date])
            ->see('Datum sastanka je uspešno unet.');
        $this->truncate_legal_individual_and_client_table();
    }

    /**
     * Test User Can Not Update Meeting Date For Legal With Accept Meeting Status (LegalsController@add_meeting_date)
     *
     * @test
     * @return void
    */
    public function user_can_not_update_meeting_date_for_legal_with_accept_meeting_status()
    {
        $this->actingAs(self::$user)
            ->visit('/client/' . $this->accept_meeting_legal->id)
            ->type($format_meeting_date = date("d.m.Y. H:i", strtotime("+1 day")), 'format_meeting_date')
            ->type($meeting_date = date("Y-m-d H:i", strtotime($format_meeting_date)), 'meeting_date')
            ->press('POTVRDI DATUM SASTANKA')
            ->seePageIs('/client/' . $this->accept_meeting_legal->id)
            ->dontSeeInDatabase('legals', ['id' => $this->accept_meeting_legal->id, 'meeting_date' => $meeting_date])
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test Admin Can Not Update Meeting Date For Legals With Not Accept Meeting Status (LegalsController@add_meeting_date)
     *
     * @test
     * @return void
    */
    public function admin_can_not_update_meeting_date_for_legals_with_not_accept_meeting_status()
    {
        foreach ($this->non_accept_meeting_legals as $legal) {
            $this->actingAs(self::$admin)
                ->visit('/client/' . $legal->id)
                ->dontSee('POTVRDI DATUM SASTANKA');
        }
    }

    /**
     * Test User Can Not Update Meeting Date For Legals With Not Accept Meeting Status (LegalsController@add_meeting_date)
     *
     * @test
     * @return void
    */
    public function user_can_not_update_meeting_date_for_legals_with_not_accept_meeting_status()
    {
        foreach ($this->non_accept_meeting_legals as $legal) {
            $this->actingAs(self::$user)
                ->visit('/client/' . $legal->id)
                ->dontSee('POTVRDI DATUM SASTANKA');
        }
    }

    /**
     * Test Add Legal Client Fromat Meeting Date Must Be In Format d.m.Y. H:i (LegalsController@add_meeting_date)
     *
     * @test
     * @return void
    */
    public function add_legal_client_format_meeting_date_must_be_in_format_dmYHi()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->accept_meeting_legal->client->id)
            ->type($meeting_date = date('m-d-Y'), 'format_meeting_date')
            ->press('POTVRDI DATUM SASTANKA')
            ->seePageIs('/client/' . $this->accept_meeting_legal->client->id)
            ->dontSeeInDatabase(
                'legals',
                [ 'id' => $this->accept_meeting_legal->id, 'meeting_date' => $meeting_date ]
            )
            ->see('Polje Datum sastanka ne odgovora prema formatu d.m.Y. H:i.');
    }

    /**
     * Test Add Legal Client Meeting Date Must Be In Format Y-m-d H:i (LegalsController@add_meeting_date)
     *
     * @test
     * @return void
    */
    public function add_legal_client_meeting_date_must_be_in_format_YmdHi()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->accept_meeting_legal->client->id)
            ->type($meeting_date = date('m/Y/d H:i'), 'format_meeting_date')
            ->press('POTVRDI DATUM SASTANKA')
            ->seePageIs('/client/' . $this->accept_meeting_legal->client->id)
            ->dontSeeInDatabase(
                'legals',
                [ 'id' => $this->accept_meeting_legal->id, 'meeting_date' => $meeting_date ]
            )
            ->see('Polje Datum sastanka ne odgovora prema formatu d.m.Y. H:i.');
    }

    /**
     * Test False Update Legal Client Meeting Date With Get Method (LegalsController@add_meeting_date)
     *
     * @test
     * @return void
     */
    public function false_update_legal_client_meeting_date_with_get_method()
    {
        $this->actingAs(self::$admin)
            ->get('/legal/add_meeting_date/' . $this->accept_meeting_legal->id, [
                    'format_meeting_date' => $format_meeting_date = date("d.m.Y. H:i", strtotime("+1 day")),
                    'meeting_date' => $meeting_date = date("Y-m-d H:i", strtotime($format_meeting_date))
             ])
            ->assertResponseStatus(405)
            ->see('405 Something Went Wrong');
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
