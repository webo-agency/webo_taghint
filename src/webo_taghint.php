<?php

if(!defined('_PS_VERSION_')){
    exit;
}

use Doctrine\ORM\EntityManager;
use PrestaShop\Module\DemoDoctrine\Database\QuoteInstaller;

class Webo_TagHint extends Module
{
    /** @var string  */
    public $logo_path;

    public function __construct()
    {
        $this->name = "webo_taghint";
        $this->tab = "others";
        $this->version = "1.0.0";
        $this->author = "webo";
        $this->need_instance = false;
        $this->bootstrap = true;
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array(
          'min' => '1.7.2.0', 
          'max' => _PS_VERSION_
        );
        $this->displayName = $this->trans('Webo tag hint');
        $this->description = $this->trans('Module add popular tag proposed by admin under search');
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
            `id_tag` BIGINT(20) UNSIGNED NOT NULL,
            PRIMARY KEY (`id`),
            INDEX `popular_tag_id_tag_foreign` (`id_tag` ASC),
            CONSTRAINT `popular_tag_id_tag_foreign`
                FOREIGN KEY (`id_tag`)
                REFERENCES `'. _DB_PREFIX_ .'tag` (`id`)
                ON DELETE CASCADE
            ) ENGINE=' . _MYSQL_ENGINE_ .' DEFAULT CHARSET=utf8';
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
        $this->_errors[] = $this->trans('There was an error during the uninstallation. Please see documentation <a href="https://github.com/webo-agency/webo_taghint">here</a>');
    }
}
