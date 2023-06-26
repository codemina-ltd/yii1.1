<?php
/**
 * @var string $className
 */
?>
<?= "<?php\n"?>

#[Repository(entityClass: <?= $className ?>::class)]
class <?= $className?>Repository extends AbstractRepository
{
    /**
    * @param ProductPrice $entity
    * @param EntityInputInterface $dto
    * @return void
    */
    public function fill(EntityInterface $entity, EntityInputInterface $dto): void
    {
        // TODO: Implement fill() method.
    }
}