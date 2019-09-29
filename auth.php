<?
if ($_POST) {
    $authUser = trim($_POST['user']);
    $authPassword = trim($_POST['password']);

    if ($authUser == 'admin' && $authPassword == 'KGuUc7Od') {
        $isAuth = 1;
        // TODO: Auth query to CMS should be here

        if (isset($_GET['logout'])) {
            if ($_GET['logout'] == 1) {
                session_unset();
            }
        }
    }
    else {
        header('Location: /?err_logout=1');
    }
} else {
    header('Location: /?err_signin=1');
}
?>