<?php

namespace ErickFirmo;

class Request
{
    use Validator;

    protected $attributes;

    protected $requestMethod;

    public function __construct()
    {
        // define método de requisição
        $this->setRequestMethod();
        // define atributos enviados na requisição
        $this->setAll();
        //define arquivo padrão de mensagens de validação
        $this->setValidatorLang(include 'lang/en.php');
    }

    // define método de requisição
    protected function setRequestMethod() : void
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }

    // define atributos enviados na requisição
    public function setAll(array $attributes=[]) : void
    {
        $this->attributes = !$attributes ? ($this->getRequestMethod() == 'POST' ? $_POST : $_GET) : $attributes;
    }

    // retorna método de requisição
    public function getRequestMethod() : string
    {
        return $this->requestMethod;
    }

    // retorna todos os atributos enviados na requisição
    public function all() : array
    {
        return $this->attributes;
    }

    // retorna atributo espeficífico da requisição
    public function input(string $inputName) : string
    {
        return isset($this->attributes[$inputName]) ? $this->attributes[$inputName] : '';
    }
}