<?php

class SeedingTest extends TestCase
{
    /**
     * Test Seeding Database
     *
     * @test
     * @return void
     */
    public function seeding_database()
    {
        $this->assertEquals(0, Artisan::call('migrate'));
    }
}
