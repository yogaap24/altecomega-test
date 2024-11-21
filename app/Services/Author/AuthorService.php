<?php

namespace App\Services\Author;

use App\Models\Table\AuthorTable;
use App\Services\AppService;
use App\Services\AppServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class AuthorService extends AppService implements AppServiceInterface
{
    public function __construct(AuthorTable $model)
    {
        parent::__construct($model);
    }

    public function dataTable($filter)
    {
        return AuthorTable::datatable($filter)->paginate($filter->entries ?? 15);
    }

    public function getById($id)
    {
        try {
            return AuthorTable::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Author not found');
        } catch (\Throwable $e) {
            throw new \Exception('An error occurred: ' . $e->getMessage());
        }
    }

    public function getBooks($id)
    {
        try {
            $author = AuthorTable::findOrFail($id);
            return $author->books->map(function ($book) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'description' => $book->description,
                    'publish_date' => $book->publish_date,
                ];
            });
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Author not found');
        } catch (\Throwable $e) {
            throw new \Exception('An error occurred: ' . $e->getMessage());
        }
    }

    public function create($data)
    {
        DB::beginTransaction();
        try {
            $row = AuthorTable::create([
                'name' => $data['name'],
                'bio' => $data['bio'],
                'birth_date' => $data['birth_date'],
            ]);
            DB::commit();
            return $row;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new \Exception('Failed to create author: ' . $e->getMessage());
        }
    }

    public function update($id, $data)
    {
        DB::beginTransaction();
        try {
            $row = AuthorTable::findOrFail($id);
            $row->update([
                'name' => $data['name'],
                'bio' => $data['bio'],
                'birth_date' => $data['birth_date'],
            ]);
            DB::commit();
            return $row;
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            throw new \Exception('Author not found');
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new \Exception('Failed to update author: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $row = AuthorTable::findOrFail($id);

            if ($row->books->count() > 0) {
                $row->books()->delete();
            }

            $row->delete();
            DB::commit();
            return $row;
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            throw new \Exception('Author not found');
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new \Exception('Failed to delete author: ' . $e->getMessage());
        }
    }
}