<?php


namespace app\models\traits;


trait ValidatorsTrait
{
    public function validateDOI($attribute, $params, $validator)
    {
        if (preg_match('/^10./', $this->$attribute) !== 1) {
            $this->addError($attribute, 'Пожалуйста, введите ссылку в DOI формате ("10.1111/acel.12216")');
        }
    }

    public function validateAgeUnits($attribute, $params, $validator)
    {
        $this->addError($attribute, 'Пожалуйста, введите единицу измерения возраста');
        var_dump($this->age, $this->age_from, $this->age_to, $this->age_unit); die;
        if (isset($this->age) || isset($this->age_from) || isset($this->age_to)) {
            var_dump($this->age, $this->age_from, $this->age_to, $this->age_unit);
            if(empty($this->$attribute)) {
                $this->addError($attribute, 'Пожалуйста, введите единицу измерения возраста');
            }
        }
    }
}