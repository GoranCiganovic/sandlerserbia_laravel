<?php

use App\User;

class UserFeatureTest extends TestCase
{
        /**
     * Adin Users
     *
     * @var App\User
     */
    protected $admins;

    /**
     * Users Non Admin
     *
     * @var App\User
     */
    protected $users;

    /**
     * Authorized User
     *
     * @var App\User
     */
    protected $authorized_user;

    /**
     * Unuthorized User
     *
     * @var App\User
     */
    protected $unauthorized_user;

    /**
     * Faker object
     *
     * @var \Faker\Factory
     */
    protected static $faker;

    /**
     * Creates Admin Users, Regular Users, Regular Authorized And Regular Unauthorized User, Faker
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        /* In TestCase 2 Users Created */
        if (is_null(User::where('is_admin', 1)->first())) {
            factory(User::class, 'is_admin', 2)->create();
        }
        $this->admins = User::where('is_admin', 1)->get();

        if (is_null(User::where('is_admin', 0)->first())) {
            factory(User::class, 2)->create();
        }
        $this->users = User::where('is_admin', 0)->get();
        

        if (is_null(User::where('is_admin', 0)->where('is_unauthorized', 0)->first())) {
            factory(User::class, 'authorized')->create();
        }
        $this->authorized_user = User::where('is_admin', 0)->where('is_unauthorized', 0)->first();

        if (is_null(User::where('is_admin', 0)->where('is_unauthorized', 1)->first())) {
            factory(User::class, 'unauthorized')->create();
        }
        $this->unauthorized_user = User::where('is_admin', 0)->where('is_unauthorized', 1)->first();

