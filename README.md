#Installation

##Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require jimmytournemaine/contact-us-bundle "1.0.*"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

##Step 2: Enable the Bundle


Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new JT\ContactUsBundle\JTContactUsBundle(),
        );

        // ...
    }

    // ...
}
```

#Settings

The bundle allow to use two strategies : 
- Send mails to you
- Store contacts in database to answer with a form wich send your answer to your interlocutor

You have also to choose between let the subject free or propose a list of choices.
If you have chose to propose choices, you can also configure a receiver for each different choice.
Let see it in details.

Of course, you need to [configure SwiftMailer](http://symfony.com/doc/current/reference/configuration/swiftmailer.html) to use this bundle.

##Simpliest example

### Mail strategy

```yaml
# app/config/config.yml
jt_contact_us:
    strategy: mail
    delivery_address: me@domain.fr
```

That's it. With this minimal configuration you will to be contacted by your users.
You've got the simpliest example. For advanced configuration choose betwenn [**mail**](Doc/set_your_strategy_mail_1.md) and [**ORM**](Doc/set_your_strategy_orm_1.md) management.
