<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity]
#[ORM\Table('chats')]
class Chat
{
    #[ORM\Id()]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
	#[Groups('message')]
    private $id;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'chat')]
    private Collection $messages;

    private $users;


    public function getId() {
		return $this->id;
	}


	/**
	 * @return string|null
	 */
	public function getTitle(): ?string {
		return $this->title;
	}
	
	/**
	 * @param string|null $title 
	 * @return self
	 */
	public function setTitle(?string $title): self {
		$this->title = $title;
		return $this;
	}


    
	/**
	 * @return string|null
	 */
	public function getDescription(): ?string {
		return $this->description;
	}
	
	/**
	 * @param string|null $description 
	 * @return self
	 */
	public function setDescription(?string $description): self {
		$this->description = $description;
		return $this;
	}



	
	public function getMessages(): Collection {
		return $this->messages;
	}
	
	
	public function setMessages(Collection $messages): self {
		$this->messages = $messages;
		return $this;
	}

	
	
}