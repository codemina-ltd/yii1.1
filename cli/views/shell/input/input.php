<?php
/**
 * @var array<string, CMysqlColumnSchema> $columns
 * @var string $className
 */

$isAssertRequired = false;
?>
<?php echo "<?php\n"; ?>

<?php foreach($columns as $column): ?>
<?= $column->comment === 'ARType:money' ? "use Money\Money;\n" : '' ?>
<?php if ($column->allowNull && !$isAssertRequired) $isAssertRequired = true ?>
<?php endforeach;?>
<?= $isAssertRequired ? "use Symfony\Component\Validator\Constraints as Assert;\n": ''?>

class <?= $className ?>Input
{
<?php foreach($columns as $column): ?>
<?php if (in_array($column->name, ['created_at', 'updated_at', 'deleted_at'])) continue ?>
    <?= !$column->allowNull ? "#[Assert\NotBlank]\n" : ''?>
    <?php echo 'public ?'.ModelCommand::getDataType($column).' $'.$column->name.";\n"; ?>
<?php endforeach; ?>
}