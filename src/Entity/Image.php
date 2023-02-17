<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;



#[ORM\Table('images')]
#[ORM\Entity()]

class Image
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    #[Groups('message')]
    private string $path;

    #[ORM\Column(type: 'string')]
    private string $originalFilename;

    public function __construct(string $path, string $originalFilename)
    {
        $this->path = $path;
        $this->originalFilename = $originalFilename;
    }


	public function getPath(): string {
		return $this->path;
	}


	public function getOriginalFilename(): string {
		return $this->originalFilename;
	}

	
	public function getId(): ?int {
		return $this->id;
	}
}