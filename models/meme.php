<?php 
class MemeModel extends Model{
    public function index(){
        $this->query('SELECT U.name as author_name, M.id as id, user_id, title, path, added_at FROM `memes` M
        JOIN users U ON U.id = M.user_id ORDER BY added_at DESC');
        $this->execute();
        $rows = $this->resultSetAll();
        return $rows;
    }
    private function addActivityLog($action, $meme_id){
        $this->query('SELECT M.user_id FROM memes M
                    JOIN users U ON U.id = M.user_id
                    WHERE M.id = :meme_id');
        $this->bind(':meme_id', $meme_id);
        $this->execute();
        $meme_author = ($this->resultSetSingle())['user_id'];

        $this->query('INSERT INTO users_activity(user_id, action, meme_id, meme_author) VALUES(:user_id, :action, :meme_id, :meme_author)');
        $this->bind(':user_id', $_SESSION['user_data']['id']);
        $this->bind(':action', $action);
        $this->bind(':meme_id', $meme_id);
        $this->bind(':meme_author', $meme_author);
        $this->execute();
    }

    private function addComment($meme_id){#-----------------------------------------------------------------czy powinienem tak przypisywać $this do $that ??
        $addComment = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if(isset($addComment['submit']) && isset($_SESSION['is_logged_in']) && $_SESSION['user_data']['is_verified'] == true){         
            $this->query('INSERT INTO comments(user_id, body, meme_id) VALUES(:user_id, :body, :meme_id)');
            $this->bind(':user_id', $_SESSION['user_data']['id']);
            $this->bind(':body', $addComment['body']);
            $this->bind(':meme_id', $meme_id);
            $this->execute();
            
            if($this->lastInsertId()){
                $this->addActivityLog('dodał/a komentarz do ', $meme_id);
                Messages::setMsg('Komentarz dodany pomyślnie!', 'success');
            }else{
                Messages::setMsg('Komentarz nie został dodany, spróbuj ponownie później!', 'error');
            }
        }elseif(isset($addComment['submit']) && (!isset($_SESSION['is_logged_in']) || $_SESSION['user_data']['is_verified'] == false)){
            Messages::setMsg('Musisz mieć zweryfikowane konto aby móc dodać komentarz!', 'error');
        }
    }

    public function add(){
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if(isset($post['submit'])){
            $path = $_FILES['image']['name'];
            $uploadFile = MEMES_PATH.'/'.basename($_FILES['image']['name']);

            if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)){
                    $this->query("INSERT INTO memes(user_id, title, path) VALUES(:user_id, :title, :path)");
                    $this->bind(':user_id', $_SESSION['user_data']['id']);
                    $this->bind(':title', $post['title']);
                    $this->bind(':path', $path);
                    $this->execute();

                if($this->lastInsertId()){
                    $this->addActivityLog('dodał/a ', $this->lastInsertId());

                    Messages::setMsg('Mem został dodany pomyślnie', 'success');
                    $this->query("UPDATE users SET points = points+1 WHERE id = :user_id");
                    $this->bind(':user_id', $_SESSION['user_data']['id']);
                    $this->execute();
                    exit(header('Location: '.ROOT_PATH.'/memes'));
                }else{
                    Messages::setMsg('Nie udało się dodać wpisu w bazie', 'error');
                }
            }else{
                Messages::setMsg('Mem nie został dodany, spróbuj ponownie później', 'error');
            }
        }
    }
    public function show($meme_id){

        // function addComment($that, $meme_id){#-----------------------------------------------------------------czy powinienem tak przypisywać $this do $that ??
        //     $addComment = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        //     if(isset($addComment['submit']) && isset($_SESSION['is_logged_in']) && $_SESSION['user_data']['is_verified'] == true){         
        //         $that->query('INSERT INTO comments(user_id, body, meme_id) VALUES(:user_id, :body, :meme_id)');
        //         $that->bind(':user_id', $_SESSION['user_data']['id']);
        //         $that->bind(':body', $addComment['body']);
        //         $that->bind(':meme_id', $meme_id);
        //         $that->execute();
                
        //         if($that->lastInsertId()){
        //             $that->addActivityLog('dodał/a komentarz do ', $that->lastInsertId());
        //             Messages::setMsg('Komentarz dodany pomyślnie!', 'success');
        //         }else{
        //             Messages::setMsg('Komentarz nie został dodany, spróbuj ponownie później!', 'error');
        //         }
        //     }elseif(isset($addComment['submit']) && (!isset($_SESSION['is_logged_in']) || $_SESSION['user_data']['is_verified'] == false)){
        //         Messages::setMsg('Musisz mieć zweryfikowane konto aby móc dodać komentarz!', 'error');
        //     }
        // }

        $this->query('SELECT U.id as author_id, U.avatar, U.points, U.name as author_name, M.id as id, user_id, title, path, added_at FROM `memes` M
        JOIN users U ON U.id = M.user_id WHERE M.id = :post_id');
        $this->bind(':post_id', $meme_id);
        $this->execute();
        $meme = $this->resultSetSingle();

        $this->addComment($meme_id);

        $this->query("SELECT C.id, C.body, C.created_at, U.name, U.avatar FROM `comments` C 
                    JOIN users U ON U.id = C.user_id
                    JOIN memes M ON M.id = C.meme_id
                    WHERE M.id = :meme_id
                    ORDER BY created_at DESC");
        $this->bind('meme_id', $meme_id);
        $this->execute();
        $comments = $this->resultSetAll();

        $results = array('meme' => $meme, 'comments' => $comments);
        $addComment['submit']= NULL;
        return $results;
    }
}
?>