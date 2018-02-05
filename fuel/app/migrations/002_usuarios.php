<?php
namespace Fuel\Migrations;

class Usuarios
{
    function up()
    {
        \DBUtil::create_table('usuarios', array
            (
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'nombre' => array('type' => 'varchar', 'constraint' => 100),
            'password' => array('type' => 'varchar', 'constraint' => 100),
            'email' => array('type' => 'varchar', 'constraint' => 100),
            'id_divice' => array('type' => 'varchar', 'constraint' => 100),
            'image' => array('type' => 'varchar', 'constraint' => 500),
            'descripcion' => array('type' => 'varchar', 'constraint' => 100, null=>true),
            'birtdate' => array('type' => 'varchar', 'constraint' => 100),
            'x' => array('type' => 'int', 'constraint' => 11),
            'y' => array('type' => 'int', 'constraint' => 11),
            'ciudad' => array('type' => 'varchar', 'constraint' => 100),
            'id_rol' => array('type' => 'int', 'constraint' => 11),
            ), array('id'),true, 'InnoDB', 'utf8_general_ci',
        array
        (
        array(
                'constraint' => 'claveAjenaDeUsuariosaRoles',
                'key' => 'id_rol',
                'reference' => array
                (
                    'table' => 'roles',
                    'column' => 'id',
                ),
                'on_update' => 'CASCADE',
                'on_delete' => 'CASCADE'
            )
        )
        );
        \DBUtil::create_index('usuarios', array('nombre','email'), 'INDEX','UNIQUE');
    }

    function down()
    {
       \DBUtil::drop_table('usuarios');
    }
}