<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuotesRepository")
 */
class Quotes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $strQuote;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
    */
    private $date;

    public function __construct()
    {
        $this->id;
        $this->strQuote;
        $this->rating;
        $this->date;
    }

    public function __toString()
    {
        return $this->strQuote;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStrQuote(): ?string
    {
        return $this->strQuote;
    }

    public function setStrQuote(string $StrQuote): self
    {
        $this->strQuote = $StrQuote;

        return $this;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating): void
    {
        $this->rating = $rating;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }
}
