<?php

namespace App\Services\Book;

use App\Models\Table\BookTable;
use App\Services\AppService;
use App\Services\AppServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class BookService extends AppService implements AppServiceInterface
{
    public function __construct(BookTable $model)
    {
        parent::__construct($model);
    }

    public function dataTable($filter)
    {
        return BookTable::datatable($filter)->paginate($filter->entries ?? 15);
    }

    public function getById($id)
    {
        try {
            return BookTable::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Book not found');
        } catch (\Throwable $e) {
            throw new \Exception('An error occurred: ' . $e->getMessage());
        }
    }

    public function create($data)
    {
        DB::beginTransaction();
        try {
            $row = BookTable::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'publish_date' => $data['publish_date'],
                'author_id' => $data['author_id'],
            ]);
            DB::commit();
            return $row;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new \Exception('Failed to create book: ' . $e->getMessage());
        }
    }

    public function update($id, $data)
    {
        DB::beginTransaction();
        try {
            $row = BookTable::findOrFail($id);
            $row->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'publish_date' => $data['publish_date'],
                'author_id' => $data['author_id'],
            ]);
            DB::commit();
            return $row;
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            throw new \Exception('Book not found');
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new \Exception('Failed to update book: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $row = BookTable::findOrFail($id);
            $row->delete();
            DB::commit();
            return $row;
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            throw new \Exception('Book not found');
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new \Exception('Failed to delete book: ' . $e->getMessage());
        }
    }
}
