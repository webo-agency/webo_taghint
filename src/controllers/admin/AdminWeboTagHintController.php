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
        $this->addRowAction('edit');

//        Tools::redirectAdmin(Context::getContext()->link->getAdminLink('AdminModules').'&configure=webo_taghint');
    }

    protected function getFromClause() {
        return str_replace(_DB_PREFIX_, '', parent::getFromClause());
    }
}