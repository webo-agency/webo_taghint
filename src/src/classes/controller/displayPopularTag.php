<?php

namespace Prestashop\Module\WeboTaghint\Classes\Controller;

use Db;

class displayPopularTag
{
    public function getAllPopularTag() : array
    {
        $result = [];
        $sql = Db::getInstance()->executeS('SELECT * FROM `'. _DB_PREFIX_ .'popular_tag` pt LEFT JOIN `'. _DB_PREFIX_ .'tag` ta ON (pt.id_tag = ta.id_tag) ORDER BY  pt.id DESC');
        foreach ($sql as $key => $value)
        {
            $result[] = $value['name'];
        }
        return $result;
    }
}