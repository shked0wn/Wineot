<?php
/**
 * User: floran
 * Date: 12/09/15
 * Time: 17:40
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Wineot\DataBundle\Document\Comment;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;

/**
 * @MongoDB\Document(collection="wines_grappes")
 * @MongoDBUnique(fields={"wine", "grappe"}, message="wine.warn.unique_grappe")
 */
class WineGrappe {
    /**
     * @var integer
     *
     * @MongoDB\Id
     */
    private $id;

    /**
     * @var Wine
     *
     * @MongoDB\ReferenceOne(
     *  targetDocument="Wine",
     *  simple=true)
     */
    private $wine;

    /**
     * @var Grappe
     *
     * @MongoDB\ReferenceOne(
     *  targetDocument="Grappe",
     *  simple=true)
     */
    private $grappe;

    /**
     * @param \Wineot\DataBundle\Document\Grappe $grappe
     */
    public function setGrappe($grappe)
    {
        $this->grappe = $grappe;
    }

    /**
     * @return \Wineot\DataBundle\Document\Grappe
     */
    public function getGrappe()
    {
        return $this->grappe;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Wineot\DataBundle\Document\Wine $wine
     */
    public function setWine($wine)
    {
        $this->wine = $wine;
    }

    /**
     * @return \Wineot\DataBundle\Document\Wine
     */
    public function getWine()
    {
        return $this->wine;
    }


} 