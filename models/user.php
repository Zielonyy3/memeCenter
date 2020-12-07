<?php

class UserModel extends Model
{
    public function index(): array
    {
        $this->query('SELECT * FROM users ORDER BY points DESC');
        $this->execute();
        $rows = $this->resultSetAll();
        return $rows;
    }

    private function setUserSession(array $user): bool
    {
        if ($user) {
            $_SESSION['is_logged_in'] = true;
            $_SESSION['user_data'] = array(
                "id" => $user['id'],
                'name' => $user['name'],
                'mail' => $user['mail'],
                'is_verified' => $user['is_verified'],
                'points' => $user['points'],
            );
            return true;
        } else {
            return false;
        }
    }

    public function login(): void
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($post['submit'])) {
            $password = md5($post['password']);

            $this->query("SELECT * FROM users WHERE name=:name AND password=:password");
            $this->bind(':name', $post['name']);
            $this->bind(':password', $password);
            $user = $this->resultSetSingle();
            if ($this->setUserSession($user)) {
                Messages::setMsg('Logowanie udane!', 'success');
                exit(header('Location: ' . ROOT_PATH));
            } else {
                Messages::setMsg('Logowanie nie powiodło się!', 'error');
            }
        }
    }

    private function isAvailableName(string $name,string $mail): bool
    {
        $this->query("SELECT * FROM users WHERE name = :name OR mail = :mail");
        $this->bind(':name', $name);
        $this->bind(':mail', $mail);
        $this->execute();
        $user = $this->resultSetSingle();
        if (!isset($user['id'])) {
            return true;
        } else {
            return false;
        }
    }

    private function sendVerifyMail(string $to_mail, string $verify_code, string $expirationDate): void
    {
        $subject = "MEME CENTER - Kod Weryfikacyjny";
        $headers = "From: meme.center@yandex.com" . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'Reply-To: user@example.com' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();

        $body = '<td>
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td width="560" valign="top">
                                <table style="border-radius: 0px; border-collapse: separate;" width="100%" cellspacing="0"
                                    cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h1 style="margin-bottom: 0;">Dzięki za utworzenie konta!</h1>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="color: #333333;">Otrzymałeś ten mail ponieważ zarejestrowałeś się na
                                                    stronie meme center. Poniżej znajduje się twój kod weryfikacyjny ważny do <b>' . $expirationDate . '</b>.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="display: inline-block;background-color: #fbcc20;padding: .6rem 1rem;font-size: 1.2rem;">' . $verify_code . '</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>';

        if (mail($to_mail, $subject, $body, $headers)) {
            echo 'Mail wysłany';
        } else {
            echo 'Mail nie został wysłany...';
        }
    }

    public function register(): void
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if (isset($post['submit'])) {
            $password = md5($post['password']);
            if ($this->isAvailableName($post['name'], $post['mail'])) {
                $this->query("INSERT INTO users(name, mail, password) VALUES(:name, :mail, :password)");
                $this->bind(':name', $post['name']);
                $this->bind(':mail', $post['mail']);
                $this->bind(':password', $password);
                $this->execute();

                if ($this->lastInsertId()) {
                    $_SESSION["created_user_id"] = $this->lastInsertId();

                    $this->query("SELECT * FROM users WHERE id=:user_id");
                    $this->bind(':user_id', $this->lastInsertId());
                    $user = $this->resultSetSingle();

                    $this->setUserSession($user);

                    exit(header('Location: ' . ROOT_PATH . 'users/verify'));
                }
            } else {
                Messages::setMsg('Takie konto już istnieje!', 'error');
            }
        }
    }

    private function generateAndSendCode(string $to_mail): void
    {
        $random_code = substr(md5(uniqid(rand(), true)), 7, 7);

        $currentDateTime = new DateTime('now');
        $currentDateTime->add(new DateInterval('PT30M'));
        $expirationDate = date_format($currentDateTime, 'Y-m-d H:i:s');

        $this->query('SELECT * FROM  verification_codes WHERE user_id = :user_id');
        $this->bind(':user_id', $_SESSION['user_data']['id']);
        $this->execute();

        if ($this->resultSetSingle()) {
            $this->query('UPDATE verification_codes SET code = :code, expiration_date = :expiration_date');
            $this->bind(':code', $random_code);
            $this->bind(':expiration_date', $expirationDate);
            $this->execute();
        } else {
            $this->query('INSERT INTO verification_codes(user_id, code, expiration_date) VALUES(:user_id, :code, :expiration_date)');
            $this->bind(':user_id', $_SESSION['user_data']['id']);
            $this->bind(':code', $random_code);
            $this->bind(':expiration_date', $expirationDate);
            $this->execute();
        }
        $this->sendVerifyMail($to_mail, $random_code, $expirationDate);
    }

    public function verify(): void
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($post['submitVerifyCode'])) {
            $this->query('SELECT * FROM verification_codes WHERE user_id = :user_id');
            $this->bind(':user_id', $_SESSION['user_data']['id']);
            $this->execute();
            $code = $this->resultSetSingle();

            if (strtotime((new DateTime())->format("Y-m-d H:i:s")) > strtotime($code['expiration_date'])) {
                Messages::setMsg('Ten kod już wygasł!', 'error');
            } else {
                if ($post['code'] == $code['code']) {
                    $this->query('UPDATE users SET is_verified = true WHERE id = :user_id');
                    $this->bind(':user_id', $_SESSION['user_data']['id']);
                    $this->execute();

                    $_SESSION['user_data']['is_verified'] = true;

                    Messages::setMsg('Twoje konto zostało zweryfikowane', 'success');
                    exit(header('Location: ' . ROOT_PATH));
                } else {
                    Messages::setMsg('Kod nieprawidłowy! Spróbuj ponownie lub wyślij wiadomość jeszcze raz', 'error');
                    exit(header('Location: ' . ROOT_PATH . 'users/verify'));
                }
            }
        } else {
            $this->generateAndSendCode($_SESSION['user_data']['mail']);
        }
    }

    public function remindPassword(): string
    {
        return 'Ups! Jeszcze tutaj nic nie ma.';
    }

    private function changeAvatar(): void
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if (isset($post['changeAvatar']) && isset($_SESSION['is_logged_in'])) {
            $avatar = $_FILES['avatar']['name'];
            $uploadFile = AVATARS_REAL_PATH . basename($avatar);

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
                $this->query("UPDATE users SET avatar = :avatar WHERE id = :user_id");
                $this->bind(':avatar', $avatar);
                $this->bind(':user_id', $_SESSION['user_data']['id']);
                $this->execute();

                Messages::setMsg('Avatar został zmieniony', 'success');
                exit(header('Location: ' . ROOT_PATH . '/users/show/' . $_SESSION['user_data']['name']));
            } else {
                Messages::setMsg('Nie udało się wysłać pliku! Spróbuj ponownie później', 'error');
            }
        }
    }

    private function changeName(): void
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if (isset($post['changeName']) && isset($_SESSION['is_logged_in'])) {
            $this->query("UPDATE users SET name = :name WHERE id = :user_id");
            $this->bind(':name', $post['name']);
            $this->bind(':user_id', $_SESSION['user_data']['id']);
            $this->execute();

            Messages::setMsg('Nazwa została zmieniony', 'success');
            exit(header('Location: ' . ROOT_PATH . '/users/show/' . $post['name']));
        }
    }


    private function changeMail(): void
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if (isset($post['changeMail']) && isset($_SESSION['is_logged_in'])) {
            $this->query("UPDATE users SET mail = :mail WHERE id = :user_id");
            $this->bind(':name', $post['mail']);
            $this->bind(':user_id', $_SESSION['user_data']['id']);
            $this->execute();

            Messages::setMsg('Mail został zmieniony', 'success');
            exit(header('Location: ' . ROOT_PATH . '/users/show/' . $_SESSION['user_data']['name']));
        }
    }

    public function show(string $userName): array
    {
        $this->changeAvatar();
        $this->changeName();
        $this->changeMail();


        $this->query('SELECT `id`, `name`,`avatar`,`mail`,CAST(`join_date` as date) as join_date,`points` FROM users WHERE name = :userName');
        $this->bind(':userName', $userName);
        $this->execute();
        $user = $this->resultSetSingle();

        $this->query('SELECT * from memes WHERE user_id = :userId ORDER BY added_at DESC');
        $this->bind(':userId', $user['id']);
        $this->execute();
        $memes = $this->resultSetAll();

        $this->query('SELECT U.name, UA.action, UA.meme_id, UA.created_at FROM `users_activity` UA 
                        JOIN users U on U.id = UA.user_id 
                        WHERE user_id = :userId or meme_author = :userId2
                        ORDER BY created_at DESC LIMIT 7');
        $this->bind(':userId', $user['id']);
        $this->bind(':userId2', $user['id']);
        $this->execute();
        $activities = $this->resultSetAll();
        $result = ['user' => $user, 'memes' => $memes, 'activities' => $activities];

        foreach ($result['activities'] as &$activity) {
            $activity['created_at'] = $this->time_elapsed_string($activity['created_at']);
        }
        return $result;
    }

}

?>