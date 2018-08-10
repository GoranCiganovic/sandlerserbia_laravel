<?php

use App\ExchangeRate;

class ExchangeRateTest extends TestCase
{

    /**
     * Test If ExchangeRate Object Is An Instance of ExchangeRate Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_exchange_rate()
    {
        $this->assertInstanceOf('App\ExchangeRate', ExchangeRate::first());
    }

    /**
     * Test If ExchangeRate Table Returns 2 Records
     *
     * @test
     * @return void
     */
    public function if_exchange_rate_table_returns_2_records()
    {
        $this->assertEquals(2, ExchangeRate::count());
    }

    /**
     * Test If ExchangeRate 1 Is EUR euro
     *
     * @test
     * @return void
     */
    public function if_exchange_rate_1_is_euro()
    {
        $this->assertEquals('EUR', ExchangeRate::find(1)->currency);
    }

    /**
     * Test If ExchangeRate 2 Is USD dollar
     *
     * @test
     * @return void
     */
    public function if_exchange_rate_2_is_dollar()
    {
        $this->assertEquals('USD', ExchangeRate::find(2)->currency);
    }

    /**
     * Test if Method get_all_exchange_rate Returns All Exchange Rates
     *
     * @test
     * @return void
     */
    public function get_all_exchange_rate_returns_all_exchange_rates()
    {
        $this->assertEquals((new ExchangeRate)->get_all_exchange_rate(), ExchangeRate::all());
    }

     /**
     * Test if Method get_current_exchange_euro Returns Euro Currency Column Value
     *
     * @test
     * @return void
     */
    public function get_current_exchange_euro_returns_euro_currency_column_value()
    {
        $this->assertEquals((new ExchangeRate)->get_current_exchange_euro(), ExchangeRate::where('currency', 'EUR')->value('value'));
    }

     /**
     * Test if Method get_current_exchange_dollar Returns Dollar Currency Column Value
     *
     * @test
     * @return void
     */
    public function get_current_exchange_dollar_returns_dollar_currency_column_value()
    {
        $this->assertEquals((new ExchangeRate)->get_current_exchange_dollar(), ExchangeRate::where('currency', 'USD')->value('value'));
    }

     /**
     * Test if Method update_currency Updates Currency
     *
     * @test
     * @return void
     */
    public function update_currency_updates_currency()
    {
        $euro = 117.2236;
        (new ExchangeRate)->update_currency('EUR', $euro);
        $this->assertEquals($euro, ExchangeRate::where('currency', 'EUR')->value('value'));
    }
}
