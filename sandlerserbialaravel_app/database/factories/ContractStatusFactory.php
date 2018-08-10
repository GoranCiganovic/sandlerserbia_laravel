  <?php

/* Contract Status Factory   */
  $factory->define(App\ContractStatus::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->text(45),
        'icon' => $faker->text(45),
        'color' => $faker->text(45)
    ];
  });


/* Contract Status Factory - Unsigned */
  $factory->defineAs(App\ContractStatus::class, 'unsigned', function ($faker) use ($factory) {
    $contract_status = $factory->raw(App\ContractStatus::class);
    return array_merge($contract_status, [
        'id' => 1,
        'name' => 'Nepotpisan',
        'icon' => 'fa-pencil-square-o',
        'color' => 'default'
    ]);
  });

  /* Contract Status Factory - In Progress */
  $factory->defineAs(App\ContractStatus::class, 'in_progress', function ($faker) use ($factory) {
    $contract_status = $factory->raw(App\ContractStatus::class);
    return array_merge($contract_status, [
        'id' => 2,
        'name' => 'U toku',
        'icon' => 'fa-star',
        'color' => 'info'
    ]);
  });

  /* Contract Status Factory - Finished */
  $factory->defineAs(App\ContractStatus::class, 'finished', function ($faker) use ($factory) {
    $contract_status = $factory->raw(App\ContractStatus::class);
    return array_merge($contract_status, [
        'id' => 3,
        'name' => 'Ispunjen',
        'icon' => 'fa-star-o',
        'color' => 'success'
    ]);
  });

  /* Contract Status Factory - Broken */
  $factory->defineAs(App\ContractStatus::class, 'broken', function ($faker) use ($factory) {
    $contract_status = $factory->raw(App\ContractStatus::class);
    return array_merge($contract_status, [
        'id' => 4,
        'name' => 'Raskinut',
        'icon' => 'fa-ban',
        'color' => 'danger'
    ]);
  });
