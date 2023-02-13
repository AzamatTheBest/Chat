<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Chat;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity]
#[ORM\Table('messages')]
class Message
{
    #[ORM\Id()]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[Groups('message')]
    private $id;

    #[ORM\Column(type: 'string')]
    #[Groups('message')]
    private $text;

    #[ORM\Column(type: 'datetime')]
    #[Groups('message')]
    private $sentAt;

    #[ORM\ManyToOne(targetEntity: Chat::class, inversedBy: 'messages')]
    #[Groups('message')]
    private Chat $chat;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn('sender_id', referencedColumnName: 'id')]
    #[Groups('message')]
    private ?User $sender = null;

    public function __construct(?string $text = null)
    {
        $this->text = $text;
        $this->sentAt = new \DateTime();
    }


    public function setText(string $text)
    {
        $this->text = $text;
        return $this;
    }


    public function getId(){
        return $this->id;
    }


    public function getText()
    {
        return $this->text;
    }


    public function getSentAt(){
        return $this->sentAt;
    }

	/**
	 * @return Chat
	 */
	public function getChat(): Chat {
		return $this->chat;
	}
	
	/**
	 * @param Chat $chat 
	 * @return self
	 */
	public function setChat(Chat $chat): self {
		$this->chat = $chat;
		return $this;
	}


	public function getSender(): ?User {
		return $this->sender;
	}
	

	public function setSender(User $sender): self {
		$this->sender = $sender;
		return $this;
	}
}