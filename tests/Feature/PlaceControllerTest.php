<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Place;
use function Pest\Laravel\postJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\deleteJson;

uses(Tests\TestCase::class)->group('place');

describe('successful tests', function () {
    

    it('should return 201 when create place', function () {
        $place = Place::factory()->make()->toArray();

        $response = postJson('/api/place/create', $place);

        $response->assertStatus(201)
                 ->assertJson([
                    'message' => 'place created successfully'
                 ]);
    });


    it('should return 200 when get places', function () {
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


    it('should return 200 when get place by name', function () {
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


    it('should return 200 when edit place', function () {
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


    it('should return 200 when delete place', function () {
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

    dataset('requiredFields', [
        'The name field is required.'  => ['name'],
        'The city field is required.'  => ['city'],
        'The state field is required.' => ['state']
    ]);

    dataset('invalidFields', [
        ['name', 1234],
        ['city', 1234],
        ['state', 1234],
    ]);

    
    it('should return 422 if required field is missing on creation', function ($field) {
        $place = Place::factory()->make()->toArray();

        unset($place[$field]);
    
        $response = postJson('/api/place/create', $place);
    
        $response->assertStatus(422)
                 ->assertJsonValidationErrors([$field]);

    })->with('requiredFields');


    it('should return 422 if required field is missing in edit', function ($field) {
        $place = Place::inRandomOrder()->first();

        unset($place[$field]);

        $response = putJson("/api/place/edit/{$place->id}");

        $response->assertStatus(422)
                 ->assertJsonValidationErrors([$field]);

    })->with('requiredFields');


    it('should return 422 if fields are numbers instead of strings on creation', function ($field, $invalidValue) {
        $place = Place::factory()->make()->toArray();
    
        $place[$field] = $invalidValue;
    
        $response = postJson('/api/place/create', $place);
    
        $response->assertStatus(422)
                 ->assertJsonValidationErrors([$field]);
    
    })->with('invalidFields');


    it('should return 422 if fields are numbers instead of strings on edition', function ($field, $invalidValue) {
        $place = Place::inRandomOrder()->first()->toArray();

        $place[$field] = $invalidValue;

        $response = putJson("/api/place/edit/{$place['id']}", $place);
    
        $response->assertStatus(422)
                 ->assertJsonValidationErrors([$field]);
    
    })->with('invalidFields');


    it('should return 404 if trying to get a place with an invalid name', function () {
        $invalidName = Str::random(10);

        $response = getJson("/api/place/places?name={$invalidName}");

        $response->assertStatus(404)
                 ->assertJson([
                    'message' => 'error listing places',
                    'error' => 'place not found'
                 ]);
    });


    it('should return 404 if trying edit a place with an invalid id', function () {
        $invalidId = rand(1, 9999);

        $updatedPlace = Place::factory()->make()->toArray();

        $response = putJson("/api/place/edit/{$invalidId}", $updatedPlace);

        $response->assertStatus(404)
                 ->assertJson([
                    'message' => 'error while editing place',
                    'error' => 'place not found'
                 ]);
    });


    it('should return 404 if trying delete a place with an invalid id', function () {
        $invalidId = rand(1, 9999);

        $response = deleteJson("/api/place/delete/{$invalidId}");

        $response->assertStatus(404)
                 ->assertJson([
                    'message' => 'error in deleting place',
                    'error' => 'place not found'
                 ]);
    });
});