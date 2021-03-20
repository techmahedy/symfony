<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

   /**
     * @ORM\OneToMany(targetEntity="App\Entity\JobPost", mappedBy="category")
     */
    private $jobPost;

    public function __construct()
    {
        $this->jobPost = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|JobPost[]
     */
    public function getJobPost(): Collection
    {
        return $this->jobPost;
    }

    public function addJobPost(JobPost $jobPost): self
    {
        if (!$this->jobPost->contains($jobPost)) {
            $this->jobPost[] = $jobPost;
            $jobPost->setCategory($this);
        }

        return $this;
    }

    public function removeJobPost(JobPost $jobPost): self
    {
        if ($this->jobPost->removeElement($jobPost)) {
            // set the owning side to null (unless already changed)
            if ($jobPost->getCategory() === $this) {
                $jobPost->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
