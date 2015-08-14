<?php

namespace Core\Models\Behaviors;

use Core\Helpers\Date;

trait Validator
{

    /**
     * Tableau des erreurs à retourner avec le message ['champ'=>'message']
     * @var array
     */
    public $errors = [];

    /**
     * Tableau des champs obligatoires
     * @var array
     */
    private $areRequired = [];

    /**
     * Contient les données à valider
     * @var null
     */
    private $dataToValidate = null;

    /**
     * Tableau contenant les données sensées êtres égales
     * @var array
     */
    private $mustBeEquals = [];

    /**
     * Fonction principale du validateur. Renvoie vers les fonctions correpondantes aux règles de validation demandées
     * @param  array $data Les donnée à valider
     * @return bool   true ou false selon si tous les champs sont valides ou non
     */
    public function validate($data)
    {
        $rules = $this->validationRules;
        $this->dataToValidate = $data;
        foreach ($this->dataToValidate as $field => $value) {

            // Pour chaque données on vérifie si il existe une règle
            if (isset($rules[$field])) {

                // Si on a une règle on va appeller la/les fonctions pour tester si les données sont valides
                foreach ($rules[$field] as $k => $v) {
                    if ($v['ruleName'] == 'required') {
                        $this->areRequired[] = $field;
                    }

                    if ($v['ruleName'] === "equalsTo") {
                        $this->mustBeEquals[$field] = $v['to'];
                    }
                    //$v['ruleName'] correspond au nom d'une fonction de validation
                    $this->$v['ruleName']($field, trim($value), isset($v['message']) ? $v['message'] : null);

                }

            }
        }

        // On regarde la taille du tableau, si elle est différente de 0 c'est qu'on a des erreurs
        if (count($this->errors) == 0) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Vérifie si les données ne sont pas vides
     * @param $field
     * @param $value
     * @param null $message
     * @return bool
     */
    public function required($field, $value, $message = null)
    {

        // Si la valeur (sans espace) n'est pas vide
        if ($value != "") {

            // On incrémente le nombre de champs valide
            return true;

        } else {

            // Sinon on regarde si on a un message prévu ou pas
            if ($message == null)
                $message = "le champ $field est obligatoire";

            // On ajoute le champ et son message dans le tableau d'erreur.
            $this->errors[$field] = $message;

            return false;

        }

    }

    /**
     * Vérifie qu'une donnée est bien égale à une autre
     * @param $field
     * @param $value
     * @param null $message
     * @return bool
     */
    public function equalsTo($field, $value, $message = null)
    {
        $isRequired = array_key_exists($field, $this->areRequired);
        $to = $this->mustBeEquals[$field];

        if (!$isRequired && empty($value)) {
            return true;
        } elseif (
            ($isRequired && $value === $this->dataToValidate->$to) ||
            (!$isRequired && $value === $this->dataToValidate->$to && !empty($value))
        ) {

            return true;

        } else {

            if ($message == null)
                $message = "le champ $field doit être égale à $to";

            $this->errors[$field] = $message;
            return false;
        }
    }

    /**
     * Vérifie si les données sont une chaine de caractères
     * @param $field
     * @param $value
     * @param null $message
     * @return bool
     */
    public function isString($field, $value, $message = null)
    {

        $isRequired = array_key_exists($field, $this->areRequired);

        if (!$isRequired && empty($value)) {
            return true;
        } elseif (
            ($isRequired && is_string($value)) ||
            (!$isRequired && is_string($value) && !empty($value))
        ) {

            return true;

        } else {

            if ($message == null)
                $message = "le champ $field est obligatoire";

            $this->errors[$field] = $message;
            return false;
        }

    }

    /**
     * Vérifie si les données sont unique
     * @param $field
     * @param $value
     * @param null $message
     * @return bool
     */
    public function isUnique($field, $value, $message = null)
    {

        $isRequired = array_key_exists($field, $this->areRequired);
        $results = $this->get(['where' => [$field => $value]]);

        if (!$isRequired && empty($value)) {
            return true;
        } elseif (
            ($isRequired && empty($results)) ||
            (!$isRequired && empty($results) && !empty($value))
        ) {

            return true;

        } else {

            if ($message == null)
                $message = "le champ $field est déjà utilisé";

            $this->errors[$field] = $message;
            return false;
        }

    }

    /**
     * Vérifie si c'est un email au bon format
     * @param $field
     * @param $value
     * @param null $message
     * @return bool
     */
    public function isMail($field, $value, $message = null)
    {
        $isRequired = array_key_exists($field, $this->areRequired);
        if (!$isRequired && empty($value)) {
            return true;
        } elseif (
            ($isRequired && filter_var($value, FILTER_VALIDATE_EMAIL)) ||
            (!$isRequired && filter_var($value, FILTER_VALIDATE_EMAIL) && !empty($value))
        ) {

            return true;

        } else {

            if ($message == null)
                $message = "le champ $field n'est pas un email valide";

            $this->errors[$field] = $message;

            return false;

        }

    }

    /**
     * Vérifie si c'est un nombre
     * @param $field
     * @param $value
     * @param null $message
     * @return bool
     */
    public function isInt($field, $value, $message = null)
    {
        $isRequired = array_key_exists($field, $this->areRequired);

        if (!$isRequired && empty($value)) {
            return true;
        } elseif (
            ($isRequired && is_numeric($value)) ||
            (!$isRequired && is_numeric($value) && !empty($value))
        ) {

            return true;

        } else {

            if ($message == null) {
                $message = "le champ $field n'est pas un nombre";
            }

            $this->errors[$field] = $message;
            return false;

        }

    }

    /**
     * Vérifie si une date est valide (format jj-mm-yyyy)
     * @param $field
     * @param $value
     * @param null $message
     * @return bool
     */
    public function isDate($field, $value, $message = null)
    {
        $isRequired = array_key_exists($field, $this->areRequired);
        $isValid = Date::isValid($value);

        if (!$isRequired && empty($value)) {
            return true;
        } elseif (
            ($isRequired && $isValid) ||
            (!$isRequired && $isValid && !empty($value))
        ) {

            return true;

        } else {

            if ($message == null) {
                $message = "le champ $field n'est pas une date";
            }

            $this->errors[$field] = $message;
            return false;

        }

    }

    /**
     * Retourne le message d'erreur du champ passé en paramettre
     * @param $field
     * @return bool
     */
    public function message($field)
    {
        if (isset($this->errors[$field])) {
            return $this->errors[$field];
        } else {
            return false;
        }
    }

    // Retourne le tableau contenant toutes les erreurs
    public function getErrors()
    {
        return $this->errors;
    }

}