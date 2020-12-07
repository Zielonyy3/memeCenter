<?php

abstract class Model
{
    protected $dbh;
    protected $stmt;

    public function __construct()
    {
        $this->dbh = new PDO("mysql:host=" . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    }

    public function query(string $query): void
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null): void
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute(): void
    {
        $this->stmt->execute();
    }

    public function resultSetAll(): array
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function resultSetSingle(): array
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function lastInsertId(): string
    {
        ;
        return $this->dbh->lastInsertId();
    }

    protected function time_elapsed_string(string $datetime, bool $full = false): string
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $textEnd = [
            'y' => 'lat',
            'm' => 'miesięcy',
            'w' => 'tygodni',
            'd' => 'dni',
            'h' => 'godzin',
            'i' => 'minut',
            's' => 'sekund',
        ];
        foreach ($textEnd as $key => &$val) {
            if ($diff->$key && $key !== 's') {
                $val = $diff->$key . ' ' . $val;
            } else {
                unset($textEnd[$key]);
            }
        }

        if (!$full) {
            $textEnd = array_slice($textEnd, 0, 1);
        }
        return $textEnd ? implode(', ', $textEnd) . ' temu' : 'teraz';
    }
}

?>