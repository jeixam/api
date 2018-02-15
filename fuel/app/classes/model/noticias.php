<?php 

class Model_Noticias extends Orm\Model
{
    protected static $_table_name = 'noticias';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id'=> array
        (
            'data_type' => 'int'
        ),
        'titulo' => array
        (
            'data_type' => 'varchar'   
        ),
        'descripcion' => array
        (
            'data_type' => 'varchar'   
        ),
        'id_usuario' => array
        (
            'data_type' => 'int'   
        )
        );

protected static $_belongs_to = array(
    'usuarios' => array(
        'key_from' => 'id_usuario',
        'model_to' => 'Model_users',
        'key_to' => 'id',
        'cascade_save' => false,
        'cascade_delete' => false,
    )
);
    
}