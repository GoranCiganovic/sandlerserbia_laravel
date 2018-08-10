<?php

use App\Template;

class TemplateTest extends TestCase
{
    /**
     * Template object
     *
     * @var App\Template
     */
    protected static $template;

    /**
     *  Set Template
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        self::$template = Template::first();
    }

    /**
     * Test If Template Object Is An Instance of Template Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_template()
    {
        $this->assertInstanceOf('App\Template', self::$template);
    }

    /**
     * Test If Templates Table Returns 1 Record
     *
     * @test
     * @return void
     */
    public function if_template_table_returns_1_record()
    {
        $this->assertEquals(1, Template::count());
    }

    /**
     * Test If Template 1 Is Template Record
     *
     * @test
     * @return void
     */
    public function if_template_1_is_template_record()
    {
        $this->assertEquals(1, Template::find(1)->id);
    }

    /**
     * Test if Method get_template_options Returns First Row From Template Table
     *
     * @test
     * @return void
     */
    public function get_template_options_returns_first_row_in_templates_table()
    {
        $this->assertEquals((new Template)->get_template_options()->id, Template::first()->id);
    }
}
