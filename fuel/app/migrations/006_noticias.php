<?php
namespace Fuel\Migrations;

class Noticias
{

    function up()
    {
        \DBUtil::create_table('noticias', array
            (
                'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
                'titulo' => array('type' => 'varchar', 'constraint' => 100),
                'id_usuario' => array('type' => 'int', 'constraint' => 11),
                'descripcion' => array('type' => 'varchar', 'constraint' => 100),
            ), array('id'),true, 'InnoDB', 'utf8_general_ci',
        array
        (
        array(
                'constraint' => 'claveAjenaDelaNoticiasAUsuarios',
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
       \DBUtil::drop_table('noticias');
    }
}