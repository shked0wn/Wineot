<?php
/**
 * User: floran
 * Date: 18/12/2015
 * Time: 13:18
 */

namespace Wineot\DataBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\EmbeddedDocument
 */
class Owning
{
    /**
     * @var User
     *
     * @MongoDB\Field(name="user_id")
     * @MongoDB\ReferenceOne(
     *  targetDocument="User",
     *  simple=true,
     *  cascade={"persist"})
     */
    private $user;

    /**
     * @var boolean
     *
     * @MongoDB\Field(type="boolean", name="is_verified")
     */
    private $isVerified = false;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return boolean
     */
    public function isIsVerified()
    {
        return $this->isVerified;
    }

    /**
     * @param boolean $isVerified
     */
    public function setIsVerified($isVerified)
    {
        $this->isVerified = $isVerified;
    }
}