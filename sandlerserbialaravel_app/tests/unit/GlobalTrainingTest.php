<?php

use App\GlobalTraining;

class GlobalTrainingTest extends \TestCase
{
    /**
     * GlobalTraining object
     *
     * @var App\GlobalTraining
     */
    protected static $global_training;

    /**
     * Creates GlobalTraining
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(GlobalTraining::first())) {
            GlobalTraining::truncate();
            factory(GlobalTraining::class)->create();
        }
        self::$global_training = GlobalTraining::first();
    }

    /**
     * Test If GlobalTraining Object Is An Instance of GlobalTraining Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_global_training()
    {
        $this->assertInstanceOf('App\GlobalTraining', self::$global_training);
    }

    /**
     * Test If GlobalTrainings Table Returns 1 Record
     *
     * @test
     * @return void
     */
    public function if_global_trainings_table_returns_1_record()
    {
        $this->assertEquals(1, GlobalTraining::count());
    }

     /**
     * Test If GlobalTrainings 1 Is GlobalTraining Record
     *
     * @test
     * @return void
     */
    public function if_global_trainings_1_is_globaltraining_record()
    {
        $this->assertEquals(1, self::$global_training->id);
    }

    /**
     * Test if Method get_global_training Returns First Row From GlobalTraining Table
     *
     * @test
     * @return void
     */
    public function get_global_training_returns_first_row_in_global_training_table()
    {
        $this->assertEquals((new GlobalTraining)->get_global_training()->id, GlobalTraining::first()->id);
    }
}
