<?php

namespace Tests\Feature;

use App\Http\Requests\Author\StoreAuthorRequest;
use App\Http\Requests\Author\UpdateAuthorRequest;
use App\Models\Table\AuthorTable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsAuthors()
    {
        AuthorTable::factory()->count(5)->create();

        $response = $this->getJson(route('authors.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [['id', 'name', 'bio', 'birth_date']],
            ]);
    }

    public function testValidatesStoreCorrectData()
    {
        $data = [
            'name' => 'John Doe',
            'bio' => 'An experienced author.',
            'birth_date' => '1990-01-01',
        ];

        $request = new StoreAuthorRequest();

        $validator = Validator::make($data, $request->rules());
        $this->assertTrue($validator->passes());
    }

    public function testFailsStoreOnMissingName()
    {
        $data = [
            'bio' => 'An experienced author.',
            'birth_date' => '1990-01-01',
        ];

        $request = new StoreAuthorRequest();

        $validator = Validator::make($data, $request->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('name', $validator->errors()->messages());
    }

    public function testFailsStroreOnInvalidBirthDate()
    {
        $data = [
            'name' => 'John Doe',
            'bio' => 'An experienced author.',
            'birth_date' => 'invalid-date',
        ];

        $request = new StoreAuthorRequest();

        $validator = Validator::make($data, $request->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('birth_date', $validator->errors()->messages());
    }

    public function testStoreCreatesAuthor()
    {
        $data = ['name' => 'John Doe', 'bio' => 'Bio text', 'birth_date' => '1990-01-01'];

        $response = $this->postJson(route('authors.store'), $data);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', $data['name']);

        $this->assertDatabaseHas('authors', $data);
    }


    public function testShowReturnsAuthor()
    {
        $author = AuthorTable::factory()->create();

        $response = $this->getJson(route('authors.show', $author->id));

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $author->id);
    }

    public function testShowReturnsAuthorBooks()
    {
        $author = AuthorTable::factory()->hasBooks(3)->create();

        $response = $this->getJson(route('authors.books', $author->id));

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function testValidatesUpdateCorrectData()
    {
        $data = [
            'name' => 'Jane Doe',
            'bio' => 'A skilled writer.',
            'birth_date' => '1985-05-15',
        ];

        $request = new UpdateAuthorRequest();

        $validator = Validator::make($data, $request->rules());
        $this->assertTrue($validator->passes());
    }

    public function testAllowsUpdatePartialUpdates()
    {
        $data = [
            'bio' => 'Updated biography.',
        ];

        $request = new UpdateAuthorRequest();

        $validator = Validator::make($data, $request->rules());
        $this->assertTrue($validator->passes());
    }

    public function testFailsUpdateOnInvalidName()
    {
        $data = [
            'name' => str_repeat('A', 256), // Melebihi 255 karakter
        ];

        $request = new UpdateAuthorRequest();

        $validator = Validator::make($data, $request->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('name', $validator->errors()->messages());
    }

    public function testFailsUpdateOnInvalidBirthDate()
    {
        $data = [
            'birth_date' => 'not-a-date',
        ];

        $request = new UpdateAuthorRequest();

        $validator = Validator::make($data, $request->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('birth_date', $validator->errors()->messages());
    }

    public function testUpdateAuthor()
    {
        $author = AuthorTable::factory()->create();
        $data = ['name' => 'Updated Name', 'bio' => 'Updated Bio', 'birth_date' => '1991-01-01'];

        $response = $this->putJson(route('authors.update', $author->id), $data);

        $response->assertStatus(200)
            ->assertJsonPath('data.name', $data['name']);

        $this->assertDatabaseHas('authors', $data);
    }

    public function testDeleteAuthor()
    {
        $author = AuthorTable::factory()->create();

        $response = $this->deleteJson(route('authors.destroy', $author->id));

        $response->assertStatus(200);

        $this->assertSoftDeleted('authors', ['id' => $author->id]);

        $author = $author->refresh();
        $this->assertNotNull($author->deleted_at);
    }

    public function testDeleteAuthorErrorsOnNonExistingAuthor()
    {
        $response = $this->deleteJson(route('authors.destroy', 999));

        $response->assertStatus(500);
    }
}
