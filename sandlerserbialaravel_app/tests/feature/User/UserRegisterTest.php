<?php

use App\User;

class UserRegisterTest extends TestCase
{

    /**
     * Faker object
     *
     * @var \Faker\Factory
     */
    protected static $faker;

    /**
     * Creates Regular Users
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(self::$faker)) {
            self::$faker = Faker\Factory::create();
        }

        /* During the registration, an event is created (sending emails) */
        $this->withoutEvents(App\Events\UserRegistered::class);
    }

    /**
     * Test User Can Be Registered
     *
     * @test
     * @return void
     */
    public function user_can_be_registered()
    {
        $this->visit('/register')
            ->type(self::$faker->name, 'name')
            ->type(self::$faker->unique()->safeEmail, 'email')
            ->type($password = self::$faker->password(), 'password')
            ->type($password, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/home');
    }

    /**
     * Test User Can't Be Registered Because Name Is Required
     *
     * @test
     * @return void
     */
    public function user_cant_be_registered_because_name_is_required()
    {
        $this->visit('/register')
            ->type($empty_name = '', 'name')
            ->type(self::$faker->unique()->safeEmail, 'email')
            ->type($password = self::$faker->password(), 'password')
            ->type($password, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The name field is required.');
    }

    /**
     * Test User Can't Be Registered Because Name Is Too Long
     *
     * @test
     * @return void
     */
    public function user_cant_be_registered_because_name_is_too_long()
    {
        $to_long_name = preg_replace('/[[:digit:]]/', self::$faker->randomLetter, str_random(256));
        $this->visit('/register')
            ->type($to_long_name, 'name')
            ->type(self::$faker->unique()->safeEmail, 'email')
            ->type($password = self::$faker->password(), 'password')
            ->type($password, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The name may not be greater than 255 characters.');
    }

    /**
     * Test User Can't Be Registered Because Email Is Required
     *
     * @test
     * @return void
     */
    public function user_cant_be_registered_because_email_is_required()
    {
        $this->visit('/register')
            ->type(self::$faker->name, 'name')
            ->type($empty_email = '', 'email')
            ->type($password = self::$faker->password(), 'password')
            ->type($password, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The email field is required.');
    }

    /**
     * Test User Can't Be Registered Because Email Is Too Long
     *
     * @test
     * @return void
     */
    public function user_cant_be_registered_because_email_is_too_long()
    {
        $too_long_email = preg_replace('/[[:digit:]]/', self::$faker->randomLetter, str_random(256));
        $this->visit('/register')
            ->type(self::$faker->name, 'name')
            ->type($too_long_email.'@gmail.com', 'email')
            ->type($password = self::$faker->password(), 'password')
            ->type($password, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The email must be a valid email address.');
    }

    /**
     * Test User Can't Be Registered Because Email Is Not Valid
     *
     * @test
     * @return void
     */
    public function user_cant_be_registered_because_email_is_not_valid()
    {
        $this->visit('/register')
            ->type(self::$faker->name, 'name')
            ->type($invalid_email = 'email_address_without_at_sign.com', 'email')
            ->type($password = self::$faker->password(), 'password')
            ->type($password, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The email must be a valid email address.');
    }

    /**
     * Test User Can't Be Registered Because Email Has Alrady Been Taken
     *
     * @test
     * @return void
     */
    public function user_cant_be_registered_because_email_has_already_been_taken()
    {
        factory(User::class)->create([
            'email' => $existing_email = self::$faker->unique()->safeEmail,
        ]);
        $this->visit('/register')
            ->type(self::$faker->name, 'name')
            ->type($existing_email, 'email')
            ->type($password = self::$faker->password(), 'password')
            ->type($password, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The email has already been taken.');
    }

    /**
     * Test User Can't Be Registered Because Password Is Required
     *
     * @test
     * @return void
     */
    public function user_cant_be_registered_because_password_is_required()
    {
        $this->visit('/register')
            ->type(self::$faker->name, 'name')
            ->type(self::$faker->unique()->safeEmail, 'email')
            ->type($empty_password = '', 'password')
            ->type($empty_password, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The password field is required.');
    }

    /**
     * Test User Can't Be Registered Because Password Is Too Short
     *
     * @test
     * @return void
     */
    public function user_cant_be_registered_because_password_is_too_short()
    {
        $this->visit('/register')
            ->type(self::$faker->name, 'name')
            ->type(self::$faker->unique()->safeEmail, 'email')
            ->type($short_password = str_random(5), 'password')
            ->type($short_password, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The password must be at least 6 characters.');
    }

    /**
     * Test User Can't Be Registered Because Password Confirmation Does Not Match
     *
     * @test
     * @return void
     */
    public function user_cant_be_registered_because_password_confirmation_does_not_match()
    {
        $this->visit('/register')
            ->type(self::$faker->name, 'name')
            ->type(self::$faker->unique()->safeEmail, 'email')
            ->type($password = self::$faker->password(), 'password')
            ->type($mismatch_password = str_random(8), 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The password confirmation does not match.');
    }

    /**
     * Test Truncate User And PasswordReset Table
     *
     * @test
     * @return void
     */
    public function truncate_user_table()
    {
        User::truncate();
        DB::table('password_resets')->truncate();
        $this->assertNull(User::first());
    }
}
