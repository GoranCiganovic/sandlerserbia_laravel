<?php

class ParseTest extends TestCase
{
    /**
     * Parse Object
     *
     * @var App\Classes\Parse
     */
    protected static $parse;

    /**
     * Client
     *
     * @var array
     */
    protected static $client;

    /**
     * Faker
     *
     * @var Faker\Factory
     */
    protected static $faker;

    /**
     * Creates Parse, Client, Faker Objects
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(self::$parse)) {
            self::$parse = new App\Classes\Parse;
        }
        if (is_null(self::$client)) {
            self::$client = [
                'long_name' => str_random(20),
                'address' => str_random(30),
                'identification' => rand(100000000, 999999999),
                'pib' => rand(100000000, 999999999),
                'ceo' => str_random(20),
                'first_name' => str_random(10),
                'last_name' => str_random(10),
                'jmbg' => rand(100000000000, 999999999999),
                'id_card' => rand(100000000, 999999999),
                'city' => str_random(20),
            ];
        }

        if (is_null(self::$faker)) {
            self::$faker = Faker\Factory::create();
        }
    }

    /**
     * Test If Get No Javascript Message Returns Array
     *
     * @test
     * @return void
     */
    public function get_no_js_message()
    {
        $this->assertInternalType('array', self::$parse->getNoJSMessage(rand(0, 1)));
    }

    /**
     * Test If Get Sort Filter Array Value Returns Array
     *
     * @test
     * @return void
     */
    public function get_sort_filter_array_value()
    {
        $this->assertInternalType('array', self::$parse->getSortFilterArrayValue(rand(0, 5)));
    }

    /**
     * Test If Get Sort Filter Array Value Returns Array
     *
     * @test
     * @return void
     */
    public function get_statistics_params()
    {
        $params = ['conversation_ratio', 'closing_ratio', 'sandler_traffic', 'disc_devine_traffic', 'total_traffic'];
        $this->assertInternalType('array', self::$parse->getStatisticsParams($params[array_rand($params)]));
    }

    /**
     * Test If Get Serbian Month Name Returns String
     *
     * @test
     * @return void
     */
    public function get_serbian_month_name()
    {
        $timestamp = rand(strtotime("Jan 01 2015"), strtotime("Nov 01 2018"));
        $random_date = date("l d F Y H:i:s", $timestamp);
        $this->assertInternalType('string', self::$parse->get_serbian_month_name($random_date));
    }

    /**
     * Test If Get Serbian Day Name Returns String
     *
     * @test
     * @return void
     */
    public function get_serbian_day_name()
    {
        $timestamp = rand(strtotime("Jan 01 2015"), strtotime("Nov 01 2018"));
        $random_date = date("l d F Y H:i:s", $timestamp);
        $this->assertInternalType('string', self::$parse->get_serbian_day_name($random_date));
    }

    /**
     * Test If Get Previous Month Name Returns String
     *
     * @test
     * @return void
     */
    public function get_previous_month_name()
    {
        $this->assertInternalType('string', self::$parse->get_previous_month_name());
    }

    /**
     * Test If Get Next Month Paying Date Returns String
     *
     * @test
     * @return void
     */
    public function get_next_month_paying_date()
    {
        $timestamp = rand(strtotime("Jan 01 2015"), strtotime("Nov 01 2018"));
        $random_day = date("d", $timestamp);
        $this->assertInternalType('string', self::$parse->get_next_month_paying_date($random_day));
    }

    /**
     * Test If Get First And Last Day Of Previous Month Returns Array
     *
     * @test
     * @return void
     */
    public function get_first_and_last_day_previous_month()
    {
        $this->assertInternalType('array', self::$parse->get_first_and_last_day_previous_month());
    }

    /**
     * Test If Generate Current Time Session Key Returns Correct Integer
     *
     * @test
     * @return void
     */
    public function generate_current_time_session_key()
    {
        $current_time = self::$parse->generate_current_time_session_key('single_submit');
        $this->assertInternalType('int', $current_time);
        $this->assertEquals($current_time, session()->get('single_submit'));
    }

    /**
     * Test If Get Payment Type Returns Array
     *
     * @test
     * @return void
     */
    public function get_payment_type()
    {
        $type = ['proinvoice', 'invoice'];
        $this->assertInternalType('array', self::$parse->get_payment_type($type[array_rand($type)]));
    }

