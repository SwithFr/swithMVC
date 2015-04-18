<?php

namespace Core\Components;

class Validator
{

    // Tableau des erreurs à retourner avec le message ['champ'=>'message']
    public $errors = [];

    /**
     * Fonction principale du validateur. Renvoie vers les fonctions correpondantes aux règles de validation demandées
     * @param  array $data Les donnée à valider
     * @param  array $rules Le tableaux des règles de validation
     * @return bool   true ou false selon si tous les champs sont valides ou non
     */
    public function validate($data, array $rules)
    {

        foreach ($data as $field => $value) {

            // Pour chaque données on vérifie si il existe une règle
            if (isset($rules[$field])) {

                // Si on a une règle on va appeller la/les fonctions pour tester si les données sont valides
                foreach ($rules[$field] as $k => $v) {

                    //$v['ruleName'] correspond au nom d'une fonction de validation
                    $this->$v['ruleName']($field, $value, isset($v['message']) ? $v['message'] : null);

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
     */
    public function notEmpty($field, $value, $message = null)
    {

        // Si la valeur (sans espace) n'est pas vide
        if (trim($value) != "") {

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
     * Vérifie si les données sont une chaine de caractères
     */
    public function isString($field, $value, $message = null)
    {

        if (is_string(trim($value))) {

            return true;

        } else {

            if ($message == null)
                $message = "le champ $field est obligatoire";

            $this->errors[$field] = $message;
            return false;
        }

    }

    /**
     * Vérifie si c'est un email au bon format
     */
    public function isMail($field, $value, $message = null)
    {

        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {

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
     */
    public function isInt($field, $value, $message = null)
    {

        if (is_numeric($value)) {

            return true;

        } else {

            if ($message == null)
                $message = "le champ $field n'est pas un nombre";

            $this->errors[$field] = $message;
            return false;

        }

    }

    // Retourne le message d'erreur du champ passé en paramettre
    public function message($field)
    {
        if (isset($this->errors[$field]))
            return $this->errors[$field];
        else
            return false;
    }

    // Retourne le tableau contenant toutes les erreurs
    public function errors()
    {
        if (!empty($this->errors))
            return $this->errors;
        else
            return false;
    }

}