<?php  
namespace Fuel\Migrations;

class Siguen
{
    function up()
    {
        \DBUtil::create_table('siguen', array(
            'id_usuario' => array('type' => 'int', 'constraint' => 11),
            'id_amigo' => array('type' => 'int', 'constraint' => 11)
        ), array('id_lista', 'id_cancion'), true, 'InnoDB', 'utf8_general_ci',
            array(
                array(
                    'constraint' => 'foreignkeyHaveToLists',
                    'key' => 'id_usuario',
                    'reference' => array(
                        'table' => 'usuarios',
                        'column' => 'id',
                    ),
                    'on_update' => 'CASCADE',
                    'on_delete' => 'CASCADE'
                ),
                array(
                    'constraint' => 'foreignkeyHaveToSongs',
                    'key' => 'id_amigo',
                    'reference' => array(
                        'table' => 'usuarios',
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
       \DBUtil::drop_table('siguen');
        
    }
}
?>