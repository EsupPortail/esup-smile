<?php


namespace Application\Application\Form\Misc\CodeValidator;

use Application\Application\Form\Misc\CodeValidator\CodeValidator;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class CodeValidatorFactory
 * @package Application\Application\Form\Factory\Validator
 */
class CodeValidatorFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return CodeValidator|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $validator = new CodeValidator();
        return $validator;
    }
}