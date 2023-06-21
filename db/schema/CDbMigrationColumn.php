<?php

class CDbMigrationColumn
{
    public const TYPE_FLOAT = 'FLOAT';
    public const TYPE_FOREIGN_KEY = 'FOREIGN_KEY';
    public const TYPE_INTEGER = 'INTEGER';
    public const TYPE_BIG_INTEGER = 'BIG_INTEGER';
    const TYPE_STRING = 'STRING';
    const TYPE_UUID = 'UUID';
    const TYPE_ENUM = 'ENUM';
    const TYPE_TEXT = 'TEXT';
    const TYPE_LONG_TEXT = 'LONG_TEXT';
    const TYPE_MONEY = 'MONEY';
    const TYPE_DATE = 'DATE';
    const TYPE_DATETIME = 'DATETIME';

    public string $columnType;
    public string $dbType;
    public string $nullability = 'NULL';
    public int $length;
    public string $after;
    public string $comment;
    public string $refTable;
    public string $refColumn;

    public function __construct(string $type, string $columnType)
    {
        $this->dbType = $type;
        $this->columnType = $columnType;
    }


    public function __toString(): string
    {
        return $this->get();
    }

    public function get(): string
    {
        $length = $after = $comment = "";
        $lengthProperty = new ReflectionProperty(CDbMigrationColumn::class, 'length');
        $afterProperty = new ReflectionProperty(CDbMigrationColumn::class, 'after');
        $commentProperty = new ReflectionProperty(CDbMigrationColumn::class, 'comment');

        if ($lengthProperty->isInitialized($this)) {
            $length = "({$this->length})";
        }

        if ($afterProperty->isInitialized($this)) {
            $after = "AFTER `{$this->after}`";
        }

        if ($commentProperty->isInitialized($this)) {
            $comment = "COMMENT '{$this->comment}'";
        }

        return trim("{$this->dbType}{$length} {$this->nullability} {$comment} {$after}");
    }

    public function after(string $after): self
    {
        $this->after = $after;

        return $this;
    }

    public function length(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function nullable(bool $default = true): self
    {
        $this->nullability = $default ? 'NULL' : 'NOT NULL';

        return $this;
    }

    public function comment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function ref(string $ref, string $column = 'id'): self
    {
        $this->refTable = $ref;
        $this->refColumn = $column;
        return $this;
    }

    public function getRefColumn(): string
    {
        return $this->refColumn;
    }

    public function getRefTable(): string
    {
        return $this->refTable;
    }

    public function getColumnType(): string
    {
        return $this->columnType;
    }
}