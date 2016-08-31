<?php
namespace JT\ContactUsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JT\ContactUsBundle\Model\Subject as BaseSubject;

/**
 * @ORM\MappedSuperclass
 */
abstract class Subject extends BaseSubject
{
    protected $id;

	/**
	 * @ORM\Column(name="label", type="string", length=31)
	 * @Assert\NotBlank()
	 * @Assert\Length(min=2,max=31)
	 */
    protected $label;

    /**
     * @ORM\Column(name="email", type="string")
	 * @Assert\NotBlank()
	 * @Assert\Email
     */
    protected $to;

    public function __toString()
    {
        return $this->label;
    }
}
