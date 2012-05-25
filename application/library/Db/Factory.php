<?php
namespace Db;


if( !defined('YAF') )
    exit(-1);

/**
 * Db工厂数据类
 *
 * @author  zxcvdavid@gmail.com
 * @example
 *              case 'ORACLE':
 *                  return new Db_Oracle($dbhost, $username, $password, $dbname, $dbcharset);
 *
 */


class Factory {

    private static $_db;

    private $_db_type;
    private $_db_host;
    private $_db_usr;
    private $_db_pwd;
    private $_db_name;
    private $_db_charset = 'UTF8';

    function __construct($which = 'master') {

        $db_config = \Yaf\Registry::get('config')->db->$which;

        $this->_db_type = $db_config->type;
        $this->_db_host = $db_config->host;
        $this->_db_name = $db_config->dbname;
        $this->_db_charset = $db_config->charset;
        $this->_db_usr = $db_config->usr;
        $this->_db_pwd = $db_config->pwd;
    }

    static public function create($which = 'master') {

        if( !isset(self::$_db[$which]) )
            self::$_db[$which] = new self ($which);

        switch ( strtoupper( self::$_db[$which]->_db_type ) ) {
            case 'MYSQL':
                return  Mysql::getInstance( self::$_db[$which]->_db_host,
                                                        self::$_db[$which]->_db_usr,
                                                        self::$_db[$which]->_db_pwd,
                                                        self::$_db[$which]->_db_name,
                                                        self::$_db[$which]->_db_charset);

        }

        return false;
    }

}