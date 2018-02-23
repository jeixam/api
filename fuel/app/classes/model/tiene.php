<?php 

class Model_Tiene extends Orm\Model
{
    protected static $_table_name = 'tiene';
    protected static $_primary_key = array('id_lista','id_cancion');
    protected static $_properties = array(
        
        'id_lista' => array
        (
            'data_type' => 'int'   
        ),
        'id_cancion' => array
        (
            'data_type' => 'int'   
        )
        );
}