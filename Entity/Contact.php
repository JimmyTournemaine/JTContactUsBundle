<?php
namespace JT\ContactUsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JT\ContactUsBundle\Model\Contact as BaseContact;

/**
 * Contact
 * @author Jimmy Tournemaine <jimmy.tournemaine@yahoo.fr>
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class Contact extends BaseContact
{
    protected $id;

    /**
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @ORM\Column(name="email", type="string")
     */
    protected $email;

    /**
     * @ORM\Column(name="subject", type="string")
     */
    protected $subject;

    /**
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @ORM\Column(name="sent_at", type="datetime")
     */
    protected $sentAt;

    /**
     * @ORM\PrePersist()
     */
    public function onCreate(){
        $this->sentAt = new \DateTime();
    }

    public function getSentAt()
    {
        return $this->sentAt;
    }

    public function setSentAt($sentAt)
    {
        $this->sentAt = $sentAt;
        return $this;
    }

}

