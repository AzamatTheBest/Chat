<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Chat;


#[ORM\Entity]
#[ORM\Table('messages')]
class Message
{
    #[ORM\Id()]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(type: 'string')]
    private $text;

    #[ORM\Column(type: 'datetime')]
    private $sentAt;

    #[ORM\ManyToOne(targetEntity: Chat::class, inversedBy: 'messages')]
    private Chat $chat;

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
}