# Installation

`composer require api`

## Serialization

- https://api-platform.com/docs/core/serialization/

- https://symfonycasts.com/screencast/api-platform/serialization-groups

object -> array -> format (json/xml/...) - serialization

format(json/xml/...) -> array -> object - deserialization

### Serialization groups

If the only way to control the input and output of our API was by controlling the getters and setters on our entity, it wouldn't be that flexible... and could be a bit dangerous. You might add a new getter or setter method for something internal and not realize that you were exposing new data in your API!

The solution for this - and the way that I recommend doing things in all cases - is to use serialization groups.

```
/**
 * #[ApiResource(
 *   normalizationContext: ['groups' => ['read']],
 *   denormalizationContext: ['groups' => ['write']],
 *   )]
 */
class CheeseListing
```

## Filters and Searching
```
#[ApiFilter(BooleanFilter::class, properties: ["isPublished"])]
#[ApiFilter(BooleanFilter::class, properties: ["isPublished"])]
#[ApiFilter(SearchFilter::class, properties: ["title" => "partial"])]
```


https://api-platform.com/docs/core/filters/

## Sparse fieldset

We can list fields we want to get with API via PropertyFilter

https://api-platform.com/docs/core/filters/


## Pagination

- page parameter for GET request

- in annotation we can control number of items to return per page (pagination_items_per_page)

```
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    attributes: [
        'pagination_items_per_page' => 10,
    ]
)]
```

## More Formats: HAL & CSV

json, hal json, xml, yaml, csv

`php bin/console debug:config api_platform`

formats annotation in @apiResource

```
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    attributes: [
        'pagination_items_per_page' => 5,
        'formats' => ['csv' => 'text/csv']
    ]
)]
```

## Validation

```
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Column(type: 'string', length: 255)]
#[Groups(["read", "write"])]
#[Assert\NotBlank]
#[Assert\Length([
    'min' => 1,
    'max' => 50
])]
private $title;
```


## Useful commands
### Doctrine

`php bin/console doctrine:database:create`

`php bin/console doctrine:migrations:migrate`

`php bin/console make:migration`

`./bin/console doctrine:schema:drop --full-database`

`./bin/console doctrine:schema:drop --force`
