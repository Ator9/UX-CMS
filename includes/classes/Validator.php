<?php
/**
    Powered by Ator:
    Clase para validar campos.

    USO:
    - Extender la clase.
    - Versión Live/JS: <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

    ------------------------------------------------------

    Ejemplo 1: Validación completa

    // Inicio la Validación:
    $live = new Validator();
    if($live->validate($_POST))
    {
        // Validacion OK
    }
    else $errors = $live->getErrors();

    ------------------------------------------------------

    Ejemplo 2: Validación de campos especificos o 1 solo campo para el live.

    // Inicio la Validación:
    $live = new Validator();
    if($live->validate($_POST, array('nombre')))
    {
        // Validacion OK
    }
    else $errors = $live->getErrors();

    ------------------------------------------------------

*/

class Validator
{
    public $fieldsToValidate = array(); // Campos que requieren validacion
    public $errors           = array(); // Listado de errores


    // --------------------------------------------------------------------------------------------------------
    // MODIFICABLE:
    // --------------------------------------------------------------------------------------------------------


    // Campos a validar:
    public function getFields()
    {
        $fields['email']    = array('type'=>'email',       'error'=>'Por favor ingresar E-mail.', 'error2'=>'Por favor ingresar un E-mail correcto.');
        $fields['nombre']   = array('type'=>'string',      'error'=>'Por favor ingresar Nombre.', 'error2'=>'2Por favor ingresar Nombre.');
        $fields['telefono'] = array('type'=>'numeric',     'error'=>'Por favor ingresar Teléfono.');
        $fields['optin']    = array('type'=>'optin',       'error'=>'Por favor ingresar nuevas ofertas.');
        $fields['cp']       = array('type'=>'cparg',       'error'=>'Por favor ingresar Código Postal.');
        $fields['tyc']      = array('type'=>'values',      'error'=>'Por favor aceptar los Términos.', 'values'=>array('Y'));
        $fields['apellido'] = array('type'=>'_customFunc', 'error'=>'Por favor XXX.');

        return $fields;
    }


    // Validacion especial no contemplada en BASE:
    protected function _customFunc($field, $value)
    {
        if($value=='si') return true;
        elseif($value=='sipero') return 'error_custom';
        return false;
    }


    // --------------------------------------------------------------------------------------------------------
    // BASE:
    // --------------------------------------------------------------------------------------------------------


    // Inicio:
    public function __construct()
    {
        $this->fieldsToValidate = $this->getFields();
    }


    // Validate:
    public function validate($input, $fields=array(), $exclude=array())
    {
        foreach($this->fieldsToValidate as $key => $data)
        {
            if(!empty($fields) && !in_array($key, $fields)) continue;
            if(!empty($exclude) && in_array($key, $exclude)) continue;

            // Validacion.
            // Si no existe o está vacío = error. Si no valida = error2.
            if(!isset($input[$key]) || (gettype($input[$key])=='string' && trim($input[$key])=='')) $this->errors[$key] = $data['error'];
            else
            {
                $result = $this->validateType($data, $input[$key]);
                if($result === false) $this->errors[$key] = isset($data['error2']) ? $data['error2'] : $data['error'];
                elseif($result !== true) $this->errors[$key] = $result;
            }
        }

        if(empty($this->errors)) return true;
        return false;
    }


    // Valido según el tipo de dato:
    public function validateType($field, $value)
    {
        switch($field['type'])
        {
            case 'email':
                if(filter_var($value, FILTER_VALIDATE_EMAIL) === false) return false;
                break;

            case 'letters': // Solo letras
                if(preg_match('/[^a-zA-ZáÁéÉíÍóÓúÚñÑ ]+/', $value)) return false;
                break;

            case 'string': // Cualquier cosa
                if(!is_string($value)) return false;
                break;

            case 'numbers': // Solo números
                if(preg_match('/[^0-9]/', $value)) return false;
                break;

            case 'numeric': // Numérico: 10.4 valida
                if(!is_numeric($value)) return false;
                break;

            case 'optin': // Y/N
                if($value!='Y' && $value!='N') return false;
                break;

            case 'cparg': // Código postal argentino
                if(!preg_match('/^[a-zA-Z]{0,1}[0-9]{4}[a-zA-Z]{0,4}$/', $value)) return false;
                break;

            case 'values': // Solo acepta los valores que seteamos
                if(!in_array($value, $field['values'])) return false;
                break;

            default: // Creamos funcion custom para validar
                $result = $this->{$field['type']}($field, $value);
                if($result === false) return false;
                elseif($result !== true) return $result;
                break;
        }

        // Validaciones adicionales:
        if(isset($field['eq'])  && strlen($value) != $field['eq']) return false; // # caracteres igual a
        if(isset($field['min']) && strlen($value) < $field['min']) return false; // # caracteres minimos
        if(isset($field['max']) && strlen($value) > $field['max']) return false; // # caracteres maximos

        return true;
    }


    // Get errors:
    public function getErrors()
    {
        return $this->errors;
    }
}

