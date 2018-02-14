<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Parse::class, function (Faker $faker) {
    return [
        'member_name' => $faker->name,
        'forum_link' => $faker->url,
        'parse_link' => $faker->url,
        'parse_date' => $faker->date,
        'parse_dps' => $faker->randomFloat(2, 8000, 12000),
        'advanced_class' => $faker->randomElement($array = array('Assassin', 'Juggernaut', 'Marauder', 'Mercenary', 'Operative', 'Powertech', 'Sniper', 'Sorcerer')),
        'specialization' => $faker->randomElement($array = array("Darkness", "Deception", "Hatred", "Immortal", "Vengeance", "Rage", "Annihilation", "Carnage", "Fury", "Arsenal", "Bodyguard", "Innovative Ordnance", "Concealment", "Lethality", "Medicine", "Advanced Prototype", "Pyrotech", "Shield Tank", "Engineering", "Marksmanship", "Virulance", "Corruption", "Lightning", "Madness")),
        'is_crazy' => $faker->boolean(20)
    ];
});
