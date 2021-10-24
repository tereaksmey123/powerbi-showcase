<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PowerBiRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PowerBiCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PowerBiCrudController extends CrudController
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
    protected $score = [0 => 'Not yet achieved', 1 => 'Partially achieved', 2 => 'Fully achieved'];
    public function setup()
    {
        CRUD::setModel(\App\Models\PowerBi::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/power-bi');
        CRUD::setEntityNameStrings('power bi', 'power bis');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('scorecard_name')->type('text');
        CRUD::column('step')->type('number');
        CRUD::column('milestone')->type('text');
        CRUD::addColumn([
            'name'  => 'score',
            'label' => 'Score',
            'type'  => 'boolean',
            // optionally override the Yes/No texts
            'options' => $this->score
        ]); 
        CRUD::column('narrative')->type('text');
        CRUD::column('year')->type('number');
        
        
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
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
        CRUD::setValidation(PowerBiRequest::class);
        CRUD::field('scorecard_name')->type('text');
        CRUD::field('step')->type('number')->wrapper(['class' => 'form-group col-md-4']);
        CRUD::addField([   // select_from_array
            'name'        => 'score',
            'label'       => "Score",
            'type'        => 'select_from_array',
            'options'     => $this->score,
            'allows_null' => false,
            'wrapper'   => [ 
                'class'      => 'form-group col-md-4'
             ]
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]); 
        CRUD::field('year')->type('number')->wrapper(['class' => 'form-group col-md-4']);
        
        CRUD::field('milestone')->type('textarea');
        CRUD::field('narrative')->type('textarea');
        
       
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
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
