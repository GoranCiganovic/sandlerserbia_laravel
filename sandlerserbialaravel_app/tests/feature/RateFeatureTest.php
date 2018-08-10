<?php

use App\Rate;

class RateFeatureTest extends TestCase
{
    /**
     * Rate
     *
     * @var \App\Rate
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

        if (is_null(self::$rate)) {
            self::$rate = Rate::first();
        }
    }

    /**
     * Test Admin Can See The Form For Editing Taxes (RatesController@edit_taxes)
     *
     * @test
     * @return void
     */
    public function admin_can_see_form_for_editing_taxes()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->click('#taxes_edit')
            ->seePageIs('/taxes/edit')
            ->see(self::$rate->pdv)
            ->see(self::$rate->pdv_paying_day)
            ->see(self::$rate->ppo)
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing Taxes As Admin (RatesController@edit_taxes)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_taxes_as_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/taxes/edit')
            ->assertResponseStatus(200)
            ->assertViewHas('rate');
    }

    /**
     * Test User Can See The Form For Editing Taxes (RatesController@edit_taxes)
     *
     * @test
     * @return void
     */
    public function user_can_see_form_for_editing_taxes()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->click('#taxes_edit')
            ->seePageIs('/taxes/edit')
            ->see(self::$rate->pdv)
            ->see(self::$rate->pdv_paying_day)
            ->see(self::$rate->ppo)
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing Taxes As User (RatesController@edit_taxes)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_taxes_as_user()
    {
        $this->actingAs(self::$user)
            ->get('/taxes/edit')
            ->assertResponseStatus(200)
            ->assertViewHas('rate');
    }

    /**
     * Test Admin Can Return From Taxes Edit Page To Home Page (RatesController@edit_taxes)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_taxes_edit_page_to_home_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->visit('/taxes/edit')
            ->see('Porez')
            ->click('Nazad')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

    /**
     * Test User Can Return From Taxes Edit Page To Home Page (RatesController@edit_taxes)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_taxes_edit_page_to_home_page()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->visit('/taxes/edit')
            ->see('Porez')
            ->click('Nazad')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

    /**
     * Test Admin Can See The Form For Editing Sandler (RatesController@edit_sandler)
     *
     * @test
     * @return void
     */
    public function admin_can_see_form_for_editing_sandler()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->click('#sandler_edit')
            ->seePageIs('/sandler/edit')
            ->see(self::$rate->sandler)
            ->see(self::$rate->sandler_paying_day)
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing Sandler As Admin (RatesController@edit_sandler)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_sandler_as_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/sandler/edit')
            ->assertResponseStatus(200)
            ->assertViewHas('rate');
    }

    /**
     * Test User Can See The Form For Editing Sandler (RatesController@edit_sandler)
     *
     * @test
     * @return void
     */
    public function user_can_see_form_for_editing_sandler()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->click('#sandler_edit')
            ->seePageIs('/sandler/edit')
            ->see(self::$rate->sandler)
            ->see(self::$rate->sandler_paying_day)
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing Sandler As User (RatesController@edit_sandler)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_sandler_as_user()
    {
        $this->actingAs(self::$user)
            ->get('/sandler/edit')
            ->assertResponseStatus(200)
            ->assertViewHas('rate');
    }

    /**
     * Test Admin Can Return From Sandler Edit Page To Home Page (RatesController@edit_sandler)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_sandler_edit_page_to_home_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->visit('/sandler/edit')
            ->see('Sandler procenat')
            ->click('Nazad')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

    /**
     * Test User Can Return From Sandler Edit Page To Home Page (RatesController@edit_sandler)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_sandler_edit_page_to_home_page()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->visit('/sandler/edit')
            ->see('Sandler procenat')
            ->click('Nazad')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

    /**
     * Test Admin Can See The Form For Editing Disc Devine (RatesController@edit_disc_devine)
     *
     * @test
     * @return void
     */
    public function admin_can_see_form_for_editing_disc_devine()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->click('#dd_edit')
            ->seePageIs('/disc_devine/edit')
            ->see(self::$rate->disc)
            ->see(self::$rate->devine)
            ->see(self::$rate->dd_paying_day)
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing Disc Devine As Admin (RatesController@edit_disc_devine)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_disc_devine_as_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/disc_devine/edit')
            ->assertResponseStatus(200)
            ->assertViewHas('rate');
    }

    /**
     * Test User Can See The Form For Editing Disc Devine (RatesController@edit_disc_devine)
     *
     * @test
     * @return void
     */
    public function user_can_see_form_for_editing_disc_devine()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->click('#dd_edit')
            ->seePageIs('/disc_devine/edit')
            ->see(self::$rate->disc)
            ->see(self::$rate->devine)
            ->see(self::$rate->dd_paying_day)
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing Disc Devine As User (RatesController@edit_disc_devine)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_disc_devine_as_user()
    {
        $this->actingAs(self::$user)
            ->get('/disc_devine/edit')
            ->assertResponseStatus(200)
            ->assertViewHas('rate');
    }

    /**
     * Test Admin Can Return From Disc Devine Edit Page To Home Page (RatesController@edit_disc_devine)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_disc_devine_edit_page_to_home_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->visit('/disc_devine/edit')
            ->see('DISC/Devine')
            ->click('Nazad')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

    /**
     * Test User Can Return From Disc Devine Edit Page To Home Page (RatesController@edit_disc_devine)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_disc_devine_edit_page_to_home_page()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->visit('/disc_devine/edit')
            ->see('DISC/Devine')
            ->click('Nazad')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

    /**
     * Test Admin Can Update Rate Taxes (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function admin_can_update_rate_taxes()
    {
        $this->actingAs(self::$admin)
            ->visit('/taxes/edit')
            ->type($pdv = 18.00, 'pdv')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/taxes/edit')
            ->seeInDatabase('rates', ['id' => self::$rate->id, 'pdv' => $pdv])
            ->see('Podaci su uspešno izmenjeni.');
    }

    /**
     * Test User Can Not Update Rate Taxes (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function user_can_not_update_rate_taxes()
    {
        $this->actingAs(self::$user)
            ->visit('/taxes/edit')
            ->type($pdv = 16.00, 'pdv')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/taxes/edit')
            ->dontSeeInDatabase('rates', ['id' => self::$rate->id, 'pdv' => $pdv])
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test Update Rate Taxes Pdv Must Be Filled (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function update_rate_taxes_pdv_must_be_filled()
    {
        $data['rate_type'] = 'taxes';
        $data['field_name'] = 'pdv';
        $data['field_value'] = '';
        $data['error_message'] = "Polje PDV (procenat) mora biti popunjeno.";
        $this->update_rate_validation($data);
    }

    /**
     * Test Update Rate Taxes Pdv Must Be Numeric (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function update_rate_taxes_pdv_must_be_numeric()
    {
        $data['rate_type'] = 'taxes';
        $data['field_name'] = 'pdv';
        $data['field_value'] = 'pdv';
        $data['error_message'] = "Polje PDV (procenat) mora biti broj.";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Taxes Pdv Must Be Minimum 0 (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function update_rate_taxes_pdv_must_be_minimum_0()
    {
        $data['rate_type'] = 'taxes';
        $data['field_name'] = 'pdv';
        $data['field_value'] = rand(-100, -1);
        $data['error_message'] = "Polje PDV (procenat) mora biti najmanje 0.";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Taxes Pdv Must Be Maximum 100 (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function update_rate_taxes_pdv_must_be_maximum_100()
    {
        $data['rate_type'] = 'taxes';
        $data['field_name'] = 'pdv';
        $data['field_value'] = rand(101, 1000);
        $data['error_message'] = "Polje PDV (procenat) mora biti manje od 100.";
        $this->update_rate_validation($data);
    }


    /**
     * Test Update Rate Taxes Pdv Paying Day Must Be Filled (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function update_rate_taxes_pdv_paying_day_must_be_filled()
    {
        $data['rate_type'] = 'taxes';
        $data['field_name'] = 'pdv_paying_day';
        $data['field_value'] = '';
        $data['error_message'] = "";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Taxes Pdv Paying Day Must Be Integer (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function update_rate_taxes_pdv_paying_day_must_be_integer()
    {
        $data['rate_type'] = 'taxes';
        $data['field_name'] = 'pdv_paying_day';
        $data['field_value'] = 'pdv_paying_day';
        $data['error_message'] = "";
        $this->update_rate_validation($data);
    }

    /**
     * Test Update Rate Taxes Pdv Paying Day Must Be Minimum 1 (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function update_rate_taxes_pdv_paying_day_must_be_minimum_1()
    {

        $data['rate_type'] = 'taxes';
        $data['field_name'] = 'pdv_paying_day';
        $data['field_value'] = rand(-100, -1);
        $data['error_message'] = "";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Taxes Pdv Paying Day Must Be Maximum 30 (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function update_rate_taxes_pdv_paying_day_must_be_maximum_30()
    {
        $data['rate_type'] = 'taxes';
        $data['field_name'] = 'pdv_paying_day';
        $data['field_value'] = rand(31, 100);
        $data['error_message'] = "";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Taxes Ppo Must Be Filled (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function update_rate_taxes_ppo_must_be_filled()
    {
        $data['rate_type'] = 'taxes';
        $data['field_name'] = 'ppo';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Porez po odbitku (procenat) mora biti popunjeno.";
        $this->update_rate_validation($data);
    }

    /**
     * Test Update Rate Taxes Ppo Must Be Numeric (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function update_rate_taxes_ppo_must_be_numeric()
    {
        $data['rate_type'] = 'taxes';
        $data['field_name'] = 'ppo';
        $data['field_value'] = 'ppo';
        $data['error_message'] = "Polje Porez po odbitku (procenat) mora biti broj.";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Taxes Ppo Must Be Minimum 0 (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function update_rate_taxes_ppo_must_be_minimum_0()
    {
        $data['rate_type'] = 'taxes';
        $data['field_name'] = 'ppo';
        $data['field_value'] =  rand(-100, -1);
        $data['error_message'] = "Polje Porez po odbitku (procenat) mora biti najmanje 0.";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Taxes Ppo Must Be Maximum 100 (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function update_rate_taxes_ppo_must_be_maximum_100()
    {
        $data['rate_type'] = 'taxes';
        $data['field_name'] = 'ppo';
        $data['field_value'] =  rand(101, 1000);
        $data['error_message'] = "Polje Porez po odbitku (procenat) mora biti manje od 100.";
        $this->update_rate_validation($data);
    }

    /**
     * Test False Update Rate With Get Method (RatesController@update_taxes)
     *
     * @test
     * @return void
     */
    public function false_update_rate_taxes_with_get_method()
    {
        $this->actingAs(self::$user)
            ->get('taxes/update/' . self::$rate)
            ->assertResponseStatus(405)
            ->see('405 Something Went Wrong');
    }
    
    /**
     * Test Admin Can Update Rate Sandler (RatesController@update_sandler)
     *
     * @test
     * @return void
     */
    public function admin_can_update_rate_sandler()
    {
        $this->actingAs(self::$admin)
            ->visit('/sandler/edit')
            ->type($sandler = 16.00, 'sandler')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/sandler/edit')
            ->seeInDatabase('rates', ['id' => self::$rate->id, 'sandler' => $sandler])
            ->see('Podaci su uspešno izmenjeni.');
    }

    /**
     * Test User Can Not Update Rate Sandler (RatesController@update_sandler)
     *
     * @test
     * @return void
     */
    public function user_can_not_update_rate_sandler()
    {
        $this->actingAs(self::$user)
            ->visit('/sandler/edit')
            ->type($sandler = 14.00, 'sandler')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/sandler/edit')
            ->dontSeeInDatabase('rates', ['id' => self::$rate->id, 'sandler' => $sandler])
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test Update Rate Sandler Must Be Filled (RatesController@update_sandler)
     *
     * @test
     * @return void
     */
    public function update_rate_sandler_must_be_filled()
    {
        $data['rate_type'] = 'sandler';
        $data['field_name'] = 'sandler';
        $data['field_value'] =  '';
        $data['error_message'] = "Polje Sandler (procenat) mora biti popunjeno.";
        $this->update_rate_validation($data);
    }

    /**
     * Test Update Rate Sandler Must Be Numeric (RatesController@update_sandler)
     *
     * @test
     * @return void
     */
    public function update_rate_sandler_must_be_numeric()
    {
        $data['rate_type'] = 'sandler';
        $data['field_name'] = 'sandler';
        $data['field_value'] =  'sandler';
        $data['error_message'] = "Polje Sandler (procenat) mora biti broj.";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Sandler Must Be Minimum 0 (RatesController@update_sandler)
     *
     * @test
     * @return void
     */
    public function update_rate_sandler_must_be_minimum_0()
    {
        $data['rate_type'] = 'sandler';
        $data['field_name'] = 'sandler';
        $data['field_value'] =  rand(-100, -1);
        $data['error_message'] = "Polje Sandler (procenat) mora biti najmanje 0.";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Sandler Must Be Maximum 100 (RatesController@update_sandler)
     *
     * @test
     * @return void
     */
    public function update_rate_sandler_must_be_maximum_100()
    {
        $data['rate_type'] = 'sandler';
        $data['field_name'] = 'sandler';
        $data['field_value'] =  rand(101, 1000);
        $data['error_message'] = "Polje Sandler (procenat) mora biti manje od 100.";
        $this->update_rate_validation($data);
    }

    /**
     * Test Update Rate Sandler Paying Day Must Be Filled (RatesController@update_sandler)
     *
     * @test
     * @return void
     */
    public function update_rate_sandler_paying_day_must_be_filled()
    {
        $data['rate_type'] = 'sandler';
        $data['field_name'] = 'sandler_paying_day';
        $data['field_value'] =  '';
        $data['error_message'] = "Polje Dan plaćanja u mesecu mora biti popunjeno.";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Sandler Paying Day Must Be Integer (RatesController@update_sandler)
     *
     * @test
     * @return void
     */
    public function update_rate_sandler_paying_day_must_be_integer()
    {
        $data['rate_type'] = 'sandler';
        $data['field_name'] = 'sandler_paying_day';
        $data['field_value'] =  'sandler_paying_day';
        $data['error_message'] = "Polje Dan plaćanja u mesecu mora biti broj.";
        $this->update_rate_validation($data);
    }

    /**
     * Test Update Rate Sandler Paying Day Must Be Minimum 1 (RatesController@update_sandler)
     *
     * @test
     * @return void
     */
    public function update_rate_sandler_paying_day_must_be_minimum_1()
    {
        $data['rate_type'] = 'sandler';
        $data['field_name'] = 'sandler_paying_day';
        $data['field_value'] =  rand(-100, -1);
        $data['error_message'] = "Polje Dan plaćanja u mesecu mora biti najmanje 1.";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Sandler Paying Day Must Be Maximum 30 (RatesController@update_sandler)
     *
     * @test
     * @return void
     */
    public function update_rate_sandler_paying_day_must_be_maximum_30()
    {
        $data['rate_type'] = 'sandler';
        $data['field_name'] = 'sandler_paying_day';
        $data['field_value'] =  rand(31, 100);
        $data['error_message'] = "Polje Dan plaćanja u mesecu mora biti manje od 30.";
        $this->update_rate_validation($data);
    }

    /**
     * Test False Update Rate Sandler With Get Method (RatesController@update_sandler)
     *
     * @test
     * @return void
     */
    public function false_update_rate_sandler_with_get_method()
    {
        $this->actingAs(self::$user)
            ->get('sandler/update/' . self::$rate)
            ->assertResponseStatus(405)
            ->see('405 Something Went Wrong');
    }

    /**
     * Test Admin Can Update Rate Disc Devine (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function admin_can_update_rate_disc_devine()
    {
        $this->actingAs(self::$admin)
            ->visit('/disc_devine/edit')
            ->type($disc = 25, 'disc')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/disc_devine/edit')
            ->seeInDatabase('rates', ['id' => self::$rate->id, 'disc' => $disc])
            ->see('Podaci su uspešno izmenjeni.');
    }

    /**
     * Test User Can Not Update Rate Disc Devine (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function user_can_not_update_rate_disc_devine()
    {
        $this->actingAs(self::$user)
            ->visit('/disc_devine/edit')
            ->type($disc = 45, 'disc')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/disc_devine/edit')
            ->dontSeeInDatabase('rates', ['id' => self::$rate->id, 'disc' => $disc])
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

     /**
     * Test Update Rate Disc Must Be Filled (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function update_rate_disc_must_be_filled()
    {
        $data['rate_type'] = 'disc_devine';
        $data['field_name'] = 'disc';
        $data['field_value'] =  '';
        $data['error_message'] = "Polje DISC iznos u dolarima mora biti popunjeno.";
        $this->update_rate_validation($data);
    }

    /**
     * Test Update Rate Disc Must Be Numeric (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function update_rate_disc_must_be_numeric()
    {
        $data['rate_type'] = 'disc_devine';
        $data['field_name'] = 'disc';
        $data['field_value'] =  'disc';
        $data['error_message'] = "Polje DISC iznos u dolarima mora biti broj.";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Disc Must Be Minimum 0 (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function update_rate_disc_must_be_minimum_0()
    {
        $data['rate_type'] = 'disc_devine';
        $data['field_name'] = 'disc';
        $data['field_value'] =  rand(-100, -1);
        $data['error_message'] = "Polje DISC iznos u dolarima mora biti najmanje 0.";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Disc Must Be Maximum 1000 (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function update_rate_disc_must_be_maximum_1000()
    {
        $data['rate_type'] = 'disc_devine';
        $data['field_name'] = 'disc';
        $data['field_value'] =  rand(1001, 9999);
        $data['error_message'] = "Polje DISC iznos u dolarima mora biti manje od 1000.";
        $this->update_rate_validation($data);
    }

    /**
     * Test Update Rate Devine Must Be Filled (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function update_rate_devine_must_be_filled()
    {
        $data['rate_type'] = 'disc_devine';
        $data['field_name'] = 'devine';
        $data['field_value'] =  '';
        $data['error_message'] = "Polje Devine iznos u dolarima mora biti popunjeno.";
        $this->update_rate_validation($data);
    }

    /**
     * Test Update Rate Devine Must Be Numeric (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function update_rate_devine_must_be_numeric()
    {
        $data['rate_type'] = 'disc_devine';
        $data['field_name'] = 'devine';
        $data['field_value'] =  'devine';
        $data['error_message'] = "Polje Devine iznos u dolarima mora biti broj.";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Devine Must Be Minimum 0 (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function update_rate_devine_must_be_minimum_0()
    {
        $data['rate_type'] = 'disc_devine';
        $data['field_name'] = 'devine';
        $data['field_value'] =  rand(-100, -1);
        $data['error_message'] = "Polje Devine iznos u dolarima mora biti najmanje 0.";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Rate Devine Must Be Maximum 1000 (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function update_rate_devine_must_be_maximum_1000()
    {
        $data['rate_type'] = 'disc_devine';
        $data['field_name'] = 'devine';
        $data['field_value'] =  rand(1001, 9999);
        $data['error_message'] = "Polje Devine iznos u dolarima mora biti manje od 1000.";
        $this->update_rate_validation($data);
    }

    /**
     * Test Update Taxes DiscDevine Paying Day Must Be Filled (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function update_taxes_dd_paying_day_must_be_filled()
    {
        $data['rate_type'] = 'disc_devine';
        $data['field_name'] = 'dd_paying_day';
        $data['field_value'] =  '';
        $data['error_message'] = "Polje Dan plaćanja u mesecu mora biti popunjeno.";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Taxes DiscDevine Paying Day Must Be Integer (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function update_taxes_dd_paying_day_must_be_integer()
    {
        $data['rate_type'] = 'disc_devine';
        $data['field_name'] = 'dd_paying_day';
        $data['field_value'] =  'dd_paying_day';
        $data['error_message'] = "Polje Dan plaćanja u mesecu mora biti broj.";
        $this->update_rate_validation($data);
    }

    /**
     * Test Update Taxes DiscDevine Paying Day Must Be Minimum 1 (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function update_taxes_dd_paying_day_must_be_minimum_1()
    {
        $data['rate_type'] = 'disc_devine';
        $data['field_name'] = 'dd_paying_day';
        $data['field_value'] =  rand(-100, -1);
        $data['error_message'] = "Polje Dan plaćanja u mesecu mora biti najmanje 1.";
        $this->update_rate_validation($data);
    }

     /**
     * Test Update Taxes DiscDevine Paying Day Must Be Maximum 30 (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function update_taxes_dd_paying_day_must_be_maximum_30()
    {
        $data['rate_type'] = 'disc_devine';
        $data['field_name'] = 'dd_paying_day';
        $data['field_value'] =  rand(31, 100);
        $data['error_message'] = "Polje Dan plaćanja u mesecu mora biti manje od 30.";
        $this->update_rate_validation($data);
    }

    /**
     *  Validate Update Rate (RatesController@update_taxes, RatesController@update_sandler, RatesController@update_disc_devine)
     *
     * @param array $data
     * @return void
     */
    public function update_rate_validation($data)
    {
        $this->actingAs(self::$admin)
            ->visit($data['rate_type'] . '/edit')
            ->type($data['field_value'], $data['field_name'])
            ->press('POTVRDI')
            ->seePageIs($data['rate_type'] . '/edit')
            ->dontSeeInDatabase('rates', ['id' => self::$rate->id, $data['field_name'] => $data['field_value']])
            ->see($data['error_message']);
    }

    /**
     * Test False Update Rate Disc Devine With Get Method (RatesController@update_disc_devine)
     *
     * @test
     * @return void
     */
    public function false_update_rate_disc_devine_with_get_method()
    {
        $this->actingAs(self::$user)
            ->get('disc_devine/update/' . self::$rate)
            ->assertResponseStatus(405)
            ->see('405 Something Went Wrong');
    }
}
