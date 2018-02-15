<?php 

class Model_roles extends Orm\Model
{
    protected static $_table_name = 'roles';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'type' => array(
            'data_type' => 'varchar'   
        )
    );
    protected static $_has_many = array
    (
            'usuarios' => array(
                'key_from' => 'id',
                'model_to' => 'Model_users',
                'key_to' => 'id_rol',
                'cascade_save' => false,
                'cascade_delete' => false,
            )
    );
}