        if (is_null(self::$faker)) {
            self::$faker = Faker\Factory::create();
        }
    }

    /**
     * Test Admin Can See The List Of All Non Admin Users (UserContraller@index)
     *
     * @test
     * @return void
     */
    public function admin_can_see_the_list_of_all_non_admin_users()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->click('#users_all')
            ->seePageIs('/users')
            ->see('Korisnici');
        foreach ($this->users as $user) {
            $this->see($user->name)
                ->see('/user/show/' . $user->id);
        }
    }

    /**
     * Test Http Get Request Show All Non Admin Users To Admin (UserContraller@index)
     *
     * @test
     * @return void
     */
    public function http_get_request_show_all_non_admin_users_to_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/users')
            ->assertResponseStatus(200)
            ->assertViewHas('users');
    }

    /**
     * Test User Can Not See The List Of All Non Admin Users (UserContraller@index)
     *
     * @test
     * @return void
     */
    public function user_can_not_see_the_list_of_all_non_admin_users()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->dontSee('Korisnici')
            ->visit('/users')
            ->seePageIs('/home')
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test Http Get Request Dont Show All Users To User (UserContraller@index)
     *
     * @test
     * @return void
     */
    public function http_get_request_show_all_users_to_user()
    {
        $this->actingAs(self::$user)
            ->get('/users')
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/', ["message" => "Nemate ovlašćenje za ovu akciju!"]);
    }

    /**
     * Test Admin Can Not See The List Of Admin Users (UserContraller@index)
     *
     * @test
     * @return void
     */
    public function admin_can_not_see_the_list_of_admin_users()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->click('#users_all')
            ->seePageIs('/users')
            ->see('Korisnici');
        foreach ($this->admins as $admin) {
            $this->dontSee('/user/show/' . $admin->id);
        }
    }

    /**
     * Test Http Get Request Dont Show Admin Users To Admin (UserContraller@index)
     *
     * @test
     * @return void
     */
    public function http_get_request_dont_show_admin_users_to_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/users')
            ->assertResponseStatus(200)
            ->assertViewHas('users');
        foreach ($this->admins as $admin) {
            $this->assertViewMissing('/user/show/' . $admin->id);
        }
    }

    /**
     * Test Admin Can Return From Users Page To Home Page (UserContraller@index)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_users_page_to_home_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->visit('/users')
            ->see('Korisnici')
            ->click('Nazad')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

    /**
     * Test Admin Can See Displayed Non Admin User Profile For Authorization (UserController@show)
     *
     * @test
     * @return void
     */
    public function admin_can_see_displayed_non_admin_user_profile_for_authorization()
    {
        $this->actingAs(self::$admin)
            ->visit('/users')
            ->click($this->authorized_user->name)
            ->seePageIs('/user/show/' . $this->authorized_user->id)
            ->see($this->authorized_user->name)
            ->see($this->authorized_user->email)
            ->see('OBRIŠI KORISNIKA');
    }

    /**
     * Test Http Get Request Show Non Admin User Profile For Authorization To Admin (UserContraller@show)
     *
     * @test
     * @return void
     */
    public function http_get_request_show_non_admin_user_profile_for_authorization_to_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/user/show/' . $this->authorized_user->id)
            ->assertResponseStatus(200)
            ->assertViewHas('user');
    }

    /**
     * Test Admin Can Not See Displayed Admin User Profile For Authorization (UserContraller@show)
     *
     * @test
     * @return void
     */
    public function admin_can_not_see_displayed_admin_user_profile_for_authorization()
    {
        $this->actingAs(self::$admin)
            ->visit('/users')
            ->dontSee('/user/show/' . self::$admin->id);
    }

     /**
     * Test Http Get Request Dont Show Admin User Profile For Authorization To Admin (UserContraller@show)
     *
     * @test
     * @return void
     */
    public function http_get_request_dont_show_admin_user_profile_for_authorization_to_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/user/show/' . self::$admin->id)
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/', ["message" => "Akcija nije moguća! Korisnik " . self::$admin->name . " je administrator!"]);
    }

    /**
     * Test Http Get Request Dont Show User Profile For Authorization To User (UserContraller@show)
     *
     * @test
     * @return void
     */
    public function http_get_request_dont_show_user_profile_for_authorization_to_user()
    {
        $this->actingAs(self::$user)
            ->get('/user/show/' . $this->authorized_user->id)
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/', ["message" => "Nemate ovlašćenje za ovu akciju!"]);
    }

    /**
     * Test Http Get Request Dont Show Admin Profile For Authorization To User (UserContraller@show)
     *
     * @test
     * @return void
     */
    public function http_get_request_dont_show_admin_profile_for_authorization_to_user()
    {
        $this->actingAs(self::$user)
            ->get('/user/show/' . self::$admin->id)
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/', ["message" => "Nemate ovlašćenje za ovu akciju!"]);
    }

    /**
     * Test Admin Can Return From User Profile Page For Authorization To  Users Page (UserContraller@show)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_user_profile_page_for_authorization_to_users_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/users')
            ->visit('/user/show/' . self::$user->id)
            ->see(self::$user->name)
            ->click('Korisnici')
            ->seePageIs('/users')
            ->see('Korisnici');
    }

    /**
     * Test Displaying The Form For Editing User Profile (UserController@edit)
     *
     * @test
     * @return void
     */
    public function displaying_form_for_editing_user_profile()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->click('#user_edit')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->see(self::$user->name)
            ->see(self::$user->email)
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing User Profile (UserController@edit)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_user_profile()
    {
        $this->actingAs(self::$user)
            ->get('/user/edit/' . self::$user->id)
            ->assertResponseStatus(200)
            ->assertViewHas('user');
    }

    /**
     * Test Admin Can Not See User Profile Edit Page (UserContraller@edit)
     *
     * @test
     * @return void
    */
    public function admin_can_not_see_user_profile_edit_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->visit('/user/edit/' . self::$user->id)
            ->seePageIs('/home')
            ->dontSee(self::$user->name);
    }

    /**
     * Test Http Get Request Dont Show Form For Editing User Profile To Admin (UserController@edit)
     *
     * @test
     * @return void
     */
    public function http_get_request_dont_show_user_profile_edit_page_to_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/user/edit/' . self::$user->id)
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/home');
    }

    /**
     * Test User Can Not See Admin Profile Edit Page (UserContraller@edit)
     *
     * @test
     * @return void
    */
    public function user_can_not_see_admin_profile_edit_page()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->visit('/user/edit/' . self::$admin->id)
            ->seePageIs('/home')
            ->dontSee(self::$admin->name);
    }

    /**
     * Test Http Get Request Dont Show Form For Editing Admin Profile To User (UserController@edit)
     *
     * @test
     * @return void
     */
    public function http_get_request_dont_show_admin_profile_edit_page_to_user()
    {
        $this->actingAs(self::$user)
            ->get('/user/edit/' . self::$admin->id)
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/home');
    }

    /**
     * Test Admin Can Return From Admin Profile Page To Home Page (UserContraller@edit)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_admin_profile_page_to_home_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->visit('/user/edit/' . self::$admin->id)
            ->see(self::$admin->name)
            ->click('Nazad')
            ->seePageIs('/home');
    }

    /**
     * Test User Can Return From User Profile Page To Home Page (UserContraller@edit)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_user_profile_page_to_home_page()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->visit('/user/edit/' . self::$user->id)
            ->see(self::$user->name)
            ->click('Nazad')
            ->seePageIs('/home');
    }

    /**
     * Test User Can Update Profile (UserController@update)
     *
     * @test
     * @return void
     */
    public function user_can_update_profile()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type(self::$user->name, 'name')
            ->type($email = self::$faker->email, 'email')
            ->type($password = self::$faker->password, 'password')
            ->type($password, 'password_confirmation')
            ->type($phone = '', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->seeInDatabase('users', ['id' => self::$user->id, 'email' => $email])
            ->see('Podaci su uspešno izmenjeni.');
    }


    /**
     * Test Update User Name Must Be Filled (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_name_must_be_filled()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = '', 'name')
            ->type($email = self::$faker->email, 'email')
            ->type($password = self::$faker->password, 'password')
            ->type($password, 'password_confirmation')
            ->type($phone = '', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'name' => $name])
            ->see('Polje Ime mora biti popunjeno.');
    }

    /**
     * Test Update User Name Must Be Valid (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_name_must_be_valid()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = self::$faker->password, 'name')
            ->type($email = self::$faker->email, 'email')
            ->type($password = self::$faker->password, 'password')
            ->type($password, 'password_confirmation')
            ->type($phone = '', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'name' => $name])
            ->see('Polje Ime može sadržati samo slova, razmake, tačke, srednje crte i apostrofe.');
    }

    /**
     * Test Update User Name Is Too Long (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_name_is_too_long()
    {
        $too_long_name = preg_replace('/[[:digit:]]/', self::$faker->randomLetter, str_random(256));
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($too_long_name, 'name')
            ->type($email = self::$faker->email, 'email')
            ->type($password = self::$faker->password, 'password')
            ->type($password, 'password_confirmation')
            ->type($phone = '', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'name' => $too_long_name])
            ->see('Polje Ime mora sadržati manje od 255 karaktera.');
    }

    /**
     * Test Update User Email Must Be Unique (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_email_must_be_unique()
    {
        $existing_email = User::where('email', '!=', self::$user->email)->inRandomOrder()->first()->email;
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = self::$faker->name, 'name')
            ->type($existing_email, 'email')
            ->type($password = self::$faker->password, 'password')
            ->type($password, 'password_confirmation')
            ->type($phone = '', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'email' => $existing_email])
            ->see('Polje Email adresa već postoji.');
    }

    /**
     * Test Update User Email Must Be Valid (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_email_must_be_valid()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = self::$faker->name, 'name')
            ->type($invalid_email = self::$faker->name, 'email')
            ->type($password = self::$faker->password, 'password')
            ->type($password, 'password_confirmation')
            ->type($phone = '', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'email' => $invalid_email])
            ->see('Format polja Email adresa nije validan.');
    }

    /**
     * Test Update User Email Must Be Filled (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_email_must_be_filled()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = self::$faker->name, 'name')
            ->type($email = '', 'email')
            ->type($password = self::$faker->password, 'password')
            ->type($password, 'password_confirmation')
            ->type($phone = '', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'email' => $email])
            ->see('Polje Email adresa mora biti popunjeno.');
    }

    /**
     * Test Update User Email Is Too Long (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_email_is_too_long()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = self::$faker->name, 'name')
            ->type($email = str_random(256).'@gmail.com', 'email')
            ->type($password = self::$faker->password, 'password')
            ->type($password, 'password_confirmation')
            ->type($phone = '', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'email' => $email])
            ->see('Format polja Email adresa nije validan.');
    }

    /**
     * Test Update User Email Is Too Short (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_email_is_too_short()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = self::$faker->name, 'name')
            ->type($email = self::$faker->randomLetter . '@mail.rs', 'email')
            ->type($password = self::$faker->password, 'password')
            ->type($password, 'password_confirmation')
            ->type($phone = '', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'email' => $email])
            ->see('Polje Email adresa mora sadržati najmanje 10 karaktera.');
    }

    /**
     * Test Update User Password Confirmation Is Required (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_password_is_required()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = self::$faker->name, 'name')
            ->type($email = self::$faker->email, 'email')
            ->type($password = '', 'password')
            ->type(self::$faker->password, 'password_confirmation')
            ->type($phone = '', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'name' => $name])
            ->see('Polje Lozinka je obavezno.');
    }

    /**
     * Test Update User Password Confirmation Is Required (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_password_confirmation_is_required()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = self::$faker->name, 'name')
            ->type($email = self::$faker->email, 'email')
            ->type($password = self::$faker->password, 'password')
            ->type('', 'password_confirmation')
            ->type($phone = '', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'name' => $name])
            ->see('Potvrda polja Lozinka se ne poklapa.')
            ->see('Polje Potvrda lozinke je obavezno.');
    }

    /**
     * Test Update User Password Is Too Long (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_password_is_too_long()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = self::$faker->name, 'name')
            ->type($email = self::$faker->email, 'email')
            ->type($password = str_random(256), 'password')
            ->type($password, 'password_confirmation')
            ->type($phone = '', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'name' => $name])
            ->see('Polje Lozinka mora sadržati manje od 255 karaktera.')
            ->see('Polje Potvrda lozinke mora sadržati manje od 255 karaktera.');
    }

    /**
     * Test Update User Password Is Too Short (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_password_is_too_short()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = self::$faker->name, 'name')
            ->type($email = self::$faker->email, 'email')
            ->type($password = self::$faker->text(5), 'password')
            ->type($password, 'password_confirmation')
            ->type($phone = '', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'name' => $name])
            ->see('Polje Lozinka mora sadržati najmanje 6 karaktera.')
            ->see('Polje Potvrda lozinke mora sadržati najmanje 6 karaktera.');
    }

    /**
     * Test Update User Password Does Not Match (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_password_does_not_match()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = self::$faker->name, 'name')
            ->type($email = self::$faker->email, 'email')
            ->type($password = self::$faker->password, 'password')
            ->type(self::$faker->password, 'password_confirmation')
            ->type($phone = '', 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'name' => $name])
            ->see('Potvrda polja Lozinka se ne poklapa.');
    }

    /**
     * Test Update User Phone Is Too Short (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_phone_is_too_short()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = self::$faker->name, 'name')
            ->type($email = self::$faker->email, 'email')
            ->type($password = self::$faker->password, 'password')
            ->type($password, 'password_confirmation')
            ->type($phone = self::$faker->randomNumber(5), 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'phone' => $phone])
            ->see('Polje Telefon mora biti izemđu 6 i 30 cifri.');
    }

    /**
     * Test Update User Phone Is Too Long (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_phone_is_too_long()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = self::$faker->name, 'name')
            ->type($email = self::$faker->email, 'email')
            ->type($password = self::$faker->password, 'password')
            ->type($password, 'password_confirmation')
            ->type($phone = str_random(31), 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'phone' => $phone])
            ->see('Polje Telefon mora biti izemđu 6 i 30 cifri.');
    }

    /**
     * Test Update User Phone Must Contain Digits (UserController@update)
     *
     * @test
     * @return void
     */
    public function update_user_phone_must_contain_digits()
    {
        $this->actingAs(self::$user)
            ->visit('/user/edit/' . self::$user->id)
            ->type($name = self::$faker->name, 'name')
            ->type($email = self::$faker->email, 'email')
            ->type($password = self::$faker->password, 'password')
            ->type($password, 'password_confirmation')
            ->type($phone = self::$faker->text(20), 'phone')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/user/edit/' . self::$user->id)
            ->dontSeeInDatabase('users', ['id' => self::$user->id, 'phone' => $phone])
            ->see('Polje Telefon mora biti izemđu 6 i 30 cifri.');
    }
 
    /**
     * Test False Update User With Get Method (UserController@update)
     *
     * @test
     * @return void
     */
    public function false_update_user_with_get_method()
    {
        $this->actingAs(self::$user)
            ->get('user/update/' . self::$user->id)
            ->assertResponseStatus(405)
            ->see('405 Something Went Wrong');
    }

    /**
     * Test Admin Can Authorize Unauthorized User (UserController@authorized)
     *
     * @test
     * @return void
     */
    public function admin_can_authorize_unauthorized_user()
    {
        $this->actingAs(self::$admin)
            ->visit('/user/show/' . $this->unauthorized_user->id)
            ->click('OMOGUĆI PRISTUP')
            ->see('Korisniku je omogućen pristup.');
    }

    /**
     * Test Http Get Request Authorize Unuthorized User As Admin (UserController@authorized)
     *
     * @test
     * @return void
     */
    public function http_get_request_authorize_unauthorized_user_as_admin()
    {
        $this->actingAs(self::$admin)
            ->get('user/authorized/' . $this->unauthorized_user->id)
             ->assertRedirectedTo('/', ["message" => "Korisniku je omogućen pristup."]);
    }

    /**
     * Test User Can Not Authorize Unauthorized User (UserController@authorized)
     *
     * @test
     * @return void
     */
    public function user_can_not_authorize_unauthorized_user()
    {
        $this->actingAs(self::$user)
            ->visit('/user/show/' . $this->unauthorized_user->id)
            ->dontSee('OMOGUĆI PRISTUP')
            ->get('user/authorized/' . $this->unauthorized_user->id)
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/', ["message" => "Nemate ovlašćenje za ovu akciju!"]);
    }

    /**
     * Test Http Get Request Authorize Unuthorized User As Admin (UserController@authorized)
     *
     * @test
     * @return void
     */
    public function http_get_request_authorize_unauthorized_user_as_user()
    {
        $this->actingAs(self::$user)
            ->get('user/authorized/' . $this->unauthorized_user->id)
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/', ["message" => "Nemate ovlašćenje za ovu akciju!"]);
    }

    /**
     * Test Admin Can Unauthorize Authorized User (UserController@unauthorized)
     *
     * @test
     * @return void
     */
    public function admin_can_unauthorize_authorized_user()
    {
        $this->actingAs(self::$admin)
            ->visit('/user/show/' . $this->authorized_user->id)
            ->click('ONEMOGUĆI PRISTUP')
            ->seePageIs('/user/show/' . $this->authorized_user->id)
            ->see('Korisniku je onemogućen pristup!');
    }

    /**
     * Test Http Get Request Unuthorize Authorized User As Admin (UserController@unauthorized)
     *
     * @test
     * @return void
     */
    public function http_get_request_unauthorize_authorized_user_as_admin()
    {
        $this->actingAs(self::$admin)
            ->get('user/unauthorized/' . $this->authorized_user->id)
             ->assertRedirectedTo('/', ["message" => "Korisniku je onemogućen pristup!"]);
    }

    /**
     * Test User Can Not Unauthorize Authorized User (UserController@unauthorized)
     *
     * @test
     * @return void
     */
    public function user_can_not_unauthorize_authorized_user()
    {
        $this->actingAs(self::$user)
            ->visit('/user/show/' . $this->authorized_user->id)
            ->dontSee('ONEMOGUĆI PRISTUP')
            ->get('user/unauthorized/' . $this->authorized_user->id)
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/', ["message" => "Nemate ovlašćenje za ovu akciju!"]);
    }

    /**
     * Test Http Get Request Authorize Unuthorized User As Admin (UserController@unauthorized)
     *
     * @test
     * @return void
     */
    public function http_get_request_unauthorize_authorized_user_as_user()
    {
        $this->actingAs(self::$user)
            ->get('user/unauthorized/' . $this->authorized_user->id)
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/', ["message" => "Nemate ovlašćenje za ovu akciju!"]);
    }

    /**
     * Test Admin Can Delete User (UserController@destroy)
     *
     * @test
     * @return void
     */
    public function admin_can_delete_user()
    {
        $user = factory(User::class)->create();
        $this->actingAs(self::$admin)
            ->visit('/user/show/' . $user->id)
            ->click('OBRIŠI KORISNIKA')
            ->seePageIs('/users')
            ->see('Korisnik ' . $user->name . ' je obrisan!')
            ->notSeeInDatabase('users', ['id' => $user->id]);
    }

    /**
     * Test Http Get Request Delete User As Admin (UserController@destroy)
     *
     * @test
     * @return void
     */
    public function http_get_request_delete_user_as_admin()
    {
        $user = factory(User::class)->create();
        $this->actingAs(self::$admin)
            ->get('/user/delete/' . $user->id)
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/users', ["message" => "Korisnik " . $user->name . " je obrisan!"])
            ->notSeeInDatabase('users', ['id' => $user->id]);
    }

    /**
     * Test User Can Not Delete User (UserController@destroy)
     *
     * @test
     * @return void
     */
    public function user_can_not_delete_user()
    {
        $this->actingAs(self::$user)
            ->visit('/user/show/' . self::$user->id)
            ->dontSee('OBRIŠI KORISNIKA')
            ->seePageIs('/');
    }

     /**
     * Test Http Get Request Delete User As User (UserController@destroy)
     *
     * @test
     * @return void
     */
    public function http_get_request_delete_user_as_user()
    {
        $this->actingAs(self::$user)
            ->get('/user/delete/' . self::$user->id)
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/', ["message" => "Nemate ovlašćenje za ovu akciju!"]);
    }

    /**
     * Test Admin Can Not Delete Admin (UserController@destroy)
     *
     * @test
     * @return void
     */
    public function admin_can_not_be_deleted()
    {
        $this->actingAs(self::$admin)
            ->visit('/user/show/' . self::$admin->id)
            ->dontSee('OBRIŠI KORISNIKA')
            ->seePageIs('/');
    }

    /**
     * Test Http Get Request Delete Admin As Admin (UserController@destroy)
     *
     * @test
     * @return void
     */
    public function http_get_request_delete_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/user/delete/' . self::$admin->id)
            ->assertResponseStatus(302)
            ->assertRedirectedTo('/', ["message" => "Akcija nije moguća! Korisnik " . self::$admin->name . " je administrator!"]);
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
