<?php

namespace PrestaShop\Module\webo_taghint\Entity;

use Doctrine\ORM\Mapping\Id;

class PopularTag
{
    /**
     * @var Id
     * @ORM\Id
     * @ORM\Column (name="id_popular_tag", type="integer")
     * @ORM\GeneratedValue (strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column (name="id_tag", type="integer")
     */
    private $tagId;

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTagId(): int
    {
        return $this->tagId;
    }

    /**
     * @param Id $id
     */
    public function setId(Id $id) : string
    {
        $this->id = $id;

        return $this;
    }

}