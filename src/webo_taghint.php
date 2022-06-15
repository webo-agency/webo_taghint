<?php

if(!defined('_PS_VERSION_')){
    exit;
}

use Doctrine\ORM\EntityManager;
use PrestaShop\Module\DemoDoctrine\Database\QuoteInstaller;

class webo_TagHint extends Module

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
        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];
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
        if(Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'. _DB_PREFIX_ .'popular_tag` (
            `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `id_tag` int(10) UNSIGNED NOT NULL,
            PRIMARY KEY (`id`),
            INDEX `popular_tag_id_tag_foreign` (`id_tag` ASC),
            CONSTRAINT `popular_tag_id_tag_foreign`
                FOREIGN KEY (`id_tag`)
                REFERENCES `'. _DB_PREFIX_ .'tag` (`id_tag`)
                ON DELETE CASCADE
        ) ENGINE='._MYSQL_ENGINE_ .' DEFAULT CHARSET=UTF8') == false)
        {
            return false;
        }
        if(parent::install() && $this->registerHook('DisplayTagHint')) {
            return true;
        }
    }

    public function uninstall()
    {
        if (Db::getInstance()->execute('DROP TABLE IF EXISTS `' ._DB_PREFIX_ .'popular_tag`') == false) {
            return false;
        }
        if (parent::uninstall()) {
            return true;
        }
        $this->_errors[] = $this->trans('There was an error during the uninstallation. Please see documentation <a href="https://github.com/webo-agency/webo_taghint">here</a>');
        return false;
    }

    public function hookDisplayTagHint()
    {
        $this->context->smarty->assign([
            'tag_hint_show' => displayPopularTag::getAllPopularTag()
        ]);
        return $this->display(__FILE__, 'views/templates/hook/displayPopularTag.tpl');
    }
}