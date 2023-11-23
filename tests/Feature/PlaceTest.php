<?php

namespace Tests\Feature;

use App\Models\Place;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlaceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testListPlaces(): void
    {
        $response = $this->get('/api/places');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => ['id', 'name', 'city', 'state', 'slug']
                ]
            ]);
    }

    public function testCreatePlace(): void
    {
        $data = [
            'name' => $this->faker->name,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'slug' => $this->faker->slug
        ];

        $response = $this->postJson('/api/places', $data);
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Local cadastrado com sucesso'
            ]);
    }

    public function testOpenPlace(): void
    {
        $place = Place::factory()->create();

        $response = $this->get('/api/places/' . $place->id);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Local encontrado com sucesso'
            ]);
    }

    public function testUpdatePlace(): void
    {
        $place = Place::factory()->create();

        $updatedData = [
            'name' => 'Nome Atualizado',
            'city' => $place->city,
            'state' => $place->state,
            'slug' => $place->slug
        ];

        $response = $this->putJson('/api/places/' . $place->id, $updatedData);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Local atualizado com sucesso'
            ]);
    }

    public function testDestroyPlace(): void
    {
        $place = Place::factory()->create();

        $response = $this->delete('/api/places/' . $place->id);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Local removido com sucesso'
            ]);
    }

    public function testStoreValidation(): void
    {
        $invalidData = [
            'name' => '',
            'city' => 'A',
            'state' => 'ABCDE',
            'slug' => ''
        ];

        $response = $this->postJson('/api/places', $invalidData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'city', 'state', 'slug']);
    }

    public function testPlaceStoreRequiredFields(): void
    {
        $response = $this->postJson('/api/places', []);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'city', 'state', 'slug']);
    }

    public function testPlaceStoreInvalidFieldFormat(): void
    {
        $response = $this->postJson('/api/places', ['state' => 'Invalid']);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['state']);
    }

    public function testUpdateValidation(): void
    {
        $place = Place::factory()->create();

        $invalidData = [
            'name' => '',
            'city' => 'A',
            'state' => 'ABCDE',
            'slug' => ''
        ];

        $response = $this->putJson('/api/places/' . $place->id, $invalidData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'city', 'state', 'slug']);
    }


    public function testUpdateWithoutId(): void
    {
        $dataToUpdate = [
            'name' => 'Nome Atualizado',
            'city' => 'Cidade Atualizada',
            'state' => 'ST',
            'slug' => 'nome-atualizado'
        ];

        $response = $this->putJson(sprintf('/api/places/%s', ' '), $dataToUpdate);
        $response->assertStatus(404);
    }

    public function testSearchPlaceByName(): void
    {
        Place::factory()->create(['name' => 'Praça Alimentação']);
        Place::factory()->create(['name' => 'Parque Central']);

        $response = $this->getJson('/api/places?name=Praça');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Praça Alimentação'])
            ->assertJsonMissing(['name' => 'Parque Central']);
    }
}
