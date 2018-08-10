<?php

use App\GlobalTraining;

class GlobalTrainingFeatureTest extends TestCase
{

    /**
     * Global Training
     *
     * @var App\GlobalTraining
     */
    protected static $global_training;

    /**
     * Creates Global Training
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(GlobalTraining::first())) {
            GlobalTraining::truncate();
            factory(GlobalTraining::class)->create();
        }
        if (is_null(self::$global_training)) {
            self::$global_training = GlobalTraining::first();
        }
    }

    /**
     * Test Admin Can See The Form For Editing Global Training (GlobalTrainingController@edit)
     *
     * @test
     * @return void
     */
    public function admin_can_see_form_for_editing_global_training()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->click('#gt_edit')
            ->seePageIs('/global_training/edit')
            ->see(self::$global_training->name)
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing Global Training As Admin (GlobalTrainingController@edit)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_global_training_as_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/global_training/edit')
            ->assertResponseStatus(200)
            ->assertViewHas('global_training');
    }

    /**
     * Test User Can See The Form For Editing Global Training (GlobalTrainingController@edit)
     *
     * @test
     * @return void
     */
    public function user_can_see_form_for_editing_global_training()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->click('#gt_edit')
            ->seePageIs('/global_training/edit')
            ->see(self::$global_training->name)
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing Global Training As User (GlobalTrainingController@edit)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_global_training_as_user()
    {
        $this->actingAs(self::$user)
            ->get('/global_training/edit')
            ->assertResponseStatus(200)
            ->assertViewHas('global_training');
    }

    /**
     * Test Admin Can Return From Global Training Edit Page To Home Page (GlobalTrainingController@edit)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_global_training_edit_page_to_home_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->visit('/global_training/edit')
            ->see(self::$global_training->name)
            ->click('Nazad')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

    /**
     * Test User Can Return From Global Training Edit Page To Home Page (GlobalTrainingController@edit)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_global_training_edit_page_to_home_page()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->visit('/global_training/edit')
            ->see(self::$global_training->name)
            ->click('Nazad')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

    /**
     * Test Admin Can Update Global Training (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function admin_can_update_global_training()
    {
        $a=$this->actingAs(self::$admin)
            ->visit('/global_training/edit')
            ->type($phone = '+381637722122', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/global_training/edit')
            ->seeInDatabase('global_trainings', ['id' => self::$global_training->id, 'phone' => $phone])
            ->see('Podaci su uspešno izmenjeni.');
    }

    /**
     * Test User Can Not Update Global Training (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function user_can_not_update_global_training()
    {
        $this->actingAs(self::$user)
            ->visit('/global_training/edit')
            ->type($phone = '+3811132636362', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/global_training/edit')
            ->dontSeeInDatabase('global_trainings', ['id' => self::$global_training->id, 'phone' => $phone])
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test Update Global Training Name Must Be Filled (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_name_must_be_filled()
    {
        $data['field_name'] = 'name';
        $data['field_value'] = '';
        $data['error_message'] = 'Polje Ime mora biti popunjeno.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Name Must Be Maximimu 150 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_name_must_be_maximum_150_characters_long()
    {
        $data['field_name'] = 'name';
        $data['field_value'] = str_random(151);
        $data['error_message'] = 'Polje Ime mora sadržati manje od 150 karaktera.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Representative Must Be Minimum 2 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_representative_must_be_minimum_2_characters_long()
    {
        $data['field_name'] = 'representative';
        $data['field_value'] = 'a';
        $data['error_message'] = 'Polje Ovlašćeni zastupnik mora sadržati najmanje 2 karaktera.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Representative Must Be Maximimum 45 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_representative_must_be_maximum_45_characters_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', 'a', str_random(46));
        $data['field_name'] = 'representative';
        $data['field_value'] = $too_long_name;
        $data['error_message'] = 'Polje Ovlašćeni zastupnik mora sadržati manje od 45 karaktera.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Representative Must Contain Only Letters, Spaces, Dots And Hyphens (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_representative_must_contain_only_letters_spaces_dots_and_hyphens()
    {
        $data['field_name'] = 'representative';
        $data['field_value'] = 'ad$_(*&^)';
        $data['error_message'] = 'Polje Ovlašćeni zastupnik može sadržati samo slova, razmake, tačke, srednje crte i apostrofe.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Phone Must Be Filled (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_phone_must_be_filled()
    {
        $data['field_name'] = 'phone';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Telefon mora biti popunjeno.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Phone Must Be Between 6 And 30 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_phone_must_be_between_6_and_30_chartacters_long()
    {
        $data['field_name'] = 'phone';
        $data['field_value'] = array_rand([rand(1, 5), rand(31, 100)]);
        $data['error_message'] = "Polje Telefon mora biti između 6 - 30 karaktera.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Phone Must Contain Only Numbers, Spaces And Plus Sign (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_phone_must_contain_only_numbers_spaces_and_plus_sign()
    {
        $data['field_name'] = 'phone';
        $data['field_value'] = rand(100000, 999999999) . "@_$";
        $data['error_message'] = "Polje Telefon mora biti broj ili razmak.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Email Must Be Filled (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_email_must_be_filled()
    {
        $data['field_name'] = 'email';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Email adresa mora biti popunjeno.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Email Must Be Minimum 7 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_email_must_be_minimum_7_characters_long()
    {
        $data['field_name'] = 'email';
        $data['field_value'] = 'a@r.rs';
        $data['error_message'] = " Polje Email adresa mora sadržati najmanje 7 karaktera.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Email Must Be Maximimum 150 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_email_must_be_maximum_150_characters_long()
    {
        $data['field_name'] = 'email';
        $data['field_value'] = str_random(151).'@gmail.com';
        $data['error_message'] = "Format polja Email adresa nije validan.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Email Format Is Invalid (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_email_format_is_invalid()
    {
        $data['field_name'] = 'email';
        $data['field_value'] = 'someemailadress.com';
        $data['error_message'] = "Format polja Email adresa nije validan.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Website Must Be Filled (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_website_must_be_filled()
    {
        $data['field_name'] = 'website';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Website mora biti popunjeno.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Website Must Be Minimum 4 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_website_must_be_minimum_4_characters_long()
    {
        $data['field_name'] = 'website';
        $data['field_value'] = str_random(3);
        $data['error_message'] = "Polje Website mora sadržati najmanje 4 karaktera.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Website Must Be Maximimum 45 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_website_must_be_maximum_45_characters_long()
    {
        $data['field_name'] = 'website';
        $data['field_value'] = str_random(46);
        $data['error_message'] = "Polje Website mora sadržati manje od 45 karaktera.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Address Must Be Filled (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_address_must_be_filled()
    {
        $data['field_name'] = 'address';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Adresa mora biti popunjeno.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Address Must Be Minimum 2 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_address_must_be_minimum_2_characters_long()
    {
        $data['field_name'] = 'address';
        $data['field_value'] = str_random(1);
        $data['error_message'] = "Polje Adresa mora sadržati najmanje 2 karaktera.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Address Must Be Maximimum 150 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_address_must_be_maximum_150_characters_long()
    {
        $data['field_name'] = 'address';
        $data['field_value'] = str_random(151);
        $data['error_message'] = "Polje Adresa mora sadržati manje od 150 karaktera.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training County Must Be Filled (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_county_must_be_filled()
    {
        $data['field_name'] = 'county';
        $data['field_value'] = '';
        $data['error_message'] = 'Polje Opština mora biti popunjeno.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training County Must Contain Only Letters, Spaces, Dots And Hyphens (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_county_must_contain_only_letters_spaces_dots_and_hyphens()
    {
        $data['field_name'] = 'county';
        $data['field_value'] = 'ad$_(*&^)';
        $data['error_message'] = 'Polje Opština može sadržati samo slova, razmake, tačke, srednje crte i apostrofe.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training County Must Be Minimum 2 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_county_must_be_minimum_2_characters_long()
    {
        $data['field_name'] = 'county';
        $data['field_value'] = 'a';
        $data['error_message'] = 'Polje Opština mora sadržati najmanje 2 karaktera.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training County Must Be Maximimum 45 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_county_must_be_maximum_45_characters_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', 'a', str_random(46));
        $data['field_name'] = 'county';
        $data['field_value'] = $too_long_name;
        $data['error_message'] = 'Polje Opština mora sadržati manje od 45 karaktera.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Postal Must Be Filled (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_postal_must_be_filled()
    {
        $data['field_name'] = 'postal';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Poštanski broj mora biti popunjeno.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Postal Must Be Numeric (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_postal_must_be_numeric()
    {
        $data['field_name'] = 'postal';
        $data['field_value'] = 'post1';
        $data['error_message'] = "Polje Poštanski broj mora biti broj.";
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Postal Must Contain 5 Digits (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_postal_must_contain_5_digits()
    {
        $data['field_name'] = 'postal';
        $data['field_value'] = rand(1000, 9999);
        $data['error_message'] = 'Polje Poštanski broj mora sadržati 5 cifri.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training City Must Be Filled (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_city_must_be_filled()
    {
        $data['field_name'] = 'city';
        $data['field_value'] = '';
        $data['error_message'] = 'Polje Grad mora biti popunjeno.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training City Must Contain Only Letters, Spaces, Dots And Hyphens (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_city_must_contain_only_letters_spaces_dots_and_hyphens()
    {
        $data['field_name'] = 'city';
        $data['field_value'] = 'ad$_(*&^)';
        $data['error_message'] = 'Polje Grad može sadržati samo slova, razmake, tačke, srednje crte i apostrofe.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training City Must Be Minimum 2 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_city_must_be_minimum_2_characters_long()
    {
        $data['field_name'] = 'city';
        $data['field_value'] = 'a';
        $data['error_message'] = 'Polje Grad mora sadržati najmanje 2 karaktera.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training City Must Be Maximimum 45 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_city_must_be_maximum_45_characters_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', 'a', str_random(46));
        $data['field_name'] = 'city';
        $data['field_value'] = $too_long_name;
        $data['error_message'] = 'Polje Grad mora sadržati manje od 45 karaktera.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Bank Must Be Filled (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_bank_must_be_filled()
    {
        $data['field_name'] = 'bank';
        $data['field_value'] = '';
        $data['error_message'] = 'Polje Banka mora biti popunjeno.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Bank Must Be Maximimum 45 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_bank_must_be_maximum_45_characters_long()
    {
        $data['field_name'] = 'bank';
        $data['field_value'] = str_random(46);
        $data['error_message'] = 'Polje Banka mora sadržati manje od 45 karaktera.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Account Must Be Filled (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_account_must_be_filled()
    {
        $data['field_name'] = 'account';
        $data['field_value'] = '';
        $data['error_message'] = 'Polje Račun mora biti popunjeno.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Account Must Be Numeric (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_account_must_be_numeric()
    {
        $data['field_name'] = 'account';
        $data['field_value'] = 'account' . rand(1, 100);
        $data['error_message'] = 'Polje Račun mora biti broj.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Account Must Be Between 6 And 45 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_account_must_be_between_6_and_45_digits_long()
    {
        $data['field_name'] = 'account';
        $data['field_value'] = array_rand([rand(1, 5), rand(46, 100)]);
        $data['error_message'] = 'Polje Račun mora biti izemđu 6 i 45 cifri.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training PIB Must Be Filled (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_pib_must_be_filled()
    {
        $data['field_name'] = 'pib';
        $data['field_value'] = '';
        $data['error_message'] = 'Polje PIB mora biti popunjeno.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training PIB Must Be Numeric (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_pib_must_be_numeric()
    {
        $data['field_name'] = 'pib';
        $data['field_value'] = 'pib' . rand(1, 100);
        $data['error_message'] = 'Polje PIB mora biti broj.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training PIB Must Be Between 6 And 45 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_pib_must_be_between_6_and_45_digits()
    {
        $data['field_name'] = 'pib';
        $data['field_value'] = array_rand([rand(1, 5), rand(46, 100)]);
        $data['error_message'] = 'Polje PIB mora biti izemđu 6 i 45 cifri.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Identification Must Be Filled (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_identification_must_be_filled()
    {
        $data['field_name'] = 'identification';
        $data['field_value'] = '';
        $data['error_message'] = 'Polje Matični broj firme mora biti popunjeno.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Identification Must Be Numeric (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_identification_must_be_numeric()
    {
        $data['field_name'] = 'identification';
        $data['field_value'] = 'identification' . rand(1, 100);
        $data['error_message'] = 'Polje Matični broj firme mora biti broj.';
        $this->update_global_training_validation($data);
    }

    /**
     * Test Update Global Training Identification Must Be Between 6 And 45 Characters Long (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function update_global_training_identification_must_be_between_6_and_45_digits()
    {
        $data['field_name'] = 'identification';
        $data['field_value'] = array_rand([rand(1, 5), rand(46, 100)]);
        $data['error_message'] = 'Polje Matični broj firme mora biti izemđu 6 i 45 cifri.';
        $this->update_global_training_validation($data);
    }

    /**
     *  Validate Update Global Training (GlobalTrainingController@update)
     *
     * @param array $data
     * @return void
     */
    public function update_global_training_validation($data)
    {
        $this->actingAs(self::$admin)
            ->visit('/global_training/edit')
            ->type($data['field_value'], $data['field_name'])
            ->press('POTVRDI IZMENU')
            ->seePageIs('/global_training/edit')
            ->dontSeeInDatabase(
                'global_trainings',
                [ 'id' => self::$global_training->id, $data['field_name'] => $data['field_value'] ]
            )
            ->see($data['error_message']);
    }

    /**
     * Test False Update Global Training With Get Method (GlobalTrainingController@update)
     *
     * @test
     * @return void
     */
    public function false_update_global_training_with_get_method()
    {
        $this->actingAs(self::$user)
            ->get('global_training/update/' . self::$global_training->id)
            ->assertResponseStatus(405)
            ->see('405 Something Went Wrong');
    }
}
