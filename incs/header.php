<?php

$styles = $args['styles'] ?? [];
$scripts = $args['scripts'] ?? [];
$headerMenuItems = buildMenuTree(wp_get_nav_menu_items(2), get_the_ID());

global $options;

?>

<!DOCTYPE html>
<html lang="ru">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= wp_title() ?></title>

        <?php foreach ($styles as $style): ?>
            <link rel="stylesheet" href="<?= $style ?>">
        <?php endforeach ?>

        <?php foreach ($scripts as $script): ?>
            <script src="<?= $script ?>" defer async></script>
        <?php endforeach ?>

        <?php wp_head(); ?>
    </head>

    <body>
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (m, e, t, r, i, k, a) {
                m[i] = m[i] || function () { (m[i].a = m[i].a || []).push(arguments) };
                m[i].l = 1 * new Date();
                for (var j = 0; j < document.scripts.length; j++) { if (document.scripts[j].src === r) { return; } }
                k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
            })
                (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym(93280561, "init", {
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true,
                webvisor: true
            });
        </script>
        <noscript>
            <div><img src="https://mc.yandex.ru/watch/93280561" style="position:absolute; left:-9999px;" alt="" /></div>
        </noscript>
        <!-- /Yandex.Metrika counter -->

        <header class="header">
            <div class="header__inner container">
                <a href="<?= home_url('/') ?>" class="header__logo-link">
                    <img width="80" height="62" class="header__logo-image" src="<?= $options->logoImageUrl ?>"
                         alt="<?= wp_title() ?>" decoding="async">
                </a>
                <dialog class="header__overlay js-overlay">
                    <nav class="header__menu">
                        <ul class="header__menu-list">
                            <?php foreach ($headerMenuItems as $item): ?>
                                <li class="header__menu-item <?= $item->childs ? 'toggle-container' : '' ?>">
                                    <?php if ($item->childs): ?>
                                        <span class="header__menu-link <?= $item->is_active ? 'is-active' : '' ?>">
                                            <a class="header__menu-link <?= $item->is_active ? 'is-active' : '' ?>"
                                               href="<?= $item->url ?: '#' ?>"><?= $item->title ?></a>
                                            <button type="button" class="header__menu-button toggle-button">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewbox="0 -960 960 960"
                                                     width="24px" fill="currentColor">
                                                    <path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z" />
                                                </svg>
                                            </button>

                                        </span>
                                        <ul class="header__menu-sublist toggle-target">
                                            <?php foreach ($item->childs as $child): ?>

                                                <li class="header__menu-item">
                                                    <a href="<?= $child->url ?>"
                                                       class="header__menu-link <?= $child->is_active ? 'is-active' : '' ?>">
                                                        <?= $child->title ?>
                                                    </a>
                                                </li>

                                            <?php endforeach ?>
                                        </ul>
                                    <?php else: ?>
                                        <a href="<?= $item->url ?>"
                                           class="header__menu-link <?= $item->is_active ? 'is-active' : '' ?>"><?= $item->title ?></a>
                                    <?php endif ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                        <img class="header__menu-image visible-tablet"
                             src="<?= assets('images/header-menu-image.png') ?>" width="176" height="160" />
                        <a href="tel:<?= $options->phoneNumbers ?>" class="button visible-tablet">
                            Позвонить
                        </a>
                    </nav>
                </dialog>
                <button type="button" class="header__burger-button burger-button visible-tablet js-burger-button"
                        aria-label="Открыть меню" title="Открыть меню">
                    <svg class="burger-button__svg" width="44" height="44" viewbox="0 0 100 100">
                        <path class="burger-button__line burger-button__line--1"
                              d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
                        <path class="burger-button__line burger-button__line--2" d="M 20,50 H 80" />
                        <path class="burger-button__line burger-button__line--3"
                              d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942">
                        </path>
                    </svg>
                </button>
            </div>
        </header>
