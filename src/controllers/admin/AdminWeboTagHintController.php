<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class AdminWeboTagHintController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->id_lang = $this->context->language->id;
        $this->default_form_language = $this->context->language->id;
        $this->_defaultOrderBy = 'a.id';
        $this->table = 'popular_tag';
        $this->_select = 't.name as `name`';
        $this->addRowAction('delete');
        $this->_join = 'LEFT JOIN `'._DB_PREFIX_.'tag` t ON t.id_tag = a.id_tag';
        $this->fields_list = [
            'id' => ['title' => 'ID', 'class' => 'fixed-width-xs'],
            'name' => ['title' => 'NAME']
        ];
//        Tools::redirectAdmin(Context::getContext()->link->getAdminLink('AdminModules').'&configure=webo_taghint');
    }

//    protected function getFromClause() {
//        return str_replace(_DB_PREFIX_, '', parent::getFromClause());
//    }
}