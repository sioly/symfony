<?php

namespace PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="PlatformBundle\Repository\UsersRepository")
 */
class Users
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idUser", type="integer")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="idProject", type="integer")
     */
    private $idProject;

    /**
     * @var int
     *
     * @ORM\Column(name="idSubProject", type="integer")
     */
    private $idSubProject;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Users
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idProject
     *
     * @param integer $idProject
     *
     * @return Users
     */
    public function setIdProject($idProject)
    {
        $this->idProject = $idProject;

        return $this;
    }

    /**
     * Get idProject
     *
     * @return int
     */
    public function getIdProject()
    {
        return $this->idProject;
    }

    /**
     * Set idSubProject
     *
     * @param integer $idSubProject
     *
     * @return Users
     */
    public function setIdSubProject($idSubProject)
    {
        $this->idSubProject = $idSubProject;

        return $this;
    }

    /**
     * Get idSubProject
     *
     * @return int
     */
    public function getIdSubProject()
    {
        return $this->idSubProject;
    }
}

