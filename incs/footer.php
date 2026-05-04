<?php

$_modals = $args['_modals'] ?? [];
$footerMenuItems = buildMenuTree(wp_get_nav_menu_items(4), get_the_ID());

global $options;

?>

<footer class="footer">
    <div class="footer__inner container">
        <div class="footer__map-wrapper">
            <h2 class="footer__title section-title h1">
                МЫ НАХОДИМСЯ
            </h2>
            <div class="footer__address">
                <?= $options->address ?>
            </div>
            <div class="footer__map">
                <?= $options->map ?>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="footer__contacts">
                <a href="<?= home_url('/') ?>" class="footer__contacts-home-link">
                    <img class="footer__contacts-image" src="<?= $options->logoImageUrl ?>" width="191" height="174">
                </a>
                <strong>
                    <a class="footer__contacts-link" href="tel:<?= $options->phoneNumbers ?>"><?= $options->phone ?></a>
                </strong>
                <strong>
                    <a class="footer__contacts-link" href="mailto:<?= $options->email ?>"><?= $options->email ?></a>
                </strong>
                <p>
                    <?= $options->address ?>
                </p>
            </div>
            <nav class="footer__menu">
                <div class="footer__menu-list">
                    <?php foreach ($footerMenuItems as $item): ?>

                        <a href="<?= $item->url ?>" class="footer__menu-link button">
                            <?= $item->title ?>
                        </a>

                    <?php endforeach ?>
                </div>
                <div class="footer__reqs">
                    <?= $options->reqs ?>
                </div>
            </nav>
        </div>
    </div>
    <div class="footer__camp">
        <a title="Наш лагерь на портале лагерей" aria-label="Наш лагерь на портале лагерей"
           href="https://kidsincamp.ru/camp/supermom" target="_blank" class="footer__camp-link">
            <img width="50" height="50" src="<?= assets('images/camp-logo.jpeg') ?>" alt="" class="footer__camp-logo">
        </a>
        <a href="https://kidsincamp.ru/camp/supermom" target="_blank" class="footer__camp-link">
            Наш лагерь на
            <br>
            портале лагерей
        </a>
    </div>

</footer>

<button data-_modal="#gift-_modal" type="button" class="fixed-button button button--blue">
    <span>
        <img src="<?= assets('images/logo.png') ?>" width="50" height="38" alt="">
    </span>
    <span>
        Записаться на занятие
    </span>
</button>

<dialog class="_modal order-_modal" id="order-_modal">
    <div class="_modal__wrapper order-_modal__wrapper">
        <div class="order-_modal__logo">
            <img class="order-_modal__logo-image" src="<?= $options->logoImageUrl ?>" width="175" height="136" alt="">
        </div>

        <form action="<?= admin_url('admin-ajax.php') ?>" method="POST" class="order-_modal__form order-form">
            <input type="hidden" name="action" value="send_order">
            <div class="order-form__control">
                <label for="child-name" class="order-form__label">
                    ФИ ребенка *
                </label>
                <input aria-errormessage="child-name-error" type="text" minlength="2" required id="child-name"
                       name="child_name" class="order-form__input">
                <div class="order-_modal__error-message error-message" id="child-name-error"></div>
            </div>
            <div class="order-form__control">
                <label for="child-birthday" class="order-form__label">
                    Дата рождения ребенка *
                </label>
                <input aria-errormessage="child-birthday-error" type="text" required id="child-birthday"
                       pattern="^(0[1-9]|[12][0-9]|3[01])\.(0[1-9]|1[012])\.(19|20)\d\d$" name="child_birthday"
                       class="order-form__input">
                <div class="order-_modal__error-message error-message" id="child-birthday-error"></div>
            </div>
            <div class="order-form__control">
                <label for="mother-name" class="order-form__label">
                    Имя мамы *
                </label>
                <input aria-errormessage="mother-name-error" type="text" minlength="2" required id="mother-name"
                       name="mother_name" class="order-form__input">
                <div class="order-_modal__error-message error-message" id="mother-name-error"></div>
            </div>
            <div class="order-form__control">
                <label for="phone" class="order-form__label">
                    Контактный телефон *
                </label>
                <input placeholder="+7 (___) ___-__-__" aria-errormessage="phone-error" type="text" required
                       pattern="^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$" id="phone" name="phone" class="order-form__input">
                <div class="order-_modal__error-message error-message" id="phone-error"></div>
            </div>
            <div class="order-form__control">
                <label class="order-form__label order-form__label--checkbox">
                    <input aria-errormessage="agree-error" type="checkbox" required id="agree" name="agree"
                           class="order-form__input order-form__input--checkbox">
                    <span>
                        Я согласен на обработку и хранение моих персональных данных, в целях обратной связи
                    </span>
                </label>
                <div class="order-_modal__error-message error-message" id="agree-error">
                </div>
            </div>
            <button type="submit" class="order-_modal__submit-button button">
                Отправить
            </button>
        </form>

        <button type="button" class="_modal__close-button order-_modal__close-button">
            <svg xmlns="http://www.w3.org/2000/svg" height="44px" viewBox="0 -960 960 960" width="44px"
                 fill="currentColor">
                <path
                      d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
            </svg>

        </button>
    </div>
