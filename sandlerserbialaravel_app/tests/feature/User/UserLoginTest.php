<?php

use App\User;

class UserLoginTest extends TestCase
{
    /**
     * User object
     *
     * @var \App\User
     */
    protected static $user;

    /**
     * User Password
     *
     * @var string
     */
    protected static $password;

    /**
     * Create User
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(self::$password)) {
            self::$password = str_random(10);
        }

        if (is_null(self::$user)) {
            self::$user = factory(User::class)->create([
                'password' => bcrypt(self::$password),
            ]);
        }
    }

    /**
     * Test User Can Be Logged In
     *
     * @test
     * @return void
     */
    public function user_can_be_logged_in()
    {
        $this->visit('/login')
            ->type(self::$user->email, 'email')
            ->type(self::$password, 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/home')
            ->see(self::$user->name);
    }

    /**
     * Test User Can Not Be Logged In Because Email Is Required
     *
     * @test
     * @return void
     */
    public function user_can_not_be_logged_in_because_email_is_required()
    {
        $this->visit('/login')
            ->type($empty_email = '', 'email')
            ->type(self::$password, 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/login')
            ->see('The email field is required.');
    }

    /**
     * Test User Can Not Be Logged In Because Email Does Not Match
     *
     * @test
     * @return void
     */
    public function user_can_be_logged_in_because_email_does_not_match()
    {
        $this->visit('/login')
            ->type($wrong_email = str_random(10), 'email')
            ->type(self::$password, 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/login')
            ->see('These credentials do not match our records.');
    }

    /**
     * Test User Can Not Be Logged In Because Password Is Required
     *
     * @test
     * @return void
     */
    public function user_can_not_be_logged_in_because_password_is_required()
    {
        $this->visit('/login')
            ->type(self::$user->email, 'email')
            ->type($empty_password = '', 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/login')
            ->see('The password field is required.');
    }

    /**
     * Test User Can Not Be Logged In Because Password Does Not Match
     *
     * @test
     * @return void
     */
    public function user_can_not_be_logged_in_because_password_does_not_match()
    {
        $this->visit('/login')
            ->type(self::$user->email, 'email')
            ->type($wrong_password = str_random(10), 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/login')
            ->see('These credentials do not match our records.');
    }

    /**
     * Test User Can Reset Password
     *
     * @test
     * @return void
     */
    public function user_can_reset_password()
    {
        $user = factory(User::class)->create();
        $this->visit('/password/reset')
            ->type($user->email, 'email')
            ->press('Send Password Reset Link')
            ->seePageIs('/password/reset')
            ->see('Poslali smo link za resetovanje vaše lozinke!');
    }

    /**
     * Test User Can Not Reset Password Because Email Is Required
     *
     * @test
     * @return void
     */
    public function user_can_not_reset_password_because_email_is_required()
    {
        $this->visit('/password/reset')
            ->type($empty_email = '', 'email')
            ->press('Send Password Reset Link')
            ->seePageIs('/password/reset')
            ->see('Polje Email adresa je obavezno.');
    }

    /**
     * Test User Can Not Reset Password Because Email Is Not Valid
     *
     * @test
     * @return void
     */
    public function user_can_not_reset_password_because_email_is_not_valid()
    {
        $this->visit('/password/reset')
            ->type($invalid_email = str_random(10), 'email')
            ->press('Send Password Reset Link')
            ->seePageIs('/password/reset')
            ->see('Format polja Email adresa nije validan.');
    }

    /**
     * Test User Can Not Reset Password Because Email Does Not Match
     *
     * @test
     * @return void
     */
    public function user_can_not_reset_password_because_email_does_not_match()
    {
        $this->visit('/password/reset')
            ->type('not_existing@email.com', 'email')
            ->press('Send Password Reset Link')
            ->seePageIs('/password/reset')
            ->see('Nismo uspeli pronaći korisnika sa email adresom.');
    }

    /**
     * Test User Can Log Out
     *
     * @test
     * @return void
     */
    public function user_can_log_out()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->click('#logout_confirm')
            ->seePageIs('/');
        $this->actingAs(self::$user)
            ->get('/logout')
            ->assertRedirectedTo('/');
    }

     /**
     * Test Truncate User Table
     *
     * @test
     * @return void
     */
    public function truncate_user_table()
    {
        User::truncate();
        $this->assertNull(User::first());
    }
}
