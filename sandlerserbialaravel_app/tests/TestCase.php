<?php

use App\User;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * User
     *
     * @var \App\User
     */
    protected static $user;

    /**
     * Admin User
     *
     * @var \App\User
     */
    protected static $admin;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://sandlerserbia.local';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Creates Regular User, Admin User
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        /* Create Admin And Regular User */
        if (is_null(User::where('is_admin', 1)->first())) {
            factory(User::class, 'is_admin')->create();
        }
        self::$admin = User::where('is_admin', 1)->first();

        if (is_null(User::where('is_admin', 0)->first())) {
            factory(User::class)->create();
        }
        self::$user = User::where('is_admin', 0)->first();
    }
}
