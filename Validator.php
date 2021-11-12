<?php

namespace Core;

trait Validator
{
    protected $status = true;

    protected $lang = [];

    protected $errors = [];

    protected $inputs = [];

    protected $validated = [];

    // define arquivo de de mensagens de validação
    public function setValidatorLang(array $lang) : void
    {
        $this->lang = $lang;
    }

    // define nome da session usada para retornar os erros de validação
    public function setErrorsSessionName(string $sessionName) : void
    {
        $this->errorsSessionName = $sessionName;
    }

    // retorna todos os campos validados
    public function validated() : array
    {
        return $this->inputs;
    }

    // valida campos da requisição
    public function validate(array $rules) : bool
    {
        // percorre os métodos correspondentes as regras passadas por parametro
        foreach ($rules as $inputName => $rule)
        {
            $rulesArray = explode('|', $rule);
            foreach ($rulesArray as $r)
            {
                $requestArray = explode(':', $r);
                $requestAction = $requestArray[0]; 
                $requestParam = isset($requestArray[1]) ? $requestArray[1] : NULL;
                $this->$requestAction($inputName, $requestParam);
            }   
        }

        // inicia session
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        // define session padrão se não estiver configurada
        if(!$this->errorsSessionName)
            $this->errorsSessionName = 'alert-errors';

        // salva erros na session
        $_SESSION[$this->errorsSessionName] = $this->errors;

        // retorna status da validação
        return $this->status;
    }

    // retorna nome do campo no idioma setado
    public function getInputName(string $inputName) : string
    {
        return isset($this->lang['attributes'][$inputName]) ? $this->lang['attributes'][$inputName] : $inputName;
    }

    // retorna mensagem de erro do campo no idioma setado
    public function getMessage(string $inputRule) : string
    {
        return isset($this->lang['messages'][$inputRule]) ? $this->lang['messages'][$inputRule] : '';
    }

    // regra para obrigatoriedade do campo
    public function required($inputName, $param=0)
    {
        // verifica se campo não existe
        if(!isset($this->attributes[$inputName]) || empty($this->attributes[$inputName]))
        {
            $this->status = false;
            $this->errors[$inputName]['required'] = $this->getMessage($inputName.'.required');
        } else {
            $this->inputs[$inputName] = $this->attributes[$inputName];
        }
    }

    // regra para máximo de caracteres do valor do campo
    public function max($inputName, $max)
    {
        if($max < strlen($this->attributes[$inputName]))
        {
            $this->status = false;
            $this->errors[$inputName]['max'] = str_replace(':max', $max, $this->getMessage($inputName.'.max'));
        } else {
            $this->inputs[$inputName] = $this->attributes[$inputName];
        }
    }

    // regra para mínimo de caracteres do valor do campo
    public function min($inputName, $min)
    {
        if($min > strlen($this->attributes[$inputName]))
        {
            $this->status = false;
            $this->errors[$inputName]['min'] = $this->getMessage($inputName.'.min');
        }  else {
            $this->inputs[$inputName] = $this->attributes[$inputName];
        }
    }
    
    // regra para tipo de dado do valor do campo
    public function datatype($inputName, $type)
    {
        if($type != gettype($this->attributes[$inputName]))
        {
            $this->status = false;
            $this->errors[$inputName]['datatype'] = $this->getMessage($inputName.'.datatype');
        } else {
            $this->inputs[$inputName] = $this->attributes[$inputName];
        }
    }
}