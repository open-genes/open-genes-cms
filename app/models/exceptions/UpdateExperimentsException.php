<?php


namespace app\models\exceptions;

use Throwable;
use yii\db\ActiveRecord;

class UpdateExperimentsException extends \Exception
{
    /**
     * @var ActiveRecord
     */
    private $infoArray;

    public function __construct($id, ActiveRecord $ar, $message = "", $code = 0, Throwable $previous = null)
    {
        $shortClassName = (new \ReflectionClass($ar))->getShortName();
        $this->infoArray = [
            'id' => $id,
            'model' => $shortClassName,
            'fields' => $ar->errors,
        ];
        parent::__construct($message, $code, $previous);
    }

    public function getInfoArray()
    {
        return $this->infoArray;
    }
}