<?php

class ExcelParseTest extends TestCase
{
    /**
     * Excel Object
     *
     * @var App\Classes\ExcelParse
     */
    protected static $excel_parse;

    /**
     * Faker
     *
     * @var Faker\Factory
     */
    protected static $faker;

    /**
     * Storage Path
     *
     * @var string
     */
    protected static $storage_path;

    /**
     * File Path
     *
     * @var string
     */
    protected $file_path;

    /**
     * Creates Excel Parse Object
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(self::$excel_parse)) {
            self::$excel_parse = new App\Classes\ExcelParse;
        }

        if (is_null(self::$faker)) {
            self::$faker = Faker\Factory::create();
        }
        self::$faker->fileExtension = 'xlsx';
        self::$faker->mimeType = 'application/vnd.ms-excel';

        if (is_null(self::$storage_path)) {
            self::$storage_path = storage_path() . '/' . config('constants.excel_storage_path');
        }
    }

    public function set_file_path($tmp_storage_path)
    {
        $this->file_path = self::$faker->file($tmp_storage_path, self::$storage_path);
    }

    /**
     * Test If File Is Filed Returns Bollean
     *
     * @test
     * @return void
     */
    public function file_is_filled()
    {
        $tmp_storage_paths = [
            'C:\wamp64\www\LaravelSandler\sandlerserbia\tests\tmp\excel\file_is_filled\empty',
            'C:\wamp64\www\LaravelSandler\sandlerserbia\tests\tmp\excel\file_is_filled\filled',
        ];
        $this->set_file_path($tmp_storage_paths[array_rand($tmp_storage_paths)]);

        $this->assertInternalType('boolean', self::$excel_parse->fileIsFilled($this->file_path));
    }

    /**
     * Test If Get Headers Returns Array
     *
     * @test
     * @return void
     */
    public function get_headers()
    {
        $tmp_storage_path = 'C:\wamp64\www\LaravelSandler\sandlerserbia\tests\tmp\excel\get_headers';
        $this->set_file_path($tmp_storage_path);

        $this->assertInternalType('array', self::$excel_parse->getHeaders($this->file_path));
    }

    /**
     * Test If Check Headers Returns String
     *
     * @test
     * @return void
     */
    public function check_headers()
    {
        $tmp_storage_paths = [
            'C:\wamp64\www\LaravelSandler\sandlerserbia\tests\tmp\excel\get_headers\valid',
            'C:\wamp64\www\LaravelSandler\sandlerserbia\tests\tmp\excel\get_headers\invalid',
        ];
        $tmp_storage_path = $tmp_storage_paths[array_rand($tmp_storage_paths)];
        $this->set_file_path($tmp_storage_path);
        $headers = self::$excel_parse->getHeaders($this->file_path);

        $this->assertInternalType('string', self::$excel_parse->checkHeaders($headers));
    }

    /**
     * Test If Change Column Name Returns String
     *
     * @test
     * @return void
     */
    public function change_column_name()
    {
        $headers = ['naziv', 'kraci_naziv', 'direktor', 'telefon', 'email', 'lice_za_razgovor', 'telefon_lica_za_razgovor', 'maticni_broj_firme', 'pib', 'delatnost', 'adresa', 'opstina', 'postanski_broj', 'grad', 'website', 'velicina',
        ];
        foreach ($headers as $header) {
            $this->assertInternalType('string', self::$excel_parse->changeColumnName($header));
        }
    }

    /**
     * Test If Get Column Names Array Returns Array
     *
     * @test
     * @return void
     */
    public function get_column_names_array()
    {
        $this->assertInternalType('array', self::$excel_parse->getColumnNamesArray());
    }

    /**
     * Test If Create Excel Array With Table Names Returns Array
     *
     * @test
     * @return void
     */
    public function create_excel_array_with_table_names()
    {
        $tmp_storage_path = 'C:\wamp64\www\LaravelSandler\sandlerserbia\tests\tmp\excel\get_headers';
        $this->set_file_path($tmp_storage_path);

        $this->assertInternalType('array', self::$excel_parse->createExcelArrayWithTableNames($this->file_path));
    }

    /**
     * Test If Replace Company Size Value Returns Array
     *
     * @test
     * @return void
     */
    public function replace_company_size_value()
    {
        $tmp_storage_path = 'C:\wamp64\www\LaravelSandler\sandlerserbia\tests\tmp\excel';
        $this->set_file_path($tmp_storage_path);
        $excel_array = self::$excel_parse->createExcelArrayWithTableNames($this->file_path);

        $this->assertInternalType('array', self::$excel_parse->replaceCompanySizeValue($excel_array));
    }

    /**
     * Test If Return Company Size Id Returns Integer
     *
     * @test
     * @return void
     */
    public function return_company_size_id()
    {
        $company_size_names = ['Nepoznato', 'Mikro', 'Malo', 'Srednje', 'Veliko', self::$faker->word];
        $company_size_name = $company_size_names[array_rand($company_size_names)];

        $this->assertInternalType('int', self::$excel_parse->returnCompanySizeID($company_size_name));
    }

    /**
     * Test If Get Excel File Path Returns String
     *
     * @test
     * @return void
     */
    public function get_excel_file_path()
    {
        $this->assertInternalType('string', self::$excel_parse->get_excel_file_path(true, 'excel.xlsx'));
        $this->assertInternalType('string', self::$excel_parse->get_excel_file_path(false, 'excel.xlsx'));
    }

    /**
     * Delete File
     *
     * @test
     * @return void
     */
    public function tearDown()
    {
        if (file_exists($this->file_path)) {
            unlink($this->file_path);
        }
        parent::tearDown();
    }
}
