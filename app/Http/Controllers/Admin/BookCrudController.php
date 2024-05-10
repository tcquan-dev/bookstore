<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BookRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BookCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BookCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Book::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/book');
        CRUD::setEntityNameStrings('book', 'books');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.
        CRUD::column('author_id')->type('select')->model('App\Models\Author')->attribute('name')->entity('author')->after('description');
        CRUD::column('category_id')->type('select')->model('App\Models\Category')->attribute('name')->entity('category')->after('description');
        CRUD::column('sale_id')->type('select')->model('App\Models\Author')->attribute('name')->entity('sale')->after('description');
        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(BookRequest::class);
        CRUD::setFromDb(); // set fields from db columns.
        CRUD::field([
            'type'      => 'select',
            'name'      => 'author_id',
            'entity'    => 'author',
            'model'     => 'App\Models\Author',
            'attribute' => 'name',
            'pivot'     => true,
        ])->after('description');
        CRUD::field([
            'type'      => 'select',
            'name'      => 'category_id',
            'entity'    => 'category',
            'model'     => 'App\Models\Category',
            'attribute' => 'name',
            'pivot'     => true,
        ])->after('author_id');
        CRUD::field([
            'type'      => 'select',
            'name'      => 'sale_id',
            'entity'    => 'sale',
            'model'     => 'App\Models\Sale',
            'attribute' => 'name',
            'pivot'     => true,
        ])->after('category_id');

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
