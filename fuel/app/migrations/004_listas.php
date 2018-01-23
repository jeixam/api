<?php
namespace Fuel\Migrations;

class Listas
{
    function up()
    {
        \DBUtil::create_table('listas', array
            (
                'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
                'titulo' => array('type' => 'varchar', 'constraint' => 100),
                'id_usuario' => array('type' => 'int', 'constraint' => 11),
                'editable' => array('type' => 'int', 'constraint' => 1),
            ), array('id'),true, 'InnoDB', 'utf8_general_ci',
        array
        (
        array(
                'constraint' => 'claveAjenaDelaListasAUsuarios',
                'key' => 'id_usuario',
                'reference' => array
                (
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
       \DBUtil::drop_table('listas');
    }
}