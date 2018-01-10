<?php 

class Model_Users extends Orm\Model
{
    protected static $_table_name = 'usuarios';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'nombre' => array
        (
            'data_type' => 'varchar'   
        ),
        'password' => array
        (
            'data_type' => 'varchar'
    	)
        );
    protected static $_has_many = array(
    'listas' => array(
        'key_from' => 'id',
        'model_to' => 'Model_listas',
        'key_to' => 'id_usuario',
        'cascade_save' => false,
        'cascade_delete' => false,
    )
);
}