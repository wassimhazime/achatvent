<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Conevert;

use Kernel\AWA_Interface\SQL_HTMLInterface;
use Phinx\Db\Table\Column;
use Phinx\Migration\AbstractMigration;

/**
 * Conevert  HTML Phinx
 *
 * @author wassime
 */
class HTML_Phinx extends AbstractMigration implements SQL_HTMLInterface {

    public static function tel(string $name = "TEL"): Column {
        $column = new Column();
        $column->setName($name);
        $column->setType(self::HTML_SQL["tel"]["typePhinix"]);
        $column->setOptions(self::HTML_SQL["tel"]["options"]);
        return $column;
    }

    public static function email(string $name = "email"): Column {
        $column = new Column();
        $column->setName($name);
        $column->setType(self::HTML_SQL["email"]["typePhinix"]);
        $column->setOptions(self::HTML_SQL["email"]["options"]);
        return $column;
    }

    public static function text_master(string $name): Column {
        $column = new Column();
        $column->setName($name);
        $column->setType(self::HTML_SQL["text_master"]["typePhinix"]);
        $column->setOptions(self::HTML_SQL["text_master"]["options"]);
        return $column;
    }

    public static function text(string $name): Column {
        $column = new Column();
        $column->setName($name);
        $column->setType(self::HTML_SQL["text"]["typePhinix"]);
        $column->setOptions(self::HTML_SQL["text"]["options"]);
        return $column;
    }

    public static function file(string $name = "fichiers"): Column {
        $column = new Column();
        $column->setName($name);
        $column->setType(self::HTML_SQL["file"]["typePhinix"]);
        $column->setOptions(self::HTML_SQL["file"]["options"]);
        return $column;
    }

    public static function textarea(string $name): Column {
        $column = new Column();
        $column->setName($name);
        $column->setType(self::HTML_SQL["textarea"]["typePhinix"]);
        $column->setOptions(self::HTML_SQL["textarea"]["options"]);
        return $column;
    }

    public static function date(string $name = "date"): Column {
        $column = new Column();
        $column->setName($name);
        $column->setType(self::HTML_SQL["date"]["typePhinix"]);
        $column->setOptions(self::HTML_SQL["date"]["options"]);
        return $column;
    }

    public static function checkBox(string $name): Column {
        $column = new Column();
        $column->setName($name);
        $column->setType(self::HTML_SQL["checkBox"]["typePhinix"]);
        $column->setOptions(self::HTML_SQL["checkBox"]["options"]);
        return $column;
    }

    public static function number(string $name): Column {
        $column = new Column();
        $column->setName($name);
        $column->setType(self::HTML_SQL["number"]["typePhinix"]);
        $column->setOptions(self::HTML_SQL["number"]["options"]);
        return $column;
    }

    public static function select(string $name): Column {
        $column = new Column();
        $column->setName($name);
        $column->setType(self::HTML_SQL["select"]["typePhinix"]);
        $column->setOptions(self::HTML_SQL["select"]["options"]);
        return $column;
    }

    public static function id(string $name = "id"): Column {
        $column = new Column();
        $column->setName($name);
        $column->setType(self::HTML_SQL["id"]["typePhinix"]);
        $column->setOptions(self::HTML_SQL["id"]["options"]);
        return $column;
    }

    public static function datetime(string $name): Column {
        $column = new Column();
        $column->setName($name);
        $column->setType(self::HTML_SQL["add_update"]["typePhinix"]);
        $column->setOptions(self::HTML_SQL["add_update"]["options"]);
        return $column;
    }

    public static function id_default(): array {

        return ['id' => false, 'primary_key' => ['id']];
    }

}
