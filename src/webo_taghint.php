<?php

if(!defined('_PS_VERSION_')){
    exit;
}

class webo_taghint extends Module

{

    public string $logo_path;

    public function __construct()
    {
        $this->name = "webo_taghint";
        $this->tab = "others";
        $this->version = "1.0.0";
        $this->author = "webo";
        $this->need_instance = false;
        $this->bootstrap = true;
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.0',
            'max' => '1.0'
        ];

        $this->displayName = $this->trans('Webo tag hint');
        $this->description = $this->trans('Module add popular tag proposed by admin')
        parent::__construct();

        if(!$this->_path) {
            $this->_path = __PS_BASE_URI__ .'modules/' . $this->name . '/';
        }
        $this->logo_path = $this->_path.'logo.png';
    }

    public function install()
    {
        $sqlQueries = 'CREATE TABLE IF NOT EXISTS `'. _DB_PREFIX_ .'popular_tag` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `id_tag` int(10) unsigned NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=' . _MYSQL_ENGINE_ .'DEFAULT CHARSET=utf8';
            if(Db::getInstance()->execute($sqlQueries) == false)
                {
                    return false;
                }
        return true;
    }

    public function uninstall()
    {
        $query = 'DROP TABLE IF EXISTS `' ._DB_PREFIX_ .'popular_tag`';
        if (Db::getInstance()->execute($query) == false) {
            return false;
        }
    }
}