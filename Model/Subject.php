<?php
namespace JT\ContactUsBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class Subject implements SubjectInterface
{
	/**
	 * @ORM\Column(name="label", type="string", length="31")
	 */
    protected $label;

    protected $to;

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

}
