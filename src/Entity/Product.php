<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Table('products')]
#[ORM\Entity]
class Product
{
    #[Regex('/^[a-zA-Z]{3,180}$/')]
    private string $title;

    #[Regex('/^[a-zA-Z]?$/')]
    private string $description;

    #[Regex('/^\d-?$/')]
    private string $code;

    #[Regex('/^[a-zA-Z]$/')]
    private string $slug;


    public function getDescription(): string {
		return $this->description;
	}
	
	
	public function setDescription(string $description): self {
		$this->description = $description;
		return $this;
	}

	
	public function getCode(): string {
		return $this->code;
	}
	
	
	public function setCode(string $code): self {
		$this->code = $code;
		return $this;
	}

	
	public function getSlug(): string {
		return $this->slug;
	}
	
	
	public function setSlug(string $slug): self {
		$this->slug = $slug;
		return $this;
	}

	
	public function getTitle(): string {
		return $this->title;
	}
	
	
	public function setTitle(string $title): self {
		$this->title = $title;
		return $this;
	}
}