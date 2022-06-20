<?php

if(!defined('_PS_VERSION_')){
    exit;
}

$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

use Prestashop\Module\WeboTaghint\Classes\Controller\displayPopularTag;
use PrestaShop\Module\DemoDoctrine\Database\QuoteInstaller;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;


class webo_TagHint extends Module implements WidgetInterface
{

    public function __construct()
    {
        $this->name = "webo_taghint";
        $this->tab = "others";
        $this->tabs = [['tab' => 'AdminWeboTagHint', 'class_name' => 'AdminWeboTagHint', 'name' => 'Tag Hint', 'visible' => true],];
        $this->version = "1.0.0";
        $this->author = "Webo.Agency";
        $this->bootstrap = true;
        $this->need_instance = 0;
        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];
        $this->displayName = $this->trans('Webo tag hint', array(), 'Modules.webo_TagHint');
        $this->description = $this->trans('Module add popular tag proposed by admin under search', array(), 'Modules.webo_TagHint');
        parent::__construct();
        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', array(), 'Modules.webo_TagHint');
    }

    public function install() : bool
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
        $tab = new Tab();
        $tab->class_name = 'AdminWeboTagHint';
        $tab->module = 'webo_taghint';
        $tab->icon = 'label_important';
        $tab->id_parent = (int) Tab::getIdFromClassName('AdminCatalog');
        foreach (Language::getLanguages(false) as $lang) {
            $tab->name[(int) $lang['id_lang']] = 'Tag Hint';
        }
        $tab->active = 1;
        if(!$tab->save()) {
            return false;
        }
        if(parent::install()) {
            return true;
        }
        return false;
    }

    public function uninstall() : bool
    {
        if (Db::getInstance()->execute('DROP TABLE IF EXISTS `' ._DB_PREFIX_ .'popular_tag`') == false) {
            return false;
        }
        $id_tab = (int)Tab::getIdFromClassName('AdminWeboTagHint');
        $tab = new Tab($id_tab);
        if (Validate::isLoadedObject($tab)) {
            if (!$tab->delete()) {
                return false;
            }
        } else {
            return false;
        }
        if (parent::uninstall()) {
            return true;
        }
        $this->_errors[] = $this->trans('There was an error during the uninstallation. Please see documentation <a href="https://github.com/webo-agency/webo_taghint">here</a>');
        return false;
    }

    public function renderWidget($hookName, array $configuration)
    {
        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        return $this->fetch('module:'.$this->name.'/views/templates/hook/displayPopularTag.tpl');
    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        return [
            'displayedTag' => displayPopularTag::getAllPopularTag()
        ];
    }

//    public function displayForm()
//    {
//        $form = [
//          'form' => [
//              'legend' => [
//                  'title' => $this->l('Settings'),
//              ],
//          ]
//        ];
//        $help_me = new HelperForm();
//        $help_me->table = $this->table;
//        $help_me->name_controller = $this->name;
//        $help_me->token = Tools::getAdminTokenLite('AdminModules');
//        $help_me-> currentIndex = AdminController::$currentIndex . '&' . http_build_query(['configure' => $this->name]);
//        $help_me->submit_action = 'submit' . $this->name;
//    }
}