<?php

namespace Tests\Feature;

use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Table\AuthorTable;
use App\Models\Table\BookTable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsBooks()
    {
        $author = AuthorTable::factory()->create();

        BookTable::factory()->count(5)->create([
            'author_id' => $author->id,
        ]);

        $response = $this->getJson(route('books.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [['id', 'title', 'description', 'publish_date', 'author_book']],
            ]);
    }

    public function testValidatesStoreCorrectData()
    {
        $author = AuthorTable::factory()->create();

        $data = [
            'title' => 'Test Book',
            'description' => 'This is a test book description.',
            'publish_date' => '2024-01-01',
            'author_id' => $author->id,
        ];

        $request = new StoreBookRequest();

        $validator = Validator::make($data, $request->rules());
        $this->assertTrue($validator->passes());
    }

    public function testFailsStoreOnMissingTitle()
    {
        $author = AuthorTable::factory()->create();

        $data = [
            'description' => 'This is a test book description.',
            'publish_date' => '2024-01-01',
            'author_id' => $author->id,
        ];

        $request = new StoreBookRequest();

        $validator = Validator::make($data, $request->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('title', $validator->errors()->messages());
    }

    public function testFailsStoreOnInvalidPublishDate()
    {
        $author = AuthorTable::factory()->create();

        $data = [
            'title' => 'Test Book',
            'description' => 'This is a test book description.',
            'publish_date' => 'invalid-date',
            'author_id' => $author->id,
        ];

        $request = new StoreBookRequest();

        $validator = Validator::make($data, $request->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('publish_date', $validator->errors()->messages());
    }

    public function testStoreCreatesBook()
    {
        $author = AuthorTable::factory()->create();

        $data = [
            'title' => 'Test Book',
            'description' => 'This is a test book description.',
            'publish_date' => '2024-01-01',
            'author_id' => $author->id,
        ];

        $response = $this->postJson(route('books.store'), $data);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', $data['title']);

        $this->assertDatabaseHas('books', $data);
    }

    public function testShowReturnsBook()
    {
        $author = AuthorTable::factory()->create();
        $book = BookTable::factory()->create([
            'author_id' => $author->id,
        ]);

        $response = $this->getJson(route('books.show', $book->id));

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $book->id);
    }

    public function testValidatesUpdateCorrectData()
    {
        $author = AuthorTable::factory()->create();

        $data = [
            'title' => 'Updated Book',
            'description' => 'Updated description.',
            'publish_date' => '2024-02-01',
            'author_id' => $author->id,
        ];

        $request = new UpdateBookRequest();

        $validator = Validator::make($data, $request->rules());
        $this->assertTrue($validator->passes());
    }

    public function testFailsUpdateOnInvalidTitle()
    {
        $author = AuthorTable::factory()->create();
        BookTable::factory()->create([
            'author_id' => $author->id,
        ]);

        $data = [
            'title' => str_repeat('A', 256),
        ];

        $request = new UpdateBookRequest();

        $validator = Validator::make($data, $request->rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('title', $validator->errors()->messages());
    }

    public function testUpdateBook()
    {
        $author = AuthorTable::factory()->create();
        $book = BookTable::factory()->create([
            'author_id' => $author->id,
        ]);

        $data = [
            'title' => 'Updated Book Title',
            'description' => 'Updated Book Description',
            'publish_date' => '2024-03-01',
            'author_id' => $author->id,
        ];

        $response = $this->putJson(route('books.update', $book->id), $data);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', $data['title']);

        $this->assertDatabaseHas('books', $data);
    }

    public function testDeleteBook()
    {
        $author = AuthorTable::factory()->create();
        $book = BookTable::factory()->create([
            'author_id' => $author->id,
        ]);

        $response = $this->deleteJson(route('books.destroy', $book->id));

        $response->assertStatus(200);

        $this->assertSoftDeleted('books', ['id' => $book->id]);

        $book = $book->refresh();
        $this->assertNotNull($book->deleted_at);
    }

    public function testDeleteBookNonExisting()
    {
        $response = $this->deleteJson(route('books.destroy', 999));

        $response->assertStatus(500);
    }
}
