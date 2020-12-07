<?php

class Messages
{
    public static function setMsg(string $text, string $type): void
    {
        if ($type == 'error') {
            $_SESSION['errorMsg'] = $text;
        } else {
            $_SESSION['successMsg'] = $text;
        }
    }

    public static function display(): void
    {
        if (isset($_SESSION['errorMsg'])) {
            echo '<div class="container login-info top-pad">
            <div class="alert alert-danger">' . $_SESSION['errorMsg'] . '</div>
            </div>';
            unset($_SESSION['errorMsg']);
        }

        if (isset($_SESSION['successMsg'])) {
            echo '<div class="container login-info">
            <div class="alert alert-success login-info">' . $_SESSION['successMsg'] . '</div>
            </div>';
            unset($_SESSION['successMsg']);
        }
    }
}

?>