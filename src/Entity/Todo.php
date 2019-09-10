<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TodoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Todo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Worker")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Worker", inversedBy="todos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $worker;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $medium;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priority;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_planed;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_deadline;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $completed;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_created;

    public function __construct()
    {
        $this->setDateCreated(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContact(): ?Worker
    {
        return $this->contact;
    }

    public function setContact(?Worker $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getWorker(): ?Worker
    {
        return $this->worker;
    }

    public function setWorker(?Worker $worker): self
    {
        $this->worker = $worker;

        return $this;
    }

    public function getMedium(): ?string
    {
        return $this->medium;
    }

    public function setMedium(string $medium): self
    {
        $this->medium = $medium;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getDatePlaned(): ?\DateTimeInterface
    {
        return $this->date_planed;
    }

    public function setDatePlaned(?\DateTimeInterface $date_planed): self
    {
        $this->date_planed = $date_planed;

        return $this;
    }

    public function getDateDeadline(): ?\DateTimeInterface
    {
        return $this->date_deadline;
    }

    public function setDateDeadline(?\DateTimeInterface $date_deadline): self
    {
        $this->date_deadline = $date_deadline;

        return $this;
    }

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(?\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public static function getMediumMapping()
    {
        return [
            'Email' => 'email',
            'Usmeno' => 'usmeno',
            'Spec.' => 'spec',
            'Slack' => 'slack'
        ];
    }

    public function getReadableMedium()
    {
        return array_flip(self::getMediumMapping())[$this->medium];
    }

    public function __toString()
    {
        return $this->description;
    }
}
