<?php
namespace Fuel\Migrations;

class Cancion
{

    function up()
    {
        \DBUtil::create_table('cancion', array
            (
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'nombre' => array('type' => 'varchar', 'constraint' => 100),
            'artista' => array('type' => 'varchar', 'constraint' => 100),
            'url' => array('type' => 'varchar', 'constraint' => 100),
            'reproducciones' => array('type' => 'int', 'constraint' => 11)
            ), array('id'));

        \DBUtil::create_index('cancion', array('url'), 'INDEX','UNIQUE');
    }

    function down()
    {
       \DBUtil::drop_table('cancion');
    }
}