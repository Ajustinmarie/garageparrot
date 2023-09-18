<?php

namespace App\Entity;

use App\Repository\ReponseMessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReponseMessageRepository::class)
 */
class ReponseMessage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\OneToOne(targetEntity=MessageContact::class, mappedBy="idReponseContact", cascade={"persist", "remove"})
     */
    private $messageContact;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_message_contact;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getMessageContact(): ?MessageContact
    {
        return $this->messageContact;
    }

    public function setMessageContact(?MessageContact $messageContact): self
    {
        // unset the owning side of the relation if necessary
        if ($messageContact === null && $this->messageContact !== null) {
            $this->messageContact->setIdReponseContact(null);
        }

        // set the owning side of the relation if necessary
        if ($messageContact !== null && $messageContact->getIdReponseContact() !== $this) {
            $messageContact->setIdReponseContact($this);
        }

        $this->messageContact = $messageContact;

        return $this;
    }

    public function getIdMessageContact(): ?int
    {
        return $this->id_message_contact;
    }

    public function setIdMessageContact(int $id_message_contact): self
    {
        $this->id_message_contact = $id_message_contact;

        return $this;
    }
}
