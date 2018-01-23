<?php 

class Model_Tienen extends Orm\Model
{
    protected static $_table_name = 'tiene';
    protected static $_primary_key = array('id_listas','id_cancion');
    protected static $_properties = array(
        
        'id_listas' => array
        (
            'data_type' => 'int'   
        ),
        'id_cancion' => array
        (
            'data_type' => 'int'   
        )
        );
}