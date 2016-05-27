<?php

namespace Crmp\HrBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * In order to give every employee a mission
 * an entity for tasks has been introduced.
 * It will help you store
 * and manage all tasks / jobs / stint.
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="Crmp\HrBundle\Repository\TaskRepository")
 */
class Task
{
    /**
     * Identifier.
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Title of the task.
     *
     * The title of the task is mend for overviews / lists.
     * It can be anything up to 255 characters.
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * Detailed description.
     *
     * A detailed description of the things that need to be done.
     * This description can be a large text.
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

