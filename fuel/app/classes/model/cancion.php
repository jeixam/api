<?php 

class Model_cancion extends Orm\Model
{
    protected static $_table_name = 'cancion';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id'=> array
        (
            'data_type' => 'int'
        ),
        'nombre' => array
        (
            'data_type' => 'varchar'   
        ),
        'artista' => array
        (
            'data_type' => 'varchar'
    	),
        'url' => array
        (
            'data_type' => 'varchar'

        ),
        'reproducciones' => array
        (
            'data_type' => 'int'
        )
        
        );
    
    protected static $_many_many = array(
    'listas' => array
    (
        'key_from' => 'id',
        'key_through_from' => 'id_lista', 
        'table_through' => 'tiene', 
        'key_through_to' => 'id_cancion', 
        'model_to' => 'Model_listas',
        'key_to' => 'id',
        'cascade_save' => false,
        'cascade_delete' => false,
    )
);
}