<header class="header">
    <a class="header__logo"
       href="/"
       title="<?= $translation->translate('main_page_link') ?>">
    </a>


    <? if ($isAuth == 0): ?>
        <div class="header__signin">
            <button
                value="<?= $_SESSION['$alternative_locale'] ?>"
                class="language-switcher js_language-switcher">
                <?= $_SESSION['$current_locale'] ?>
            </button>

            <div class="signin__button js_signin-btn">
                <span class="fa far fa-bars"></span>
            </div>

            <div class="header__menu js_header-menu hidden">
                <div class="menu__panel">
                    <form method="post" action="/auth">
                        <div class="ui-row ui-row--v">
                            <input type="text"
                                   name="user"
                                   placeholder="<?= $translation->translate('header_menu_username')?>"
                                   class="field"
                            >
                            <input type="password"
                                   name="password"
                                   placeholder="<?= $translation->translate('header_menu_password')?>"
                                   class="field"
                            >
                        </div>
                        <div class="ui-row ui-row--v">
                            <button type="submit"
                                    value="submit"
                                    class="btn btn-fill btn--big btn-purple"
                            >
                                <?= $translation->translate('header_menu_sign_in')?>
                            </button>
                            <input type="reset"
                                   name="reset"
                                   value="clear"
                                   class="hidden"
                            >
                        </div>
                    </form>

                    <ul class="menu__links">
                        <? $menuLinks = array (
                            1  => array(
                                'URL' => 'about',
                                'title' => $translation->translate('header_menu_about')
                            ),

                            2  => array(
                                'URL' => 'api-reference',
                                'title' => $translation->translate('header_menu_api')
                            )

                        ) ?>
                        <? foreach($menuLinks as $menuLink): ?>
                        <li class="menu__link">
                            <a href="/<?= $menuLink['URL'] ?>"
                               class="js_nav_link"
                            >
                                <?= $menuLink['title'] ?>
                            </a>
                        </li>
                        <? endforeach; ?>
                    </ul>
                </div>
            </div>

        <? else: ?>
            <form class="header__signin"
                  method="post"
                  action="/manage?logout=1"
            >
                <button class="signin__button icon-btn" type="submit">
                    <span class="fa far fa-sign-out"></span>
                </button>
            </form>
        <? endif; ?>
</header>

<?
$errors = new alertMessages();
$alert_error_invalid_username = (string) $translation->translate('alert_error_invalid_username');
$alert_error_login_unsuccessful = (string) $translation->translate('alert_error_login_unsuccessful');

$errors->pop_alert('err_logout', 1, $alert_error_invalid_username);
$errors->pop_alert('err_signin', 1, $alert_error_login_unsuccessful);
?>