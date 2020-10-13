<?php


namespace App\Models;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

abstract class ArrayModel
{
    protected $data;

    public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        return null;
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    abstract protected function getData(): array;

    /**
     * @param int $id
     *
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function find($id)
    {
        if (!$model = $this->getCollection()->firstWhere('id', $id)) {
            throw (new ModelNotFoundException)->setModel(static::class, $id);
        }

        return $model;
    }

    /**
     * @param string $key
     * @param string $operator
     * @param null|mixed $value
     *
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function firstOrFail(string $key, string $operator, $value = null)
    {
        if (!$model = $this->getCollection()->firstWhere(...func_get_args())) {
            throw (new ModelNotFoundException)->setModel(static::class, $operator.$value);
        }

        return $model;
    }

    public function getCollection(): Collection
    {
        return new Collection($this->makeFromArray($this->getData()));
    }

    public function makeFromArray($data)
    {
        $result = [];

        foreach ($data as $datum) {
            $result[] = new static($datum);
        }

        return $result;
    }
}