</dialog>

<dialog class="_modal gift-_modal" id="gift-_modal">
    <div class="_modal__wrapper">

        <div class="gift-_modal__body">
            <div class="gift-_modal__image">
                <div class="gift-_modal__info">
                    Получите пробный урок в подарок
                </div>
            </div>
            <form action="<?= admin_url('admin-ajax.php') ?>" method="POST" class="gift-_modal__form">
                <input type="hidden" name="action" value="send_gift">
                <div class="gift-_modal__title">
                    Чтобы получить подарок, заполните поля ниже и нажмите на кнопку «Записаться»
                </div>
                <div class="gift-_modal__control">
                    <label for="child-age" class="visually-hidden">Возраст ребёнка</label>
                    <input pattern="\d+" class="gift-_modal__input" type="text" required name="child_age" id="child-age"
                           placeholder="Возраст ребёнка" aria-errormessage="child-age-error">
                    <div class="error-message" id="child-age-error"></div>
                </div>
                <div class="gift-_modal__control">
                    <label for="gift-name" class="visually-hidden">Ваше имя</label>
                    <input class="gift-_modal__input" type="text" minlength="2" required name="gift_name" id="gift-name"
                           placeholder="Ваше имя" aria-errormessage="gift-name-error">
                    <div class="error-message" id="gift-name-error"></div>
                </div>
                <div class="gift-_modal__control">
                    <label for="gift-phone" class="visually-hidden">Номер телефона</label>
                    <input class="gift-_modal__input" type="text" required name="gift_phone" id="gift-phone"
                           placeholder="Номер телефона" pattern="^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$"
                           aria-errormessage="gift-phone-error">
                    <div class="error-message" id="gift-phone-error"></div>
                </div>
                <button type="submit" class="gift-_modal__button button button--flat">
                    Записаться
                </button>
                <div class="gift-_modal__agree">
                    Нажимая на кнопку, вы даёте согласие на обработку персональных данных
                </div>
            </form>
        </div>

        <button type="button" class="_modal__close-button yt-_modal__close-button">
            <svg xmlns="http://www.w3.org/2000/svg" height="44px" viewBox="0 -960 960 960" width="44px"
                 fill="currentColor">
                <path
                      d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
            </svg>
        </button>
    </div>
</dialog>

<?php foreach ($_modals as $_modal): ?>

    <?= get_template_part("incs/_modals/$_modal") ?>

<?php endforeach ?>

<?php wp_footer() ?>

<script type="module" src="<?= assets('scripts/main.js') ?>"></script>
</body>

</html>
