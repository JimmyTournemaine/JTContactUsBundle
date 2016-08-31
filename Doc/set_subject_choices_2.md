# Set a list of subjects

This setting allow you to propose a list of possible subjects instead of let the sujet field free.
You're also allow to use many receivers email depending of the subject.

## Create the subject entity

```php
<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JT\ContactUsBundle\Entity\Subject as BaseSubject;

/**
 * @ORM\Entity
 */
class Subject extends BaseSubject
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
```

### ORM Strategy extra-configuration

``` php
// src/AppBundle/Entity/Contact
// […]
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Subject")
     */
    protected $subject;

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }
// […]
```

Note that `@ORM\JoinColumn(onDelete="SET NULL")` is used to not loose a contact if you remove its associated subject entity.

### Update your database

Then update your database :

``` bash
php bin/console doctrine:schema:update —-force
```

## Set the bundle config

```yaml
# app/config/config.yml
jt_contact_us:
    class:
        subject: AppBundle\Entity\Subject
```

## Import the backend routing

```yaml
jt_contact_us_subject:
    resource: "@JTContactUsBundle/Resources/config/routing/subject.yml"
    prefix:   /subject
```

Don't forget to protect this paths behind your firewall !

## Next step

- TODO : Write the documentation for answers in a ORM context
- TODO : How to use custom mailer

## Configuration reference

```yaml
# Default configuration for "JTContactUsBundle"
jt_contact_us:
    strategy:             mail # One of "orm"; "mail", Required
    class:
        contact:              JT\ContactUsBundle\Model\Contact
        subject:              null
    form:
        contact:              JT\ContactUsBundle\Form\Type\ContactType
        subject:              JT\ContactUsBundle\Form\Type\SubjectType
        answer:               JT\ContactUsBundle\Form\Type\AnswerType
    anonymous:            true

    # The first address set will be the default one.
    delivery_addresses:   []

    # true: hide infos, use displayed_infos as substitute ; false: show infos ; null: let the choice during the answer writing
    hide_infos:           null
    displayed_infos:
        name:                 ~
        email:                ~ # Required, Example: noreply@yourdomain.com
```