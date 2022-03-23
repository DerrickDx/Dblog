<?php
namespace App\Config;

use Psr\Container\ContainerInterface;


class Container implements ContainerInterface
{
    private array $entries = [];

    public function get(string $id)
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            return $entry($this);
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, string $concrete)
    {
        $this->entries[$id] = $concrete;
    }

    /**
     * Resolve constructors or classes
     * @param string $id
     */
    public function resolve(string $id)
    {
        $reflectionClass = new \ReflectionClass($id);

        // Inspect the class
        if (! $reflectionClass->isInstantiable()) {
            throw new CustomizedExceptions('Class "' . $id . '" is not instantiable');
        }

        // Inspect the constructor of the class
        $constructor = $reflectionClass->getConstructor();

        if (! $constructor) {
            return new $id;
        }
        // Inspect the constructor dependencies
        $parameters = $constructor->getParameters();

        if (! $parameters) {
            return new $id;
        }

        // Resolve classes using the container
        $dependencies = array_map(
            function (\ReflectionParameter $param) use ($id) {
                $name = $param->getName();
                $type = $param->getType();

                if (! $type) {
                    throw new CustomizedExceptions(
                        'Failed to resolve class "' . $id . '" because param "' . $name . '" is missing a type hint'
                    );
                }

                if ($type instanceof \ReflectionUnionType) {
                    throw new CustomizedExceptions(
                        'Failed to resolve class "' . $id . '" because of union type for param "' . $name . '"'
                    );
                }

                if ($type instanceof \ReflectionNamedType && ! $type->isBuiltin()) {
                    return $this->get($type->getName());
                }

                throw new CustomizedExceptions(
                    'Failed to resolve class "' . $id . '" because invalid param "' . $name . '"'
                );
            },
            $parameters
        );

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}