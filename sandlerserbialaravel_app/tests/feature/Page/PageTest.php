<?php

class PageTest extends TestCase
{
    /**
     * Test Welcome Page
     *
     * @test
     * @return void
     */
    public function welcome_page()
    {
        $this->visit('/')
            ->see('Sandler Serbia');
    }
    /**
     * Test Login Page
     *
     * @test
     * @return void
     */
    public function login_page()
    {
        $this->visit('/login')
            ->assertResponseOk();
    }

    /**
     * Test Register Page
     *
     * @test
     * @return void
     */
    public function register_page()
    {
        $this->visit('/register')
            ->assertResponseOk();
    }

    /**
     * Test Reset Password Page
     *
     * @test
     * @return void
     */
    public function reset_password_page()
    {
        $this->visit('/password/reset')
            ->assertResponseOk();
    }

    /**
     * Test Edit Global Training Page
     *
     * @test
     * @return void
     */
    public function edit_global_training_page()
    {
        $this->visit('/global_training/edit')
            ->assertResponseOk();
    }

    /**
     * Test Edit Rate Taxes Page
     *
     * @test
     * @return void
     */
    public function edit_rate_taxes_page()
    {
        $this->visit('/taxes/edit')
            ->assertResponseOk();
    }

    /**
     * Test Edit Rate Sandler Page
     *
     * @test
     * @return void
     */
    public function edit_rate_sandler_page()
    {
        $this->visit('/sandler/edit')
            ->assertResponseOk();
    }

    /**
     * Test Edit Rate Disc Devine Page
     *
     * @test
     * @return void
     */
    public function edit_rate_disc_devine_page()
    {
        $this->visit('/disc_devine/edit')
            ->assertResponseOk();
    }

    /**
     * Test Exchange Page
     *
     * @test
     * @return void
     */
    public function exchange_page()
    {
        $this->visit('/exchange')
            ->assertResponseOk();
    }

    /**
     * Test Articles Page
     *
     * @test
     * @return void
     */
    public function articles_page()
    {
        $this->visit('/articles')
            ->assertResponseOk();
    }
}
