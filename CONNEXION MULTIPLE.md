# Connecter plusieurs users de nature différentes

Il faudra modifier la configuration dans le fichier config/packages/security.yaml

[Un exemple est fourni ici](https://gist.github.com/NegiAlba/a4ff67d1c1181684ac8f97c925808f85)

Il faudra chaîner les providers et symfony ne le fais pas seul.

Lors de la réalisation d'un `symfony console make:user`, il y a la création d'un seul provider et il est surchargé si on refais la même opération.

Pour chaîner les providers il suffit de créer un arbre pour chacun d'un dans l'arbre providers comme ceci :

```yaml
providers:
  # used to reload user from session & other features (e.g. switch_user)
  app_candidate_provider:
    entity:
      class: App\Entity\Candidate
      property: email
  # used to reload user from session & other features (e.g. switch_user)
  app_company_provider:
    entity:
      class: App\Entity\Company
      property: email
```

Enfin, il suffit de rajouter un dernier provider qui servira de chaînage (à mettre dans un ordre de priorité) et qui sera le provider à insérer dans l'autentification.

```yaml
app_users:
      chain:
        providers: ["app_candidate_provider", "app_company_provider"]
  firewalls:
    main:
      lazy: true
      provider: app_users
      custom_authenticator: App\Security\CompanyAuthenticator
      logout:
        path: app_logout
```
