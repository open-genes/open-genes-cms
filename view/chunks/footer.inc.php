<footer class="wrapper footer">
    <div class="container">
        <div class="per per-70">
            <a href="/export"
               class="link"
               target="_blank"
            ><?= $translation->translate('footer_json_data') ?></a>
            <a href="/export.json"
               class="fa far fa-download"
               target="_blank"
            ></a>
        </div>
        <div class="per per-30 footer__language">
            <button
                value="<?= $_SESSION['$alternative_locale'] ?>"
                class="language-switcher js_language-switcher">
                <?= $_SESSION['$current_locale'] ?>
            </button>
        </div>
    </div>
</footer>