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
        $this->OrderBy = 'a.id';
        $this->table = 'popular_tag';
        $this->_select = 't.name as `name`, a.id as `id_configuration`';
        $this->addRowAction('delete');
        $this->_join = 'LEFT JOIN `'._DB_PREFIX_.'tag` t ON t.id_tag = a.id_tag';
        $this->fields_list = [
            'id' => ['title' => 'ID', 'class' => 'fixed-width-xs'],
            'name' => ['title' => 'NAME', 'required'=> true, 'type'=> 'textarea', 'align' => 'center'],
        ];
    }

    public function initPageHeaderToolbar()
    {
        if(empty($this->display))
        {
            $this->page_header_toolbar_btn['new_tag'] = [
                'href' => self::$currentIndex . '&addpopular_tag&token=' . $this->token,
                'desc' => $this->trans('Add new popular tag', [], 'Admin.WeboTagHint.Feature'),
                'icon' => 'process-icon-new',
            ];
        }
        parent::initPageHeaderToolbar();
    }

    public function renderForm()
    {
        /** @var Tag $obj */
        if (!($obj = $this->loadObject(true))) {
            return;
        }
        $tag = Db::getInstance()->executeS('SELECT * FROM `'. _DB_PREFIX_ .'tag` ORDER BY name ASC');
        $this->fields_form = [
            'legend' => [
                'title' => $this->trans('Tag', [], 'Admin.Shopparameters.Feature'),
                'icon' => 'icon-list-ul'
            ],
            'input' => [
                ['name'=>'name','type'=>'select','label'=>'Select Tag:','required'=>true, 'options'=>['query'=> $tag, 'id'=> 'id_tag', 'name'=> 'name']],
            ],
            'submit' => [
                'title' => $this->trans('Save', [], 'Admin.Actions'),
            ]
        ];
        return parent::renderForm();
    }

    public function postProcess()
    {
        if(Tools::isSubmit('submitAdd'. $this->table))
        {
            return $this->weboCreatePopularTag(Tools::getValue('name'));
        }else {
            if(Tools::isSubmit('delete'.$this->table)) {
                if(Tools::getValue('id_configuration'))
                {
                    return $this->weboDeletePopularTag(Tools::getValue('id_configuration'));
                }
            }
        }
        return parent::postProcess();
    }

    public function weboCreatePopularTag($id_tag)
    {
        if(Db::getInstance()->execute('INSERT INTO `'. _DB_PREFIX_ .'popular_tag` (`id_tag`) VALUES ("'. $id_tag .'")') !== false) {
            $this->confirmations[] = "You Add Popular Tag";
        }else {
            $this->errors[] = Tools::displayError("Something was problem with add Popular Tag");
        }
    }

    public function weboDeletePopularTag($id_tag)
    {
        if(Db::getInstance()->execute('DELETE FROM `'. _DB_PREFIX_ .'popular_tag` WHERE id="'. $id_tag .'"') !== false) {
            $this->confirmations[] = "You Delete Popular Tag";
        }else {
            $this->errors[] = Tools::displayError("Something was problem with delete Popular Tag");
        }
    }

}