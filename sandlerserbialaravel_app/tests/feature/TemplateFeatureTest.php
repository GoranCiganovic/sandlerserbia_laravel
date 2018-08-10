<?php

use App\Template;

class TemplateFeatureTest extends TestCase
{
     /**
     * Template
     *
     * @var App\Template
     */
    protected static $template;

    /**
     * Set Template
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(self::$template)) {
            self::$template = Template::first();
        }
    }

    /**
     * Test Admin Can See The Form For Editing Template (TemplatesController@edit)
     *
     * @test
     * @return void
     */
    public function admin_can_see_form_for_editing_template()
    {
        $this->actingAs(self::$admin)
            ->visit('/articles')
            ->click('#template_edit')
            ->seePageIs('/template/edit/'.self::$template->id)
            ->see(self::$template->logo_bg)
            ->see(self::$template->paginate)
            ->see(self::$template->margin_top)
            ->see('Izmeni Opcije')
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing Template As Admin (TemplatesController@edit)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_template_as_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/template/edit/'. self::$template->id)
            ->assertResponseStatus(200)
            ->assertViewHas('template');
    }

    /**
     * Test User Can See The Form For Editing Template (TemplatesController@edit)
     *
     * @test
     * @return void
     */
    public function user_can_see_form_for_editing_template()
    {
        $this->actingAs(self::$user)
            ->visit('/articles')
            ->click('#template_edit')
            ->seePageIs('/template/edit/'.self::$template->id)
            ->see(self::$template->logo_bg)
            ->see(self::$template->paginate)
            ->see('Izmeni Opcije')
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing Template As User (TemplatesController@edit)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_template_as_user()
    {
        $this->actingAs(self::$user)
            ->get('/template/edit/'. self::$template->id)
            ->assertResponseStatus(200)
            ->assertViewHas('template');
    }

    /**
     * Test Admin Can Return From Edit Template Page To All Articles Page (TemplatesController@edit)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_edit_template_page_to_all_articles_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/articles')
            ->visit('/template/edit/' . self::$template->id)
            ->see('Izmeni Opcije')
            ->click('Nazad')
            ->seePageIs('/articles')
            ->see('Šablon Ugovora');
    }

    /**
     * Test User Can Return From Edit Template Page To All Articles Page (TemplatesController@edit)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_edit_template_page_to_all_articles_page()
    {
        $this->actingAs(self::$user)
            ->visit('/articles')
            ->visit('/template/edit/' . self::$template->id)
            ->see('Izmeni Opcije')
            ->click('Nazad')
            ->seePageIs('/articles')
            ->see('Šablon Ugovora');
    }

     /**
     * Test Admin Can Update Template (TemplatesController@update)
     *
     * @test
     * @return void
    */
    public function admin_can_update_template()
    {
        $this->actingAs(self::$admin)
            ->visit('/template/edit/' . self::$template->id)
            ->check('logo_bg')
            ->check('logo_hd')
            ->check('paginate')
            ->type(30, 'margin_top')
            ->type($ml = 20, 'margin_left')
            ->type(20, 'margin_right')
            ->type(20, 'margin_bottom')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/template/edit/' . self::$template->id)
            ->seeInDatabase('templates', ['id' => self::$template->id, 'margin_left' => $ml])
            ->see('Opcije su uspešno izmenjene');
    }

    /**
     * Test User Can Not Update Template (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function user_can_not_update_template()
    {
        $this->actingAs(self::$user)
            ->visit('/template/edit/' . self::$template->id)
            ->type($mt = 10, 'margin_top')
            ->type(30, 'margin_left')
            ->type(30, 'margin_right')
            ->type(30, 'margin_bottom')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/template/edit/' . self::$template->id)
            ->dontSeeInDatabase('templates', ['id' => self::$template->id, 'margin_top' => $mt])
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test Update Template Logo Background Must Be Boolean (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_template_logo_bg_must_be_boolean()
    {
        $this->actingAs(self::$admin)
            ->post('/template/update/' . self::$template->id, ['logo_bg' => $logo_bg = 'logo_bg'])
            ->dontSeeInDatabase('templates', ['id' => self::$template->id, 'logo_bg' => $logo_bg]);
    }

     /**
     * Test Update Template Logo Header Must Be Boolean (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_template_logo_hd_must_be_boolean()
    {
        $this->actingAs(self::$admin)
            ->post('/template/update/' . self::$template->id, ['logo_hd' => $logo_hd = 'logo_hd'])
            ->dontSeeInDatabase('templates', ['id' => self::$template->id, 'logo_hd' => $logo_hd]);
    }

     /**
     * Test Update Template Line Header Must Be Boolean (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_template_line_hd_must_be_boolean()
    {
        $this->actingAs(self::$admin)
            ->post('/template/update/' . self::$template->id, ['line_hd' => $line_hd = 'line_hd'])
            ->dontSeeInDatabase('templates', ['id' => self::$template->id, 'line_hd' => $line_hd]);
    }

     /**
     * Test Update Template Line Footer Must Be Boolean (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_template_line_ft_must_be_boolean()
    {
        $this->actingAs(self::$admin)
            ->post('/template/update/' . self::$template->id, ['line_ft' => $line_ft = 'line_ft'])
            ->dontSeeInDatabase('templates', ['id' => self::$template->id, 'line_ft' => $line_ft]);
    }

     /**
     * Test Update Template Paginate Must Be Boolean (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_template_paginate_must_be_boolean()
    {
        $this->actingAs(self::$admin)
            ->post('/template/update/' . self::$template->id, ['paginate' => $paginate = 'paginate'])
            ->dontSeeInDatabase('templates', ['id' => self::$template->id, 'paginate' => $paginate]);
    }

     /**
     * Test Update Article Margin Top Is Required (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_margin_top_is_required()
    {
        $data['field_name'] = 'margin_top';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Margina gore je obavezno.";
        $this->update_template_validation($data);
    }

     /**
     * Test Update Article Margin Top Must Be Numeric (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_margin_top_must_be_numeric()
    {
        $data['field_name'] = 'margin_top';
        $data['field_value'] = 'margin_top';
        $data['error_message'] = "Polje Margina gore mora biti broj.";
        $this->update_template_validation($data);
    }

     /**
     * Test Update Article Margin Top Must Be Between 0 And 50 (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_martin_top_must_be_between_0_and_50()
    {
        $data['field_name'] = 'margin_top';
        $data['field_value'] = rand(51, 200);
        $data['error_message'] = "Polje Margina gore mora biti između 0 - 50.";
        $this->update_template_validation($data);
    }

     /**
     * Test Update Article Margin Right Is Required (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_margin_right_is_required()
    {
        $data['field_name'] = 'margin_right';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Margina desno je obavezno.";
        $this->update_template_validation($data);
    }

     /**
     * Test Update Article Margin Right Must Be Numeric (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_margin_right_must_be_numeric()
    {
        $data['field_name'] = 'margin_right';
        $data['field_value'] = 'margin_right';
        $data['error_message'] = "Polje Margina desno mora biti broj.";
        $this->update_template_validation($data);
    }

     /**
     * Test Update Article Margin Right Must Be Between 0 And 30 (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_margin_right_must_be_between_0_and_30()
    {
        $data['field_name'] = 'margin_right';
        $data['field_value'] = rand(31, 200);
        $data['error_message'] = "Polje Margina desno mora biti između 0 - 30.";
        $this->update_template_validation($data);
    }

     /**
     * Test Update Article Margin Bottom Is Required (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_margin_bottom_is_required()
    {
        $data['field_name'] = 'margin_bottom';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Margina dole je obavezno.";
        $this->update_template_validation($data);
    }

    /**
     * Test Update Article Margin Bottom Must Be Numeric (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_margin_bottom_must_be_numeric()
    {
        $data['field_name'] = 'margin_bottom';
        $data['field_value'] = 'margin_bottom';
        $data['error_message'] = "Polje Margina dole mora biti broj.";
        $this->update_template_validation($data);
    }

    /**
     * Test Update Article Margin Bottom Must Be Between 0 And 30 (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_margin_bottom_must_be_between_0_and_30()
    {
        $data['field_name'] = 'margin_bottom';
        $data['field_value'] = rand(31, 200);
        $data['error_message'] = "Polje Margina dole mora biti između 0 - 30.";
        $this->update_template_validation($data);
    }

     /**
     * Test Update Article Margin Left Is Required (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_margin_left_is_required()
    {
        $data['field_name'] = 'margin_left';
        $data['field_value'] = '';
        $data['error_message'] = "Polje Margina levo je obavezno.";
        $this->update_template_validation($data);
    }

     /**
     * Test Update Article Margin Left Must Be Numeric (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_margin_left_must_be_numeric()
    {
        $data['field_name'] = 'margin_left';
        $data['field_value'] = 'margin_left';
        $data['error_message'] = "Polje Margina levo mora biti broj.";
        $this->update_template_validation($data);
    }

    /**
     * Test Update Article Margin Left Must Be Between 0 And 30 (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_margin_left_must_be_between_0_and_30()
    {
        $data['field_name'] = 'margin_left';
        $data['field_value'] = rand(31, 200);
        $data['error_message'] = "Polje Margina levo mora biti između 0 - 30.";
        $this->update_template_validation($data);
    }

    /**
     *  Validate Update Template (TemplatesController@update)
     *
     * @param array $data
     * @return void
     */
    public function update_template_validation($data)
    {
        $this->actingAs(self::$admin)
            ->visit('/template/edit/' . self::$template->id)
            ->type($data['field_value'], $data['field_name'])
            ->press('POTVRDI IZMENU')
            ->seePageIs('/template/edit/' . self::$template->id)
            ->dontSeeInDatabase(
                'templates',
                ['id' => self::$template->id, $data['field_name'] => $data['field_value']]
            )
            ->see($data['error_message']);
    }

    /**
     * Test False Update Template With Get Methods (TemplatesController@update)
     *
     * @test
     * @return void
     */
    public function false_update_template_with_get_method()
    {
        $this->actingAs(self::$user)
            ->get('template/update/' . self::$template->id)
            ->assertResponseStatus(405)
            ->see('405 Something Went Wrong');
    }
}
