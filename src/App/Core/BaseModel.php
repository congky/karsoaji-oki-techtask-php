<?php

namespace App\App\Core;

abstract class BaseModel implements Model
{
    private $basePath = __DIR__ . "/../Json/";
    private $filters = [];
    private $orders = [];

    protected $jsonPath = "";
    protected $data = "";
    protected $primary = "id";

    public function __construct()
    {
        $class = new \ReflectionClass(get_called_class());

        $this->jsonPath = $this->basePath.$class->getShortName()."/data.json";
        $this->data = strtolower($class->getShortName())."s";
    }

    function get()
    {
        $result = [];
        $arrayContents = json_decode(file_get_contents($this->jsonPath), true);
        if(!empty($arrayContents)) {
            $result = $arrayContents[$this->data];

            // filter array
            if(!empty($result)) {
                if(!empty($this->filters)) {
                    Filters::list($result, $this->filters);
                }
            }
        }

        // sorting array
        if(!empty($this->orders) && !empty($result)) {
            Sorting::list($result, $this->orders);
        }
        return array_values($result);
    }

    function first()
    {
        $list = $this->get();
        return !empty($list) ? $list[0] : [];
    }

    function find($primary)
    {
        $result = [];
        if(!empty($this->get())) {
            foreach ($this->get() as $item) {
                if($item[$this->primary] == $primary) {
                    $result = $item;
                    break;
                }
            }
        }

        return $result;
    }

    function where($key, $value, $operator = Filters::EQUALS_THAN) {

        $this->filters[$key] = [
            "operator" => $operator,
            "value" => $value
        ];

        return $this;
    }

    function orderBy($key, $type=SORT_ASC) {

        $this->orders[$key] = $type;

        return $this;
    }
}