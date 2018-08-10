  <?php

/* Client Status Factory   */
  $factory->define(App\ClientStatus::class, function (Faker\Generator $faker) {
    return [
        'local_name' => $faker->unique()->text(45),
        'local_icon' => $faker->text(45),
        'global_name' => $faker->text(45),
        'global_icon' => $faker->text(45),
        'text_color' => $faker->text(45)
    ];
  });


/* Client Status Factory - Not Contacted */
  $factory->defineAs(App\ClientStatus::class, 'not_contacted', function ($faker) use ($factory) {
    $client_status = $factory->raw(App\ClientStatus::class);
    return array_merge($client_status, [
        'id' => 1,
        'local_name' => 'Nije kontaktiran',
        'local_icon' => 'fa-phone-square',
        'global_name' => 'Suspect',
        'global_icon' => 'fa-star-o',
        'text_color' => 'text-white',
    ]);
  });

  /* Client Status Factory - Disqulified */
  $factory->defineAs(App\ClientStatus::class, 'disqualified', function ($faker) use ($factory) {
    $client_status = $factory->raw(App\ClientStatus::class);
    return array_merge($client_status, [
        'id' => 2,
        'local_name' => 'Diskvalifikovan',
        'local_icon' => 'fa-ban',
        'global_name' => 'Suspect',
        'global_icon' => 'fa-star-o',
        'text_color' => 'text-danger',
    ]);
  });

  /* Client Status Factory - Accept Meeting */
  $factory->defineAs(App\ClientStatus::class, 'accept_meeting', function ($faker) use ($factory) {
    $client_status = $factory->raw(App\ClientStatus::class);
    return array_merge($client_status, [
        'id' => 3,
        'local_name' => 'Prihvatio sastanak',
        'local_icon' => 'fa-handshake-o',
        'global_name' => 'Prospect',
        'global_icon' => 'fa-star-half-o',
        'text_color' => 'text-success',
    ]);
  });

  /* Client Status Factory - JPB */
  $factory->defineAs(App\ClientStatus::class, 'jpb', function ($faker) use ($factory) {
    $client_status = $factory->raw(App\ClientStatus::class);
    return array_merge($client_status, [
        'id' => 4,
        'local_name' => 'JPB',
        'local_icon' => 'fa-thumbs-o-up',
        'global_name' => 'Prospect',
        'global_icon' => 'fa-star-half-o',
        'text_color' => 'text-info',
    ]);
  });

  /* Client Status Factory - Inactive */
  $factory->defineAs(App\ClientStatus::class, 'inactive', function ($faker) use ($factory) {
    $client_status = $factory->raw(App\ClientStatus::class);
    return array_merge($client_status, [
        'id' => 5,
        'local_name' => 'Neaktivan',
        'local_icon' => 'fa-toggle-off',
        'global_name' => 'Client',
        'global_icon' => 'fa-star',
        'text_color' => 'text-muted',
    ]);
  });

  /* Client Status Factory - Active */
  $factory->defineAs(App\ClientStatus::class, 'active', function ($faker) use ($factory) {
    $client_status = $factory->raw(App\ClientStatus::class);
    return array_merge($client_status, [
        'id' => 6,
        'local_name' => 'Aktivan',
        'local_icon' => 'fa-toggle-on',
        'global_name' => 'Client',
        'global_icon' => 'fa-star',
        'text_color' => 'text-primary',
    ]);
  });
