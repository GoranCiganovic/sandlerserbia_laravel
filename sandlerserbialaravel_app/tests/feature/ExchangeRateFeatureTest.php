<?php

use App\ExchangeRate;

class ExchangeRateFeatureTest extends TestCase
{
    /**
     * Exchange Rate
     *
     * @var App\ExchangeRate
     */
    protected static $exchange_rate;

     /**
     * All Exchange Rates - Collection
     *
     * @var App\ExchangeRate
     */
    protected static $all_exchange_rates;

    /**
     * Set ExchangeRate And ExchangeRate Collection
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(self::$exchange_rate)) {
            self::$exchange_rate = ExchangeRate::first();
        }
        if (is_null(self::$all_exchange_rates)) {
            self::$all_exchange_rates = ExchangeRate::all();
        }
    }

    /**
     * Test Admin Can See All Exchange Rates (ExchangeRatesController@index)
     *
     * @test
     * @return void
    */
    public function admin_can_see_all_exchange_rates()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->click('#exchanges_edit')
            ->seePageIs('/exchange')
            ->see('Kursna lista na dan '.date('d.m.Y.'))
            ->see('Kursna lista Banca Intesa')
            ->see('Kursna lista NBS');
        foreach (self::$all_exchange_rates as $exchange) {
            $this->see($exchange->currency)->see($exchange->value);
        }
    }

    /**
     * Test Http Get Request Show All Exchange Rates As Admin (ExchangeRatesController@index)
     *
     * @test
     * @return void
     */
    public function http_get_request_show_all_exchange_rates_as_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/exchange')
            ->assertResponseStatus(200)
            ->assertViewHas('exchange');
    }

     /**
     * Test User Can See All Exchange Rates (ExchangeRatesController@index)
     *
     * @test
     * @return void
    */
    public function user_can_see_all_exchange_rates()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->click('#exchanges_edit')
            ->seePageIs('/exchange')
            ->see('Kursna lista na dan '.date('d.m.Y.'))
            ->see('Kursna lista Banca Intesa')
            ->see('Kursna lista NBS');
        foreach (self::$all_exchange_rates as $exchange) {
            $this->see($exchange->currency)->see($exchange->value);
        }
    }

    /**
     * Test Http Get Request Show All Exchange Rates As User (ExchangeRatesController@index)
     *
     * @test
     * @return void
     */
    public function http_get_request_show_all_exchange_rates_as_user()
    {
        $this->actingAs(self::$user)
            ->get('/exchange')
            ->assertResponseStatus(200)
            ->assertViewHas('exchange');
    }

    /**
     * Test Admin Can Return From All Exchange Rates Page To Home Page (ExchangeRatesController@index)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_all_exchange_rates_page_to_home_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->visit('/exchange')
            ->see('Kursna lista na dan '.date('d.m.Y.'))
            ->click('Nazad')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

    /**
     * Test User Can Return From All Exchange Rates Page To Home Page (ExchangeRatesController@index)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_all_exchange_rates_page_to_home_page()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->visit('/exchange')
            ->see('Kursna lista na dan '.date('d.m.Y.'))
            ->click('Nazad')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

     /**
     * Test Admin Can See The Form For Editing Exchange Rate (ExchangeRatesController@edit)
     *
     * @test
     * @return void
    */
    public function admin_can_see_form_for_editing_exchange_rate()
    {
        $this->actingAs(self::$admin)
            ->visit('exchange')
            ->click("#".self::$exchange_rate->currency)
            ->seePageIs('/exchange/edit/' . self::$exchange_rate->id)
            ->see(self::$exchange_rate->currency)
            ->see(self::$exchange_rate->value)
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing Exchange Rate As Admin (ExchangeRatesController@edit)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_exchange_rate_as_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/exchange/edit/' . self::$exchange_rate->id)
            ->assertResponseStatus(200)
            ->assertViewHas('exchange');
    }

    /**
     * Test User Can See The Form For Editing Exchange Rate (ExchangeRatesController@edit)
     *
     * @test
     * @return void
    */
    public function user_can_see_form_for_editing_exchange_rate()
    {
        $this->actingAs(self::$user)
            ->visit('exchange')
            ->click("#".self::$exchange_rate->currency)
            ->seePageIs('/exchange/edit/' . self::$exchange_rate->id)
            ->see(self::$exchange_rate->currency)
            ->see(self::$exchange_rate->value)
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing Exchange Rate As User (ExchangeRatesController@edit)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_exchange_rate_as_user()
    {
        $this->actingAs(self::$user)
            ->get('/exchange/edit/' . self::$exchange_rate->id)
            ->assertResponseStatus(200)
            ->assertViewHas('exchange');
    }

    /**
     * Test Admin Can Return From Edit Exchange Rate Page To All Exchange Rates Page (ExchangeRatesController@edit)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_edit_exchange_rate_page_to_all_exchange_rates_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/exchange')
            ->visit('/exchange/edit/' . self::$exchange_rate->id)
            ->see(self::$exchange_rate->currency)
            ->click('Kursna lista')
            ->seePageIs('/exchange')
            ->see('Kursna lista na dan '.date('d.m.Y.'));
    }

    /**
     * Test User Can Return From Edit Exchange Rate Page To All Exchange Rates Page (ExchangeRatesController@edit)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_edit_exchange_rate_page_to_all_exchange_rates_page()
    {
        $this->actingAs(self::$user)
            ->visit('/exchange')
            ->visit('/exchange/edit/' . self::$exchange_rate->id)
            ->see(self::$exchange_rate->currency)
            ->click('Kursna lista')
            ->seePageIs('/exchange')
            ->see('Kursna lista na dan ' . date('d.m.Y.'));
    }

     /**
     * Test Admin Can Update Exhange Rate (ExchangeRatesController@update)
     *
     * @test
     * @return void
    */
    public function admin_can_update_exchange_rate()
    {
        $this->actingAs(self::$admin)
            ->visit('/exchange/edit/' . self::$exchange_rate->id)
            ->type($value = 101.2356, 'exchange_value')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/exchange/edit/' . self::$exchange_rate->id)
            ->seeInDatabase('exchange_rates', ['id' => self::$exchange_rate->id, 'value' => $value])
            ->see("Valuta " . self::$exchange_rate->currency . " je uspešno izmenjena.");
    }

     /**
     * Test User Can Not Update Exhange Rate (ExchangeRatesController@update)
     *
     * @test
     * @return void
    */
    public function user_can_not_update_exchange_rate()
    {
        $this->actingAs(self::$user)
            ->visit('/exchange/edit/' . self::$exchange_rate->id)
            ->type($value = 111.9965, 'exchange_value')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/exchange/edit/' . self::$exchange_rate->id)
            ->dontSeeInDatabase('exchange_rates', ['id' => self::$exchange_rate->id, 'value' => $value])
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

     /**
     * Test False Update Exchange Rate With Get Method (ExchangeRatesController@update)
     *
     * @test
     * @return void
     */
    public function false_update_exchange_rate_with_get_method()
    {
        $this->actingAs(self::$user)
            ->get('exchange/update/' . self::$exchange_rate->id)
            ->assertResponseStatus(405)
            ->see('405 Something Went Wrong');
    }

     /**
     * Test Update Exchange Value Is Required (ExchangeRatesController@update)
     *
     * @test
     * @return void
     */
    public function update_exchange_value_is_required()
    {
        $this->actingAs(self::$admin)
            ->visit('/exchange/edit/' . self::$exchange_rate->id)
            ->type($value = '', 'exchange_value')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/exchange/edit/' . self::$exchange_rate->id)
            ->dontSeeInDatabase('exchange_rates', ['id' => self::$exchange_rate->id, 'value' => $value])
            ->see('Polje Srednji kurs (RSD) je obavezno.');
    }

     /**
     * Test Update Exchange Value Must Be Numeric (ExchangeRatesController@update)
     *
     * @test
     * @return void
     */
    public function update_exchange_value_must_be_numeric()
    {
        $this->actingAs(self::$admin)
            ->visit('/exchange/edit/' . self::$exchange_rate->id)
            ->type($value = 'value' . rand(1, 100), 'exchange_value')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/exchange/edit/' . self::$exchange_rate->id)
            ->dontSeeInDatabase('exchange_rates', ['id' => self::$exchange_rate->id, 'value' => $value])
            ->see('Polje Srednji kurs (RSD) mora biti broj.');
    }

     /**
     * Test Update Exchange Value Must Be Between 0 And 10 Digits (ExchangeRatesController@update)
     *
     * @test
     * @return void
     */
    public function update_exchange_value_must_be_between_0_and_10_digits()
    {
        $this->actingAs(self::$admin)
            ->visit('/exchange/edit/' . self::$exchange_rate->id)
            ->type($value = rand(25251525152, 36956365965665), 'exchange_value')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/exchange/edit/' . self::$exchange_rate->id)
            ->dontSeeInDatabase('exchange_rates', ['id' => self::$exchange_rate->id, 'value' => $value])
            ->see('Polje Srednji kurs (RSD) mora biti izemđu 0 i 10 cifri.');
    }

     /**
     * Test Update Exchange Value Must Be Minimum 0 (ExchangeRatesController@update)
     *
     * @test
     * @return void
     */
    public function update_exchange_value_must_be_minimum_0()
    {
        $this->actingAs(self::$admin)
            ->visit('/exchange/edit/' . self::$exchange_rate->id)
            ->type($value = rand(-100, -1), 'exchange_value')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/exchange/edit/' . self::$exchange_rate->id)
            ->dontSeeInDatabase('exchange_rates', ['id' => self::$exchange_rate->id, 'value' => $value])
            ->see('Polje Srednji kurs (RSD) mora biti najmanje 0.');
    }
}
