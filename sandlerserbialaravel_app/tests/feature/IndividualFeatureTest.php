<?php

use App\Individual;
use App\Legal;
use App\Client;

class IndividualFeatureTest extends TestCase
{
    /**
     * Individual Client
     *
     * @var App\Individual
     */
    protected $individual;

    /**
     * Accept Meeting Individual
     *      *
     * @var App\Individual
     */
    protected $accept_meeting_individual;

    /**
     * Non Accept Meeting Individuals
     *      *
     * @var App\Individual
     */
    protected $non_accept_meeting_individuals;
    
    /**
     * Faker
     *
     * @var Faker\Factory
     */
    protected $faker;


    /**
     * Creates Individual Client, Accept Meeting Individual, Non Accept Meeting Individuals, Faker And Individual Client Validation Data
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(Individual::first())) {
            factory(Individual::class)->create();
            factory(Individual::class, 'disqualified_without_meeting')->create();
            factory(Individual::class, 'disqualified_after_meeting')->create();
            factory(Individual::class, 'accept_meeting')->create();
            factory(Individual::class, 'jpb')->create();
            factory(Individual::class, 'inactive')->create();
            factory(Individual::class, 'active')->create();
        }

        if (is_null($this->individual)) {
            $this->individual = Individual::first();
        }

        if (is_null($this->accept_meeting_individual)) {
            $this->accept_meeting_individual = Individual::where('client_status_id', 3)->first();
        }

        if (is_null($this->non_accept_meeting_individuals)) {
            $this->non_accept_meeting_individuals = Individual::whereNotIn('client_status_id', [3])->get();
        }

        if (is_null($this->faker)) {
            $this->faker = Faker\Factory::create();
        }
    }

    /**
     * Test Admin Can See The Form For Creating Individual Client (IndividualsController@create)
     *
     * @test
     * @return void
    */
    public function admin_can_see_the_form_for_creating_individual_client()
    {
        $this->actingAs(self::$admin)
        ->visit('/home')
        ->click('Fizičko lice')
        ->seePageIs('/individual/create')
        ->see('Suspect - Fizičko lice')
        ->see('POTVRDI');
    }

    /**
     * Test Http Get Request Show The Form For Creating Individual Client As Admin (IndividualsController@create)
     *
     * @test
     * @return void
    */
    public function http_get_request_show_the_form_for_creating_individual_client_as_admin()
    {
        $this->actingAs(self::$admin)
           ->get('/individual/create')
        ->assertResponseStatus(200)
        ->assertViewHas(['current_time']);
    }

     /**
     * Test User Can See The Form For Creating Individual Client (IndividualsController@create)
     *
     * @test
     * @return void
    */
    public function user_can_see_the_form_for_creating_individual_client()
    {
        $this->actingAs(self::$user)
        ->visit('/home')
        ->click('Fizičko lice')
        ->seePageIs('/individual/create')
        ->see('Suspect - Fizičko lice')
        ->see('POTVRDI');
    }

    /**
     * Test Http Get Request Show The Form For Creating Individual Client As User (IndividualsController@create)
     *
     * @test
     * @return void
    */
    public function http_get_request_show_the_form_for_creating_individual_client_as_user()
    {
        $this->actingAs(self::$user)
           ->get('/individual/create')
        ->assertResponseStatus(200)
        ->assertViewHas(['current_time']);
    }

    /**
     * Test Admin Can Return From Create Individual Client Page To Previous Page (IndividualsController@create)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_create_individual_client_page_to_previous_page()
    {
        $this->actingAs(self::$admin)
        ->visit('/taxes/edit')
        ->visit('/individual/create')
        ->click('Nazad')
        ->seePageIs('/taxes/edit')
        ->see('Porez');
    }

    /**
     * Test User Can Return From Create Individual Client Page To Previous Page (IndividualsController@create)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_create_individual_client_page_to_previous_page()
    {
        $this->actingAs(self::$user)
        ->visit('/sandler/edit')
        ->visit('/individual/create')
        ->click('Nazad')
        ->seePageIs('/sandler/edit')
        ->see('Sandler procenat');
    }

    /**
     * Test Admin Can Store Individual Client (IndividualsController@store)
     *
     * @test
     * @return void
     */
    public function admin_can_store_individual_client()
    {
        $this->actingAs(self::$admin)
        ->visit('/individual/create')
        ->type($first_name = $this->faker->firstName, 'first_name')
        ->type($last_name = $this->faker->lastName, 'last_name')
        ->type($phone = $this->faker->unique()->e164PhoneNumber, 'phone')
        ->press('POTVRDI')
        ->seePageIs('/individual/create')
        ->see('Suspect ' . $first_name . ' ' . $last_name . ' je uspešno unet.');
    }

