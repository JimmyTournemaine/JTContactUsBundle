<?php

namespace JT\ContactUsBundle\Model;

use JT\ContactUsBundle\Model\ContactInterface;
use AppBundle\Entity\Subject;

/**
 * Contact
 * @author Jimmy Tournemaine <jimmy.tournemaine@yahoo.fr>
 */
class Contact implements ContactInterface
{
    protected $name;
    protected $email;
    protected $subject;
    protected $content;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

}

