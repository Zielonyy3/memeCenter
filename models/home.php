<?php

class HomeModel extends Model
{
    public function Index(): array
    {
        $this->query('SELECT U.name as author_name, M.id as id, user_id, title, path, added_at FROM `memes` M
        JOIN users U ON U.id = M.user_id ORDER BY added_at DESC LIMIT 4');
        $this->execute();
        $rows = $this->resultSetAll();
        foreach ($rows as &$row) {
            $row['added_at'] = $this->time_elapsed_string($row['added_at']);
        }
        return $rows;
    }
}

?>