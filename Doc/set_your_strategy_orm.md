# ORM Strategy

## Create your contact entity

```php
<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JT\ContactUsBundle\Entity\Contact as BaseContact;

/**
 * @ORM\Entity
 */
class Contact extends BaseContact
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function getId()
    {
        return $this->id;
    }
}
```

## Configure the bundle to use it

```yaml
# app/config/config.yml
jt_contact_us:
    strategy: orm
    class:
        contact: AppBundle\Entity\Contact
```

## Update your databse

```bash
php bin/console doctrine:schema:update -—force
```

## Import routing

The ORM strategy store your contacts in your database.
So you need more actions to handle them.

```yaml
jt_contact_us_orm:
    resource: "@JTContactUsBundle/Resources/config/routing/orm.yml"
```

Don't forget to protect this paths behind your firewall !

## That's it !

[Go back](set_your_strategy_1.md)