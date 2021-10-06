<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator \app\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $properties array list of properties (property => [type, name. comment]) */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $commonLabels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */
/* @var $relationsClassHints array  */

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php foreach ($properties as $property => $data): ?>
 * @property <?= "{$data['type']} \${$property}"  . ($data['comment'] ? ' ' . strtr($data['comment'], ["\n" => ' ']) : '') . "\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends <?= '\\' . $generator->commonNs . '\\' . $className . "\n" ?>
{
<?php if($generator->addRuEnTrait): ?>
    use RuEnActiveRecordTrait;

    public $name;
<?php endif; ?>

    /**
    * {@inheritdoc}
    */
    public function behaviors()
    {
        return [
            ChangelogBehavior::class
        ];
    }

    /**
    * {@inheritdoc}
    */
    public function attributeLabels()
    {
        return [
        <?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
        <?php endforeach; ?>
        ];
    }

<?php foreach ($relations as $name => $relation): ?>

    /**
    * Gets query for [[<?= $name ?>]].
    *
    * @return <?= $relationsClassHints[$name]['cms'] . "\n" ?>
    */
    public function get<?= $name ?>()
    {
    <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

}
