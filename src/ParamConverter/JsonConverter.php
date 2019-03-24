<?php

declare(strict_types=1);

namespace RequestContentMapper\ParamConverter;

use RequestContentMapper\Serializer\SerializerInterface;
use RequestContentMapper\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Marcin Przyborowski <hiprzyborowski@gmail.com>
 */
final class JsonConverter implements ParamConverterInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        ValidatorInterface $validator,
        SerializerInterface $serializer
    ) {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    /**
     * Stores the object in the request.
     *
     * @param Request        $request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @throws \RequestContentMapper\Validator\Exception\ValidationException
     *
     * @return bool True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $data = $this->decodeRequest($request);
        $class = $configuration->getClass();
        $obj = new $class($data);
        $this->validator->validate($obj);
        $request->attributes->set($configuration->getName(), $obj);

        return true;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    private function decodeRequest(Request $request): array
    {
        $content = $request->getContent();

        return $this->serializer->deserialize($content);
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration
     *
     * @throws \ReflectionException
     *
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration): bool
    {
        $class = $configuration->getClass();

        if (!class_exists($class)) {
            return false;
        }

        $ref = new \ReflectionClass($class);

        return $ref->isSubclassOf(RequestContentObject::class);
    }
}
