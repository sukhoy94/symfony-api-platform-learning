# Installation

`composer require api`

## Serialization

- https://api-platform.com/docs/core/serialization/

- https://symfonycasts.com/screencast/api-platform/serialization-groups

object -> array -> format (json/xml/...) - serialization

format(json/xml/...) -> array -> object - deserialization

### Serialization groups

```
/**
 * #[ApiResource(
 *   normalizationContext: ['groups' => ['read']],
 *   denormalizationContext: ['groups' => ['write']],
 *   )]
 */
class CheeseListing
```

## Useful commands
### Doctrine

`php bin/console doctrine:database:create`

`php bin/console doctrine:migrations:migrate`

`php bin/console make:migration`
