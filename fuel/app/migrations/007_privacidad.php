<?php
namespace Fuel\Migrations;

class Privacidad
{

    function up()
    {
        \DBUtil::create_table('privacidad', array
            (
                'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
                'notificaciones' => array('type' => 'int', 'constraint' => 11),
                'listas' => array('type' => 'int', 'constraint' => 11),
                'amigos' => array('type' => 'int', 'constraint' => 11),
                'perfil' => array('type' => 'varchar', 'constraint' => 100),
                'id_usuario' => array('type' => 'int', 'constraint' => 11),
            ), array('id'),true, 'InnoDB', 'utf8_general_ci',
        array
        (
        array(
                'constraint' => 'claveAjenaDePrivacidadAUsuarios',
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
       \DBUtil::drop_table('privacidad');
    }
}