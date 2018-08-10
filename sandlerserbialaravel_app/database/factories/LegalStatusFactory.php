  <?php

/* Legal Status Factory   */
  $factory->define(App\LegalStatus::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(45),
        'icon' => $faker->text(45)
    ];
  });

/* Legal Status Factory - Legal Status */
  $factory->defineAs(App\LegalStatus::class, 'legal', function ($faker) use ($factory) {
    $status = $factory->raw(App\LegalStatus::class);
    return array_merge($status, [
        'id' => 1,
        'name' => 'Pravno lice',
        'icon' => 'fa-building-o'
    ]);
  });

  /* Legal Status Factory - Individual Status */
  $factory->defineAs(App\LegalStatus::class, 'individual', function ($faker) use ($factory) {
    $status = $factory->raw(App\LegalStatus::class);
    return array_merge($status, [
        'id' => 2,
        'name' => 'Fizičko lice',
        'icon' => 'fa-user'
    ]);
  });
