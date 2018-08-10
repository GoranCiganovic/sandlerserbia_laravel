<?php

use App\User;

class UserTest extends \TestCase
{

    /**
     * Test If User Object Is An Instance of User Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_user()
    {
        $this->assertInstanceOf('App\User', self::$user);
    }

    /**
     * Test if Method get_admin_email Returns First Adminstrator Email Column Vlaue
     *
     * @test
     * @return void
     */
    public function get_admin_email_returns_first_administator_email_column_value()
    {
        $this->assertEquals((new User)->get_admin_email(), User::where('id', 1)->where('is_admin', 1)->value('email'));
    }

    /**
     * Test if Method get_non_admin_users Returns Array Of Non Adminstrator Users
     *
     * @test
     * @return void
     */
    public function get_non_admin_users_returns_first_administator_email_column_value()
    {
        $this->assertEquals((new User)->get_non_admin_users(), User::where('is_admin', 0)->get());
    }
}
