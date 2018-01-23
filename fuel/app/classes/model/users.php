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
    	),
        'email' => array
        (
            'data_type' => 'varchar'
        ),
        'id_divice' => array
        (
            'data_type' => 'varchar'
        ),
        'image' => array
        (
            'data_type' => 'varchar'
        ),
        'descripcion' => array
        (
            'data_type' => 'varchar'
        ),
        'cumplaños' => array
        (
            'data_type' => 'varchar'
        ),
        'ciudad' => array
        (
            'data_type' => 'varchar'
        ),
        'x' => array
        (
            'data_type' => 'int'
        ),
        'y' => array
        (
            'data_type' => 'int'
        ),
        'id_rol' => array
        (
            'data_type' => 'int'
        )
        );
    protected static $_has_many = array
    (
    'listas' => array(
        'key_from' => 'id',
        'model_to' => 'Model_listas',
        'key_to' => 'id_usuario',
        'cascade_save' => false,
        'cascade_delete' => false,
    )
);

    protected static $_belongs_to = array
    (
    'usuarios' => array(
        'key_from' => 'id_rol',
        'model_to' => 'Model_rol',
        'key_to' => 'id',
        'cascade_save' => false,
        'cascade_delete' => false,
    )
);
    protected static $_has_many = array
    (
    'noticias' => array(
        'key_from' => 'id',
        'model_to' => 'Model_noticias',
        'key_to' => 'id_usuario',
        'cascade_save' => false,
        'cascade_delete' => false,
    )
);
    protected static $_has_many = array
    (
    'privacidad' => array(
        'key_from' => 'id',
        'model_to' => 'Model_privacidad',
        'key_to' => 'id_usuario',
        'cascade_save' => false,
        'cascade_delete' => false,
    )
);

    protected static $_many_many = array(
    'amigo' => array(
        'key_from' => 'id',
        'key_through_from' => 'id_amigo', 
        'table_through' => 'siguen', 
        'key_through_to' => 'id_usuario',  
        'model_to' => 'Model_Users',
        'key_to' => 'id',
        'cascade_save' => false,
        'cascade_delete' => false,
    ),
    'amigo' => array(
        'key_from' => 'id',
        'key_through_from' => 'id_usuario', 
        'table_through' => 'siguen', 
        'key_through_to' => 'id_usuario',  
        'model_to' => 'Model_Users',
        'key_to' => 'id',
        'cascade_save' => false,
        'cascade_delete' => false,
}