<?php
/**
 * User: floran
 * Date: 24/03/15
 * Time: 21:22
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @MongoDB\Document(collection="users")
 * @MongoDBUnique(fields="username", message="user.warn.email_unique")
 */
class User implements UserInterface
{
    /**
     * @var integer
     * @JMS\Type("integer")
     *
     * @MongoDB\Id
     */
    private $id;

    /**
     * @var string
     * @JMS\Type("string")
     *
     * @MongoDB\Field(type="string", name="email")
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     * @Assert\Length(
     *      min = "5",
     *      max = "30",
     *      minMessage = "user.warn.password_length",
     *      maxMessage = "user.warn.password_length",
     *      groups = {"Default"}
     * )
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "5",
     *      max = "30",
     *      minMessage = "user.warn.password_length",
     *      maxMessage = "user.warn.password_length",
     *      groups = {"Default"}
     * )
     * */
    private $plainPassword;


    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     * @Assert\Length(
     *      max = 25
     * )
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     * @Assert\Length(
     *      max = 25
     * )
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @var collection
     *
     * @MongoDB\ReferenceMany(
     *     targetDocument="Comment",
     *     mappedBy="user",
     *     cascade={"all"})
     */
    private $comments;

    /**
     * @var collection
     *
     * @MongoDB\ReferenceMany(
     *  name="favorite_wine_ids",
     *  targetDocument="Vintage",
     *  simple=true,
     *  strategy="set",
     *  sort={"Datetime": "desc"})
     */
    private $favoritesWines;

    /**
     * @var collection
     *
     * @MongoDB\Field(type="collection")
     * @Assert\NotBlank()
     */
    private $roles;

    /**
     * @var TasteProfile
     *
     * @MongoDB\EmbedOne(targetDocument="TasteProfile")
     */
    private $tasteProfile;

    public function __construct()
    {
        $this->roles[] = 'ROLE_USER';
        $this->comments = new ArrayCollection();
        $this->favoritesWines = new ArrayCollection();
    }

    /**
     * Set username
     *
     * @param string $username
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get username
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->getUsername();
    }

    /**
     * Set password
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }


    /**
     * Set firstname
     *
     * @param string $firstname
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string $firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string $lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    
    /**
     * Add comment
     *
     * @param \Wineot\DataBundle\Document\Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * Remove comment
     *
     * @param \Wineot\DataBundle\Document\Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection $comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Returns the roles granted to the user.
     *
     * @return String[] The user roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set roles
     *
     * @param $roles
     * @return self
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    public function addRole($role)
    {
        $this->roles[] = $role;
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $favoritesWines
     */
    public function setFavoritesWines($favoritesWines)
    {
        $this->favoritesWines = $favoritesWines;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavoritesWines()
    {
        return $this->favoritesWines;
    }

    /**
     * Add favorite wine
     *
     * @param \Wineot\DataBundle\Document\Vintage $vintage
     */
    public function addFavoriteWine(Vintage $vintage)
    {
        if (!$this->isFavorited($vintage))
            $this->favoritesWines->add($vintage);
    }

    /**
     * Remove favorite wine
     *
     * @param \Wineot\DataBundle\Document\Vintage $vintage
     */
    public function removeFavoriteWine(Vintage $vintage)
    {
        $this->favoritesWines->removeElement($vintage);
    }


    public function isFavorited(Vintage $vintage)
    {
        if ($this->favoritesWines->contains($vintage))
            return true;
        else
            return false;
    }

    /**
     * @return array
     */
    public static function getRolesType()
    {
        return array(
            'ROLE_WINERY_ADMIN' => 'global.word.winery_admin',
            'ROLE_ADMIN' => 'global.word.admin',
        );
    }

    /**
     * @return TasteProfile
     */
    public function getTasteProfile()
    {
        return $this->tasteProfile;
    }

    /**
     * @param TasteProfile $tasteProfile
     */
    public function setTasteProfile($tasteProfile)
    {
        $this->tasteProfile = $tasteProfile;
    }

    public function getTasteLevelForValue($value)
    {
        if ($this->tasteProfile != null) {
            if ($value == "sweet")
                return $this->tasteProfile->calculatePercentage($this->tasteProfile->getSweetLevel());
            elseif ($value == "fruits")
                return $this->tasteProfile->calculatePercentage($this->tasteProfile->getFruitsLevel());
            elseif ($value == "wooded")
                return $this->tasteProfile->calculatePercentage($this->tasteProfile->getWoodedLevel());
            elseif ($value == "strength")
                return $this->tasteProfile->calculatePercentage($this->tasteProfile->getStrengthLevel());
            elseif ($value == "tannins")
                return $this->tasteProfile->calculatePercentage($this->tasteProfile->getTanninsLevel());
            elseif ($value == "complex")
                return $this->tasteProfile->calculatePercentage($this->tasteProfile->getComplexLevel());
        }
        return null;
    }

    public function calculateTasteLevel($color)
    {
        $sweet = null;
        $fruits = null;
        $wooded = null;
        $strength = null;
        $tannins = null;
        $complex = null;
        $count=0;
        foreach($this->getFavoritesWines() as $favoriteVintage)
        {
            if ($favoriteVintage->getTasteProfile() && $favoriteVintage->getColor() == $color) {
                $sweet += $favoriteVintage->getTasteProfile()->getSweetLevel();
                $fruits += $favoriteVintage->getTasteProfile()->getFruitsLevel();
                $wooded += $favoriteVintage->getTasteProfile()->getWoodedLevel();
                $strength += $favoriteVintage->getTasteProfile()->getStrengthLevel();
                $tannins += $favoriteVintage->getTasteProfile()->getTanninsLevel();
                $complex += $favoriteVintage->getTasteProfile()->getComplexLevel();
                $count++;
            }
        }
        $profile = new TasteProfile();
        if ($count > 0)
        {
            $sweet = $sweet/$count;
            $fruits = $fruits/$count;
            $wooded = $wooded/$count;
            $strength = $strength/$count;
            $tannins = $tannins/$count;
            $complex = $complex/$count;
            $profile->setSweetLevel($sweet);
            $profile->setFruitsLevel($fruits);
            $profile->setWoodedLevel($wooded);
            $profile->setStrengthLevel($strength);
            $profile->setTanninsLevel($tannins);
            $profile->setComplexLevel($complex);
        }
        $this->setTasteProfile($profile);

    }

    /**
     * Get data for serialization of current object
     *
     * @return array
     */
    public function getDataArray()
    {
        $data = array();
        $data['id'] = $this->getId();
        $data['username'] = $this->getUsername();
        $data['mail'] = $this->getEmail();

        return $data;
    }

    /**
     * @JMS\HandlerCallback("json", direction = "serialization")
     * @param JsonSerializationVisitor $visitor
     */
    public function serializeToJson(JsonSerializationVisitor $visitor)
    {
        $visitor->setRoot($this->getDataArray());
    }
}