    /**
     * Test User Can Not Store Individual Client (IndividualsController@store)
     *
     * @test
     * @return void
     */
    public function user_can_not_store_individual_client()
    {
        $this->actingAs(self::$user)
        ->visit('/individual/create')
        ->type($first_name = $this->faker->firstName, 'first_name')
        ->type($last_name = $this->faker->lastName, 'last_name')
        ->type($phone = $this->faker->unique()->e164PhoneNumber, 'phone')
        ->press('POTVRDI')
        ->seePageIs('/individual/create')
        ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test Store And Update Individual Client First Name Is Required (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_individual_client_first_name_is_required()
    {
        $data['field_name'] = 'first_name';
        $data['field_value'] =  '';
        $data['error_message'] = "Polje Ime je obavezno.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client First Name Must Contain Only Letters, Spaces, Dots And Hyphens (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_first_name_must_contain_only_letters_spaces_dots_and_hyphens()
    {
        $data['field_name'] = 'first_name';
        $data['field_value'] =  'a$_(*&^)';
        $data['error_message'] = "Polje Ime može sadržati samo slova, razmake, tačke, srednje crte i apostrofe.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client First Name Must Be Minimum 2 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_first_name_must_be_minimum_2_characters_long()
    {
        $data['field_name'] = 'first_name';
        $data['field_value'] =  'a';
        $data['error_message'] = "Polje Ime mora sadržati najmanje 2 karaktera.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client First Name Must Be Maximimum 45 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_first_name_must_be_maximum_45_characters_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', 'a', str_random(46));
        $data['field_name'] = 'first_name';
        $data['field_value'] =  $too_long_name;
        $data['error_message'] = "Polje Ime mora sadržati manje od 45 karaktera.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Last Name Is Required (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_individual_client_last_name_is_required()
    {
        $data['field_name'] = 'last_name';
        $data['field_value'] =  '';
        $data['error_message'] = "Polje Prezime je obavezno.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Last Name Must Contain Only Letters, Spaces, Dots And Hyphens (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_last_name_must_contain_only_letters_spaces_dots_and_hyphens()
    {
        $data['field_name'] = 'last_name';
        $data['field_value'] =  'a$_(*&^)';
        $data['error_message'] = "Polje Prezime može sadržati samo slova, razmake, tačke, srednje crte i apostrofe.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Last Name Must Be Minimum 2 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_last_name_must_be_minimum_2_characters_long()
    {
        $data['field_name'] = 'last_name';
        $data['field_value'] =  'a';
        $data['error_message'] = "Polje Prezime mora sadržati najmanje 2 karaktera.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Last Name Must Be Maximimum 45 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_last_name_must_be_maximum_45_characters_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', 'a', str_random(46));
        $data['field_name'] = 'last_name';
        $data['field_value'] =  $too_long_name;
        $data['error_message'] = "Polje Prezime mora sadržati manje od 45 karaktera.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Phone Is Required (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_individual_client_phone_is_required()
    {
        $data['field_name'] = 'phone';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Telefon je obavezno.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Phone Must Contain Only Numbers, Spaces And Plus Sign (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_phone_must_contain_only_numbers_spaces_and_plus_sign()
    {
        $data['field_name'] = 'phone';
        $data['field_value'] = rand(100000, 999999999) . "@_$";
        $data['error_message'] = "Polje Telefon mora biti broj ili razmak.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Phone Must Be Between 6 And 30 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_phone_must_be_between_6_and_30_chartacters_long()
    {
        $data['field_name'] = 'phone';
        $data['field_value'] = array_rand([rand(1, 5), rand(31, 100)]);
        $data['error_message'] = "Polje Telefon mora biti između 6 - 30 karaktera.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Phone Must Be Unique (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_individual_client_phone_must_be_unique()
    {
        $data['field_name'] = 'phone';
        $data['field_value'] = Individual::where('id', '!=', $this->individual->id)->first()->phone;
        $data['error_message'] = "Polje Telefon već postoji.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Email Format Is Invalid (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_email_format_is_invalid()
    {
        $data['field_name'] = 'email';
        $data['field_value'] = 'someemailadress.com';
        $data['error_message'] = "Format polja Email adresa nije validan.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Email Must Be Minimum 7 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_email_must_be_minimum_7_characters_long()
    {
        $data['field_name'] = 'email';
        $data['field_value'] = 'a@r.rs';
        $data['error_message'] = "Polje Email adresa mora sadržati najmanje 7 karaktera.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Email Must Be Maximimum 150 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_email_must_be_maximum_150_characters_long()
    {
        $data['field_name'] = 'email';
        $data['field_value'] = str_random(151).'@gmail.com';
        $data['error_message'] = "Format polja Email adresa nije validan.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client JMBG Must Be Numeric (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_jmbg_must_be_numeric()
    {
        $data['field_name'] = 'jmbg';
        $data['field_value'] = 'jmbg';
        $data['error_message'] = "Polje JMBG mora biti broj.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client JMBG Must Be Between 13 And 45 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_identification_must_be_between_13_and_45_digits()
    {
        $data['field_name'] = 'jmbg';
        $data['field_value'] = array_rand([rand(1, 12), rand(46, 100)]);
        $data['error_message'] = "Polje JMBG mora biti izemđu 13 i 45 cifri.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client JMBG Must Be Unique (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_identification_must_be_unique()
    {
        $data['field_name'] = 'jmbg';
        $data['field_value'] = Individual::where('id', '!=', $this->individual->id)->first()->jmbg;
        $data['error_message'] = "Polje JMBG već postoji.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client ID Card Must Be Numeric (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_id_card_must_be_numeric()
    {
        $data['field_name'] = 'id_card';
        $data['field_value'] = 'id_card';
        $data['error_message'] = "Polje Broj lične karte mora biti broj.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client ID Card Must Be Between 6 And 45 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_id_card_must_be_between_6_and_45_digits()
    {
        $data['field_name'] = 'id_card';
        $data['field_value'] = array_rand([rand(1, 5), rand(46, 100)]);
        $data['error_message'] = "Polje Broj lične karte mora biti izemđu 6 i 45 cifri.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client ID Card Must Be Unique (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_id_card_must_be_unique()
    {
        $data['field_name'] = 'id_card';
        $data['field_value'] = Individual::where('id', '!=', $this->individual->id)->first()->id_card;
        $data['error_message'] = "Polje Broj lične karte već postoji.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Works At Must Be Maximimum 45 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_individual_client_works_at_must_be_maximum_45_characters_long()
    {
        $data['field_name'] = 'works_at';
        $data['field_value'] = str_random(46);
        $data['error_message'] = "Polje Zaposlen u mora sadržati manje od 45 karaktera.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Address Must Be Minimum 2 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_address_must_be_minimum_2_characters_long()
    {
        $data['field_name'] = 'address';
        $data['field_value'] = 'a';
        $data['error_message'] = "Polje Adresa mora sadržati najmanje 2 karaktera.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Address Must Be Maximimum 150 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_legal_client_address_must_be_maximum_150_characters_long()
    {
        $data['field_name'] = 'address';
        $data['field_value'] = str_random(151);
        $data['error_message'] = "Polje Adresa mora sadržati manje od 150 karaktera.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client County Must Contain Only Letters, Spaces, Dots And Hyphens (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_county_must_contain_only_letters_spaces_dots_and_hyphens()
    {
        $data['field_name'] = 'county';
        $data['field_value'] = 'ca$_(*&^)';
        $data['error_message'] = "Polje Opština može sadržati samo slova, razmake, tačke, srednje crte i apostrofe.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client County Must Be Minimum 2 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_county_must_be_minimum_2_characters_long()
    {
        $data['field_name'] = 'county';
        $data['field_value'] = 'a';
        $data['error_message'] = "Polje Opština mora sadržati najmanje 2 karaktera.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client County Must Be Maximimum 45 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_individual_client_county_must_be_maximum_45_characters_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', 'a', str_random(46));
        $data['field_name'] = 'county';
        $data['field_value'] = $too_long_name;
        $data['error_message'] = "Polje Opština mora sadržati manje od 45 karaktera.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Postal Must Be Numeric (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_postal_must_be_numeric()
    {
        $data['field_name'] = 'postal';
        $data['field_value'] = 'postal';
        $data['error_message'] = "Polje Poštanski broj mora biti broj.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Postal Must Contain 5 Digits (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_postal_must_contain_5_digits()
    {
        $data['field_name'] = 'postal';
        $data['field_value'] = rand(1000, 9999);
        $data['error_message'] = "Polje Poštanski broj mora sadržati 5 cifri.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client City Must Contain Only Letters, Spaces, Dots And Hyphens (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_city_must_contain_only_letters_spaces_dots_and_hyphens()
    {
        $data['field_name'] = 'city';
        $data['field_value'] = 'ad$_(*&^)';
        $data['error_message'] = "Polje Grad može sadržati samo slova, razmake, tačke, srednje crte i apostrofe.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client City Must Be Minimum 2 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function store_and_update_individual_client_city_must_be_minimum_2_characters_long()
    {
        $data['field_name'] = 'city';
        $data['field_value'] = 'a';
        $data['error_message'] = "Polje Grad mora sadržati najmanje 2 karaktera.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client City Must Be Maximimum 45 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_individual_client_city_must_be_maximum_45_characters_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', 'a', str_random(46));
        $data['field_name'] = 'city';
        $data['field_value'] = $too_long_name;
        $data['error_message'] = "Polje Grad mora sadržati manje od 45 karaktera.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store And Update Individual Client Comment Must Be Maximimum 5000 Characters Long (IndividualsController@store, IndividualsController@update)
     *
     * @test
     * @return void
    */
    public function store_and_update_legal_client_comment_must_be_maximum_5000_characters_long()
    {
        $data['field_name'] = 'comment';
        $data['field_value'] = str_random(5001);
        $data['error_message'] = "Polje Komentar mora sadržati manje od 5000 karaktera.";
        $this->store_individual_client_validation($data);
        $this->update_individual_client_validation($data);
    }

    /**
     * Test Store Individual Client Single Submit Must Be Numeric (IndividualsController@store)
     *
     * @test
     * @return void
     */
    public function store_individual_client_single_submit_must_be_numeric()
    {
        $this->actingAs(self::$admin)
            ->visit('/individual/create')
            ->type('single_submit', 'single_submit')
            ->press('POTVRDI')
            ->seePageIs('/individual/create')
            ->see("Polje single submit mora biti broj.");
    }

    /**
     * Test Store Individual Client Single Submit Must Be Valid Time Value (IndividualsController@store)
     *
     * @test
     * @return void
     */
    public function store_individual_client_single_submit_must_be_valid_time_value()
    {
        $this->actingAs(self::$admin)
            ->visit('/individual/create')
            ->type(time()+1, 'single_submit')
            ->press('POTVRDI')
            ->seePageIs('/individual/create')
            ->see("Onemogućeno je korišćenje dvoklika!");
    }

    /**
     *  Validate Store Individual Client (IndividualsController@store)
     *
     * @param array $data
     * @return void
     */
    public function store_individual_client_validation($data)
    {
        $this->actingAs(self::$admin)
            ->visit('/individual/create')
            ->type($data['field_value'], $data['field_name'])
            ->press('POTVRDI')
            ->seePageIs('/individual/create')
            ->dontSeeInDatabase(
                'individuals',
                [ 'id' => $this->individual->id, $data['field_name'] => $data['field_value'] ]
            )
            ->see($data['error_message']);
    }

    /**
     * Test False Store Individual Client With Get Method (IndividualsController@store)
     *
     * @test
     * @return void
     */
    public function false_store_individual_client_with_get_method()
    {
        $this->actingAs(self::$admin)
        ->get('/individual/store', [
            'first_name' => $first_name = $this->faker->firstName,
            'last_name' => $last_name = $this->faker->lastName,
            'phone' => $phone = $this->faker->unique()->e164PhoneNumber
        ])
        ->assertResponseStatus(405)
        ->see('405 Something Went Wrong');
    }

    /**
     * Test Admin Can Update Individual Client (IndividualsController@update)
     *
     * @test
     * @return void
    */
    public function admin_can_update_individual_client()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/edit/' . $this->individual->id)
            ->type($address = $this->faker->address, 'address')
            ->press('POTVRDI')
            ->seePageIs('/client/edit/' . $this->individual->id)
            ->seeInDatabase('individuals', ['id' => $this->individual->id, 'address' => $address])
            ->see('Profil je uspešno izmenjen.');
    }

    /**
     * Test User Can Not Update Individual Client (IndividualsController@update)
     *
     * @test
     * @return void
    */
    public function user_can_not_update_individual_client()
    {
        $this->actingAs(self::$user)
            ->visit('/client/edit/' . $this->individual->id)
            ->type($address = $this->faker->address, 'address')
            ->press('POTVRDI')
            ->seePageIs('/client/edit/' . $this->individual->id)
            ->dontSeeInDatabase('individuals', ['id' => $this->individual->id, 'address' => $address])
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test Http Post Request Update Individual Client As User (IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function http_post_request_update_individual_client_as_user()
    {
        $this->actingAs(self::$user)
            ->post('/individual/update/' . $this->individual->id, [
                'first_name' => $this->individual->first_name,
                'last_name' => $this->individual->last_name,
                'phone' => $this->individual->phone,
                'address' => $address = $this->faker->address,
            ])
            ->assertResponseStatus(302)
            ->dontSeeInDatabase('individuals', ['id' => $this->individual->id, 'address' => $address]);
    }

    /**
     *  Validate Update Individual Client (IndividualsController@update)
     *
     * @param array $data
     * @return void
     */
    public function update_individual_client_validation($data)
    {
        $this->actingAs(self::$admin)
            ->visit('/client/edit/' . $this->individual->client->id)
            ->type($data['field_value'], $data['field_name'])
            ->press('POTVRDI')
            ->seePageIs('/client/edit/' . $this->individual->client->id)
            ->dontSeeInDatabase(
                'individuals',
                [ 'id' => $this->individual->id, $data['field_name'] => $data['field_value'] ]
            )
            ->see($data['error_message']);
    }

    /**
     * Test False Update Individual Client With Get Method (IndividualsController@update)
     *
     * @test
     * @return void
     */
    public function false_update_individual_client_with_get_method()
    {
        $this->actingAs(self::$admin)
        ->get('/individual/update/' . $this->individual->id, [
                'first_name' => $this->individual->first_name,
                'last_name' => $this->individual->last_name,
                'phone' => $this->individual->phone
        ])
        ->assertResponseStatus(405)
        ->see('405 Something Went Wrong');
    }

    /**
     * Test Admin Can Update Meeting Date For Individual With Accept Meeting Status (IndividualsController@add_meeting_date)
     *
     * @test
     * @return void
    */
    public function admin_can_update_meeting_date_for_individual_with_accept_meeting_status()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->accept_meeting_individual->id)
            ->type($format_meeting_date = date("d.m.Y. H:i", strtotime("+1 day")), 'format_meeting_date')
            ->type($meeting_date = date("Y-m-d H:i", strtotime($format_meeting_date)), 'meeting_date')
            ->press('POTVRDI DATUM SASTANKA')
            ->seePageIs('/client/' . $this->accept_meeting_individual->id)
            ->seeInDatabase('individuals', ['id' => $this->accept_meeting_individual->id, 'meeting_date' => $meeting_date])
            ->see('Datum sastanka je uspešno unet.');
        $this->truncate_legal_individual_and_client_table();
    }


    /**
     * Test User Can Not Update Meeting Date For Individual With Accept Meeting Status (IndividualsController@add_meeting_date)
     *
     * @test
     * @return void
    */
    public function user_can_not_update_meeting_date_for_individual_with_accept_meeting_status()
    {
        $this->actingAs(self::$user)
            ->visit('/client/' . $this->accept_meeting_individual->id)
            ->type($format_meeting_date = date("d.m.Y. H:i", strtotime("+1 day")), 'format_meeting_date')
            ->type($meeting_date = date("Y-m-d H:i", strtotime($format_meeting_date)), 'meeting_date')
            ->press('POTVRDI DATUM SASTANKA')
            ->seePageIs('/client/' . $this->accept_meeting_individual->id)
            ->dontSeeInDatabase('individuals', ['id' => $this->accept_meeting_individual->id, 'meeting_date' => $meeting_date])
            ->see('Nemate ovlašćenje za ovu akciju!');
    }


    /**
     * Test Admin Can Not Update Meeting Date For Individuals With Not Accept Meeting Status (IndividualsController@add_meeting_date)
     *
     * @test
     * @return void
    */
    public function admin_can_not_update_meeting_date_for_individuals_with_not_accept_meeting_status()
    {
        foreach ($this->non_accept_meeting_individuals as $individual) {
            $this->actingAs(self::$admin)
                ->visit('/client/' . $individual->id)
                ->dontSee('POTVRDI DATUM SASTANKA');
        }
    }

    /**
     * Test Http Post Request Update Meeting Date For Individuals With Non Accept Meeting Status As Admin (IndividualsController@add_meeting_date)
     *
     * @test
     * @return void
     */
    public function http_post_request_update_meeting_date_for_individuals_with_non_accept_meeting_status_as_admin()
    {
        foreach ($this->non_accept_meeting_individuals as $individual) {
            $this->actingAs(self::$admin)
                ->post('/individual/add_meeting_date/' . $individual->id, [
                    'format_meeting_date' => $format_meeting_date = date("d.m.Y. H:i", strtotime("+1 day")),
                    'meeting_date' => $meeting_date = date("Y-m-d H:i", strtotime($format_meeting_date))
                ])
                ->assertResponseStatus(302)
                ->dontSeeInDatabase('individuals', ['id' => $individual->id, 'meeting_date' => $meeting_date]);
        }
    }

    /**
     * Test User Can Not Update Meeting Date For Individuals With Not Accept Meeting Status (IndividualsController@add_meeting_date)
     *
     * @test
     * @return void
    */
    public function user_can_not_update_meeting_date_for_individuals_with_not_accept_meeting_status()
    {
        foreach ($this->non_accept_meeting_individuals as $individual) {
            $this->actingAs(self::$user)
                ->visit('/client/' . $individual->id)
                ->dontSee('POTVRDI DATUM SASTANKA');
        }
    }

    /**
     * Test Http Post Request Update Meeting Date For Individuals With Non Accept Meeting Status As User (IndividualsController@add_meeting_date)
     *
     * @test
     * @return void
     */
    public function http_post_request_update_meeting_date_for_individuals_with_non_accept_meeting_status_as_user()
    {
        foreach ($this->non_accept_meeting_individuals as $individual) {
            $this->actingAs(self::$user)
                ->post('/individual/add_meeting_date/' . $individual->id, [
                    'format_meeting_date' => $format_meeting_date = date("d.m.Y. H:i", strtotime("+1 day")),
                    'meeting_date' => $meeting_date = date("Y-m-d H:i", strtotime($format_meeting_date))
                ])
                ->assertResponseStatus(302)
                ->dontSeeInDatabase('individuals', ['id' => $individual->id, 'meeting_date' => $meeting_date]);
        }
    }

    /**
     * Test Add Individual Client Fromat Meeting Date Must Be In Format d.m.Y. H:i (IndividualsController@add_meeting_date)
     *
     * @test
     * @return void
    */
    public function add_individual_client_format_meeting_date_must_be_in_format_dmYHi()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->accept_meeting_individual->client->id)
            ->type($meeting_date = date('m-d-Y'), 'format_meeting_date')
            ->press('POTVRDI DATUM SASTANKA')
            ->seePageIs('/client/' . $this->accept_meeting_individual->client->id)
            ->dontSeeInDatabase(
                'individuals',
                [ 'id' => $this->accept_meeting_individual->id, 'meeting_date' => $meeting_date ]
            )
            ->see('Polje Datum sastanka ne odgovora prema formatu d.m.Y. H:i.');
    }

    /**
     * Test Add Individual Client Meeting Date Must Be In Format Y-m-d H:i (IndividualsController@add_meeting_date)
     *
     * @test
     * @return void
    */
    public function add_individual_client_meeting_date_must_be_in_format_YmdHi()
    {
        $this->actingAs(self::$admin)
            ->visit('/client/' . $this->accept_meeting_individual->client->id)
            ->type($meeting_date = date('m/Y/d H:i'), 'format_meeting_date')
            ->press('POTVRDI DATUM SASTANKA')
            ->seePageIs('/client/' . $this->accept_meeting_individual->client->id)
            ->dontSeeInDatabase(
                'individuals',
                [ 'id' => $this->accept_meeting_individual->id, 'meeting_date' => $meeting_date ]
            )
            ->see('Polje Datum sastanka ne odgovora prema formatu d.m.Y. H:i.');
    }

    /**
     * Test False Update Individual Client Meeting Date With Get Method (IndividualsController@add_meeting_date)
     *
     * @test
     * @return void
     */
    public function false_update_individual_client_meeting_date_with_get_method()
    {
        $this->actingAs(self::$admin)
        ->get('/individual/add_meeting_date/' . $this->accept_meeting_individual->id, [
                'format_meeting_date' => $format_meeting_date = date("d.m.Y. H:i", strtotime("+1 day")),
                'meeting_date' => $meeting_date = date("Y-m-d H:i", strtotime($format_meeting_date))
         ])
        ->assertResponseStatus(405)
        ->see('405 Something Went Wrong');
    }

    /**
     * Test Truncate Individual, Legal And CLient Table
     *
     * @test
     * @return void
   */
    public function truncate_legal_individual_and_client_table()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Individual::truncate();
        Legal::truncate();
        Client::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->assertNull(Individual::first());
        $this->assertNull(Legal::first());
        $this->assertNull(Client::first());
    }
}
