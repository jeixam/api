<?php 

class Model_Siguen extends Orm\Model
{
    protected static $_table_name = 'siguen';
    protected static $_primary_key = array('id_usuario','id_amigo');
    protected static $_properties = array(
        
        'id_usuario' => array
        (
            'data_type' => 'int'   
        ),
        'id_amigo' => array
        (
            'data_type' => 'int'   
        )
        );
}