    /**
     * Test If Get Client Status Id By Name Returns Integer
     *
     * @test
     * @return void
     */
    public function get_client_status_id_by_name()
    {
        $status_name = ['active', 'inactive', 'jpb', 'accept_meeting', 'disqualified', 'uncontacted', 'unknown', 2, true, null];
        $this->assertInternalType('int', self::$parse->get_client_status_id_by_name($status_name[array_rand($status_name)]));
    }

    /**
     * Test If Get Contract Status Id Returns Integer
     *
     * @test
     * @return void
     */
    public function get_contract_status_id()
    {
        $status_name = ['broken', 'finished', 'in_progress', 'unsigned', 'unknown', 2, true, null];
        $this->assertInternalType('int', self::$parse->get_contract_status_id($status_name[array_rand($status_name)]));
    }

    /**
     * Test If Get Pdf Invoice Path Returns String
     *
     * @test
     * @return void
     */
    public function get_pdf_invoice_path()
    {
        $full_path = rand(0, 1);
        $client_id = rand(1, 100);
        $contract_id = rand(1, 100);
        $filename = str_random(20);
        $this->assertInternalType('string', self::$parse->get_pdf_invoice_path($full_path, $client_id, $contract_id, $filename));
    }

    /**
     * Test If Get Pdf Contract Path Returns String
     *
     * @test
     * @return void
     */
    public function get_pdf_contract_path()
    {
        $full_path = rand(0, 1);
        $client_id = rand(1, 100);
        $contract_id = rand(1, 100);
        $filename = str_random(20);
        $this->assertInternalType('string', self::$parse->get_pdf_contract_path($full_path, $client_id, $contract_id, $filename));
    }

    /**
     * Test If Get Client Contract Pdf Returns Array
     *
     * @test
     * @return void
     */
    public function get_client_contract_pdf()
    {
        $legal_status = rand(1, 2);
        $this->assertInternalType('array', self::$parse->get_client_contract_pdf($legal_status, self::$client));
    }

    /**
     * Test If Get Client Invoice Pdf Returns Array
     *
     * @test
     * @return void
     */
    public function get_client_invoice_pdf()
    {
        $legal_status = rand(1, 2);
        $this->assertInternalType('array', self::$parse->get_client_invoice_pdf($legal_status, self::$client));
    }

    /**
     * Test If Next Invoice-Proinvoice Number Returns Array
     *
     * @test
     * @return void
     */
    public function next_invoice_proinvoice_number()
    {
        $legal_status = rand(1, 2);
        $array = ['invoice', 'proinvoice'];
        $type = $array[array_rand($array)];
        $type_array = self::$parse->get_payment_type($type);
        $this->assertInternalType('array', self::$parse->next_invoice_proinvoice_number($legal_status, $type_array));
    }

    /**
     * Test If Get Next Invoice-Proinvoice Legal Number Returns Array
     *
     * @test
     * @return void
     */
    public function get_next_invoice_proinvoice_legal_number()
    {
        $array = ['invoice', 'proinvoice'];
        $type = $array[array_rand($array)];
        $type_array = self::$parse->get_payment_type($type);
        $this->assertInternalType('array', self::$parse->get_next_invoice_proinvoice_legal_number($type_array));
    }

    /**
     * Test If Get Next Invoice-Proinvoice Internally Number Returns Array
     *
     * @test
     * @return void
     */
    public function get_next_invoice_proinvoice_internally_number()
    {
        $array = ['invoice', 'proinvoice'];
        $type = $array[array_rand($array)];
        $type_array = self::$parse->get_payment_type($type);
        $this->assertInternalType('array', self::$parse->get_next_invoice_proinvoice_internally_number($type_array));
    }

    /**
     * Test If Remove Unnecessary Html Tags Returns String
     *
     * @test
     * @return void
     */
    public function remove_unnecessary_html_tags()
    {
        $html = self::$faker->randomHtml(2, 3);
        $this->assertInternalType('string', self::$parse->remove_unnecessary_html_tags($html));
    }

    /**
     * Test If Remove Html Space Entity Returns String
     *
     * @test
     * @return void
     */
    public function remove_html_space_entity()
    {
        $html = self::$faker->randomHtml(2, 3);
        $this->assertInternalType('string', self::$parse->remove_html_space_entity($html));
    }
}
