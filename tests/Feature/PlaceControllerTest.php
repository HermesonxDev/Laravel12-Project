<?php

use Illuminate\Support\Facades\Log;
use function Pest\Laravel\postJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\deleteJson;
use App\Models\Place;

uses(Tests\TestCase::class)->group('place');

describe('successful tests', function () {
    it('should returns 201 when create place', function () {
        $place = Place::factory()->make()->toArray();

        $response = postJson('/api/place/create', $place);

        $response->assertStatus(201)
                 ->assertJson([
                    'message' => 'place created successfully'
                 ]);
    });

    it('should returns 200 when get places', function () {
        $response = getJson('/api/place/places');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    '*' => [
                        'id',
                        'name',
                        'slug',
                        'city',
                        'state',
                        'created_at',
                        'updated_at'
                    ]
                 ]);
    });

    it('should returns 200 when get place by name', function () {
        $place = Place::inRandomOrder()->first();

        $response = getJson("/api/place/places?name={$place->name}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    [
                        'id',
                        'name',
                        'slug',
                        'city',
                        'state',
                        'created_at',
                        'updated_at'
                    ]
                 ]);
    });

    it('should returns 200 when edit place', function () {
        $place = Place::inRandomOrder()->first();

        $updatedPlace = Place::factory()->make()->toArray();

        $response = putJson("/api/place/edit/{$place->id}", $updatedPlace);

        $response->assertStatus(200)
                 ->assertJson([
                    'message' => 'place edited successfully'
                 ]);

        $this->assertDatabaseHas('places', [
            'id'    => $place->id,
            'name'  => $updatedPlace['name'],
            'slug'  => $updatedPlace['slug'],
            'city'  => $updatedPlace['city'],
            'state' => $updatedPlace['state']
        ]);
    });

    it('should returns 200 when delete place', function () {
        $place = Place::inRandomOrder()->first();

        $response = deleteJson("/api/place/delete/{$place->id}");

        $response->assertStatus(200)
                 ->assertJson([
                    'message' => 'place deleted successfully'
                 ]);

        $this->assertDatabaseMissing('places', [
            'id' => $place->id
        ]);                
    });
});

describe('validation tests', function () {

});