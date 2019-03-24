# Symfony Request Content Mapper Bundle

## Quick start

###1. `composer require mprzyborowski/request-content-mapper-bundle`
###2. add line to config/bundles.php `RequestContentMapper\RequestContentMapperBundle::class => ['all' => true],`
###3. Create Request Object extending from `RequestContentMapper\ParamConverter\RequestContentObject`
 Example (with Symfony Asserts it works automatically):
```php
<?php

declare(strict_types=1);

namespace App\Controller\Request;

use RequestContentMapper\ParamConverter\RequestContentObject;
use Symfony\Component\Validator\Constraints as Assert;

class TestRequest extends RequestContentObject
{

    /**
     * @Assert\NotNull()
     */
    public $firstName;
    /**
     * @Assert\NotNull()
     */
    public $lastName;
    /**
     * @Assert\NotNull()
     * @Assert\Email()
     */
    public $email;
    /**
     * @Assert\NotNull()
     * @Assert\Length(min="5", max="10")
     */
    public $phone;
}
```
###4. Create Controller:

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Request\TestRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{

    /**
     * @Route("/")
     * @Method({"POST"})
     * @param TestRequest $testRequest
     * @return JsonResponse
     */
    public function __invoke(TestRequest $testRequest)
    {
        return new JsonResponse($testRequest);
    }
}

```

###5. Send Request To Controller:


```json
{
	"firstName": "foo",
	"lastName": "bar",
	"email": "foo@bar.com",
	"phone": "example"
}
```

####It will be automatically mapped to TestRequest.

---

###Validation return array with errors keys:
```json
{
    "errors": [
        "firstName: This value should not be null.",
        "lastName: This value should not be null.",
        "email: This value should not be null.",
        "phone: This value should not be null."
    ]
}
```
