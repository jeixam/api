<?php  
namespace Fuel\Migrations;

class Tiene
{
    function up()
    {
        \DBUtil::create_table('tiene', array(
            'id_lista' => array('type' => 'int', 'constraint' => 11),
            'id_cancion' => array('type' => 'int', 'constraint' => 11)
        ), array('id_lista', 'id_cancion'), true, 'InnoDB', 'utf8_general_ci',
            array(
                array(
                    'constraint' => 'foreignkeyHaveToLists',
                    'key' => 'id_lista',
                    'reference' => array(
                        'table' => 'listas',
                        'column' => 'id',
                    ),
                    'on_update' => 'CASCADE',
                    'on_delete' => 'CASCADE'
                ),
                array(
                    'constraint' => 'foreignkeyHaveToSongs',
                    'key' => 'id_cancion',
                    'reference' => array(
                        'table' => 'cancion',
                        'column' => 'id',
                    ),
                    'on_update' => 'CASCADE',
                    'on_delete' => 'CASCADE'
                )
            )
        );
    }
    function down()
    {
       \DBUtil::drop_table('tiene');
        
    }
}
?>