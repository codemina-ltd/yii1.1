<?php
/**
 * @var string $className
 * @var array<string, CMysqlColumnSchema> $columns
 * @var string $tableName
 * @var array $rules
 * @var array $relations
 * @var array $labels
 */
?>
<?php echo "<?php\n"; ?>

<?php foreach($columns as $column): ?>
<?= $column->comment === 'ARType:money' ? "use Money\Money;\n" : '' ?>
<?php endforeach;?>
use Doctrine\ORM\Mapping\Entity;

#[Entity(repositoryClass: <?= $className ?>Repository::class)]
class <?php echo $className; ?> extends AbstractModel
{
    <?= "use UuidTrait;\r"?>
    <?= "use DateAtTrait;\n\r"?>

<?php foreach($columns as $column): ?>
<?php if (in_array($column->name, ['created_at', 'updated_at', 'deleted_at', 'uuid'])) continue ?>
    <?php echo 'public '.($column->allowNull ? '?' : '').ModelCommand::getDataType($column).' $'.$column->name.";\n"; ?>
<?php endforeach; ?>

    public function tableName(): string
    {
        return '<?php echo $tableName; ?>';
    }

    public function rules(): array
    {
        return [
    <?php foreach($rules as $rule): ?>
        <?php echo $rule.",\n"; ?>
    <?php endforeach; ?>
    ];
    }

    public function relations(): array
    {
        return [
    <?php foreach($relations as $name => $relation): ?>
        <?php echo "'$name' => $relation,\n"; ?>
    <?php endforeach; ?>
    ];
    }

    public function attributeLabels(): array
    {
        return [
    <?php foreach($labels as $column => $label): ?>
<?php if (in_array($column, ['created_at', 'updated_at', 'deleted_at', 'uuid', 'id'])) continue ?>
        <?php echo "'$column' => '$label',\n"; ?>
    <?php endforeach; ?>
    ];
    }

    public static function model(string $className=__CLASS__): self
    {
        return parent::model($className);
    }
}