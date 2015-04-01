<?php
/**
 * User: floran
 * Date: 24/03/15
 * Time: 21:22
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @MongoDB\Document(collection="users")
 * @MongoDBUnique(fields="mail", message="user.warn.unique_email")
 */
class User implements UserInterface
{
    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     * @Assert\Length(
     *      max = 25
     * )
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
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $mail;

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
     * @var array
     *
     * @MongoDB\ReferenceMany(targetDocument="Comment", mappedBy="userId")
     */
    private $comments;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     */
    private $role;

    /**
     * @var integer
     *
     * @MongoDB\Id
     */
    private $id;

    public function __construct()
    {
        $this->role = 'ROLE_USER';
        $this->comments = new ArrayCollection();
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
     * Set email
     *
     * @param string $email
     * @return self
     */
    public function setMail($email)
    {
        $this->mail = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getMail()
    {
        return $this->mail;
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
     * @return id $id
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
    public function addComment(\Wineot\DataBundle\Document\Comment $comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * Remove comment
     *
     * @param \Wineot\DataBundle\Document\Comment $comment
     */
    public function removeComment(\Wineot\DataBundle\Document\Comment $comment)
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
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        return array($this->role);
    }

    /**
     * Set role
     *
     * @param string $role
     * @return self
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Get role
     *
     * @return string $role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return array
     */
    public static function getRolesType()
    {
        return array(
            'ROLE_USER' => 'User',
            'ROLE_ADMIN' => 'Admin'
        );
    }
}
