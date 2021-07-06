<?php


namespace app\models\exceptions;

use Throwable;
use yii\db\ActiveRecord;

class UpdateExperimentsValidationException extends \Exception
{
    /**
     * @var array
     */
    private $infoArray;

    /**
     * UpdateExperimentsValidationException constructor.
     * @param ActiveRecord[] $erroredARs
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($erroredARs, $message = "", $code = 0, Throwable $previous = null)
    {
        foreach ($erroredARs as $id => $ar) {
            $shortClassName = (new \ReflectionClass($ar))->getShortName();
            $this->infoArray[] = [
                'id' => $id,
                'model' => $shortClassName,
                'fields' => $ar->errors,
            ];
        }
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getInfoArray(): array
    {
        return $this->infoArray;
    }
}