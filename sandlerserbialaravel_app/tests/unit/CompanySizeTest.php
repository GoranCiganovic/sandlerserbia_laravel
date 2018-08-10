<?php

use App\CompanySize;

class CompanySizeTest extends TestCase
{
    /**
     * CompanySize object
     *
     * @var App\CompanySize
     */
    protected static $company_size;

    /**
     * Set CompanySize
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        self::$company_size = CompanySize::first();
    }

     /**
     * Test If CompanySize Object Is An Instance of CompanySize Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_company_size()
    {
        $this->assertInstanceOf('App\CompanySize', self::$company_size);
    }

    /**
     * Test If CompanySize Table Returns 5 Records
     *
     * @test
     * @return void
     */
    public function if_company_size_table_returns_5_records()
    {
        $this->assertEquals(5, CompanySize::count());
    }

    /**
     * Test If CompanySize 1 Is Unkonwn
     *
     * @test
     * @return void
     */
    public function if_company_size_1_is_unknown()
    {
        $this->assertEquals('Nepoznato', CompanySize::find(1)->name);
    }

    /**
     * Test If CompanySize 2 Is Micro
     *
     * @test
     * @return void
     */
    public function if_company_size_2_is_micro()
    {
        $this->assertEquals('Mikro', CompanySize::find(2)->name);
    }

    /**
     * Test If CompanySize 3 Is Small
     *
     * @test
     * @return void
     */
    public function if_company_size_3_is_small()
    {
        $this->assertEquals('Malo', CompanySize::find(3)->name);
    }

    /**
     * Test If CompanySize 4 Is Medium
     *
     * @test
     * @return void
     */
    public function if_company_size_4_is_medium()
    {
        $this->assertEquals('Srednje', CompanySize::find(4)->name);
    }

    /**
     * Test If CompanySize 5 Is Large
     *
     * @test
     * @return void
     */
    public function if_company_size_5_is_large()
    {
        $this->assertEquals('Veliko', CompanySize::find(5)->name);
    }

     /**
     * Test Legal Owns Company Size With Foreign Key Company Size Id
     *
     * @test
     * @return void
     */
    public function legal_owns_company_size_with_foreign_key_company_size_id()
    {
        $this->assertEquals(self::$company_size->legal(), self::$company_size->hasOne('App\Legal', 'company_size_id'));
    }

     /**
     * Test if Method get_company_sizes Returns All Company Sizes
     *
     * @test
     * @return void
     */
    public function get_company_sizes_returns_all_company_sizes()
    {
        $this->assertEquals((new CompanySize)->get_company_sizes(), CompanySize::all());
    }

     /**
     * Test if Method get_company_size_by_id Returns Company Sizes With Passed Company Size Id
     *
     * @test
     * @return void
     */
    public function get_company_size_by_id_returns_company_size_with_passed_company_size_id()
    {
        $this->assertEquals((new CompanySize)->get_company_size_by_id(self::$company_size->id), CompanySize::find(self::$company_size->id));
    }
}
