# GollumSFUserBundle

[![Build Status](https://travis-ci.org/GollumSF/user-bundle.svg?branch=master)](https://travis-ci.org/GollumSF/user-bundle)
[![License](https://poser.pugx.org/gollumsf/user-bundle/license)](https://packagist.org/packages/gollumsf/user-bundle)
[![Latest Stable Version](https://poser.pugx.org/gollumsf/user-bundle/v/stable)](https://packagist.org/packages/gollumsf/user-bundle)
[![Latest Unstable Version](https://poser.pugx.org/gollumsf/user-bundle/v/unstable)](https://packagist.org/packages/gollumsf/user-bundle)


## Installation:

### AppKernel.php
```php
class AppKernel extends Kernel {
	
	public function registerBundles() {
		
		$bundles = [
			
			// [...] //
			
			new GollumSF\CoreBundle\GollumSFCoreBundle(),
			new GollumSF\CoreBundle\GollumSFMailBundle(),
			new GollumSF\UserBundle\GollumSFUserBundle(),
			
			// [...] // 
		}
	}
}
```

### config.yml

```yml
gollum_sf_user:
    user:
        entity:  GollumSF\UserBundle\Entity\User                            # (optional) Entity class of user for login implement GollumSF\UserBundle\Entity\UserInterface
        manager: GollumSF\UserBundle\Manager\UserManager                    # (optional) Manager class implement GollumSF\UserBundle\Manager\ManagerInterface
    url:
        homepage: /                                                         # (optional) Homepage URL for redirect after login
    twig:
        base:           '::base.html.twig'                                  # (optional) Twig loaded when the base_auth extends 
        base_auth:      'GollumSFUserBundle:Auth:base.html.twig'            # (optional) Twig loaded when the form page extends 
        login:          'GollumSFUserBundle:Auth:login.html.twig'           # (optional) Twig loaded for login page
        register:       'GollumSFUserBundle:Auth:register.html.twig'        # (optional) Twig loaded for register page
        reset_password: 'GollumSFUserBundle:Auth:resetPassword.html.twig'   # (optional) Twig loaded for reset password page
    form:
        login:          GollumSF\UserBundle\Form\LoginType                  # (optional) FormType for login
        register:       GollumSF\UserBundle\Form\RegisterType               # (optional) FormType for register
        reset_password: GollumSF\UserBundle\Form\ResetPasswordType          # (optional) FormType for reset password
    url:
        homepage:       /                                                   # (optional) Homepage URL for redirect after login
        login:          /login                                              # (optional) Login URL must matched the routing value
        register:       /register                                           # (optional) Register URL must matched the routing value
        reset_password: /reset-password                                     # (optional) Redirect URL must matched the routing value
```


### routing.yml

Must matched the config.yml urls values.
By default the 3 urls is /login, /register, /reset-password

```yml
gsf_user:
    resource: "@GollumSFUserBundle/Controller/"
    type:     gsf_annotation
```


### security.yml

```yml
security:
    role_hierarchy: 
        ROLE_USER:  []
        ROLE_ADMIN: [ROLE_USER]
        ROLE_SUPER_ADMIN: [ROLE_ADMIN]
        
    providers:
        main:
            entity: { class: "GollumSFUserBundle:User" } # Must match gollum_sf_user.user.entity

    firewalls:
        main:
            pattern: ^/   # Path where enable the authentification
            gsf_user: ~   # Enable the authentification
            anonymous: ~  # Enable the anonymous authentification
```