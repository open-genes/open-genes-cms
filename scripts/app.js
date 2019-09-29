$.fn.toggleClasses = function (class1, class2) {
    if (!class1 || !class2)
        return this;

    return this.each(function () {
        var $elm = $(this);

        if ($elm.hasClass(class1) || $elm.hasClass(class2))
            $elm.toggleClass(class1 + ' ' + class2);
        else
            $elm.addClass(class1);
    });
};

$(function () {
    // DOM ELEMENTS
    const body = document.body;
    const loader = document.getElementById('js_loader');
    const loader_text = document.getElementById('js_loader-text');
    const header_menu = document.getElementsByClassName('js_header-menu')[0];
    const btn_signin = document.getElementsByClassName('js_signin-btn')[0];
    const alert_close = document.getElementsByClassName('js_alert__close')[0];
    const items_section = document.getElementsByClassName('js_items-section')[0];
    const items_view_toggler = document.getElementsByClassName('js_view-toggler')[0];

    // MENUS
    $(btn_signin).on('click', function () {
        $(this).toggleClass('active');
        $(header_menu).toggleClass('hidden');
        $(body).toggleClass('still');
    });

    $(header_menu).on('click', function (event) {
        if (event.target == this) {
            $(this).addClass('hidden');
            $(btn_signin).removeClass('active');
            $(body).removeClass('still');
        }
    });

    //SET LANGUAGE
    $('.js_language-switcher').on('click', function () {
        var language = $(this).attr('value');
        document.cookie = 'lang' + '=' + language;
        location.reload();
    });

    // TOGGLER BUTTONS
    $('.js_toggler').on('click', function (event) {
        event.stopPropagation();
        $(this).toggleClasses('toggler--def', 'toggler--alt');
    });

    $(items_view_toggler).on('click', function (event) {
        $(items_section).toggleClasses('view-content--as-table', 'view-content--as-cards');

    });


    // LOADER
    function hideLoader() {
        $(loader).addClass('hidden');
        loader_text.innerHTML = '';
    }

    function showLoader($text) {
        $(loader).removeClass('hidden');
        loader_text.innerHTML = $text;
    }

    hideLoader();

    setTimeout(function () {
        $('.alert').remove();
    }, 10000);

    $(alert_close).click(function () {
        $(this).parent().remove();
    });


    // NAVIGATION
    function nav(link_href) {
        if(window.location.pathname) {
            var path_value = window.location.pathname;

            console.log(path_value);

            $('.js_nav_link').each(function() {
                var href = $(this).attr('href');
                if (href == path_value) {
                    $(this).addClass('current');
                }
                else if (href == link_href) {
                    $(this).addClass('current');
                }
                else {
                    $(this).removeClass('current');
                }
            });

        } else {
            $('.js_nav_link').removeClass('current');
        }
    }


    $('.js_nav_link').click(function() {
        $('.js_nav_link').removeClass('current');
        $(this).addClass('current');
    });
    $('.js_link').click(function() {
        var link_href = $(this).attr('href');
        nav(link_href);
    });

    nav();
});