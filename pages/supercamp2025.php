<?php

// Template Name: SuperCamp2025

?>

<!doctype html>
<html lang="ru">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SUPER CAMP 2024</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
              crossorigin="anonymous">
        <base href="<?= get_template_directory_uri() . '/pages/supercamp2025/' ?>">
        <link href="./css/camp.css?v=1" rel="stylesheet">
        <link href="<?= get_template_directory_uri() ?>/css/style.css" rel="stylesheet">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
    </head>

    <body class="bg">
        <nav class="navbar navbar-dark navbar-expand-lg nav-bg">
            <div class="container-fluid">
                <a class="navbar-brand" href="/"><img
                         src="<?= get_template_directory_uri() ?>/images/logowhitebackground-.png" class="img-fluid"
                         style="max-width: 115px;" />
                </a>
                <a href="<?= get_permalink(371) ?>" class="nav-link nav-item camp-link">
                    ← ГОРОДСКОЙ CAMP
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= get_permalink() ?>#program">Программа</a>
                        </li>
                        <?php if (get_field('location-toggle')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= get_permalink() ?>#location">Локация</a>
                            </li>
                        <?php endif ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= get_permalink() ?>#shifts">Смены</a>
                        </li>
                        <?php if (get_field('info2-toggle')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= get_permalink() ?>#more">Плюшки</a>
                            </li>
                        <?php endif ?>
                        <div class="p-1"></div>
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#bookModal">
                            Забронировать
                        </button>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container text-center">
            <div class="row align-items-center mt-4">
                <div class="col">
                    <h1>
                        <?= get_field('title') ?>
                    </h1>
                    <p class="text-center">
                        <?= get_field('description') ?>
                    </p>
                </div>

                <section id="headliner" class="mt-3">
                    <h3 class="purple-bg">
                        <?= get_field('banner-title') ?>
                    </h3>

                    <?php if (get_field('banner-content-type') === 'Изображение'): ?>
                        <img src="<?= get_field('banner-image') ?>" width="100%">
                    <?php elseif (get_field('banner-content-type') === 'Видео'): ?>
                        <?= get_field('banner-video') ?>
                    <?php endif ?>

                </section>
            </div>

            <section id="program" class="mb-5">

                <h2 class="section-title">
                    <?= get_field('info-title') ?>
                </h2>
                <div class="row">
                    <div class="col-12 col-lg-7">
                        <?= get_field('info-content') ?>
                    </div>
                    <div class="col-5 d-none d-lg-block">

                        <img src="<?= get_field('info-images')[0] ?>" id="soap">
                    </div>
                </div>
                <div class="row">
                    <div class="col d-none d-lg-block">
                        <img src="<?= get_field('info-images')[1] ?>" id="sport1">
                    </div>
                    <div class="col d-none d-lg-block">
                        <img src="<?= get_field('info-images')[2] ?>" id="lesson">
                    </div>
                    <div class="col d-none d-lg-block">
                        <img src="<?= get_field('info-images')[3] ?>" id="sport2">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-block d-lg-none">
                        <div id="carouselExampleControls" class="carousel slide px-3" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach (get_field('info-images') as $key => $image): ?>

                                    <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                                        <img src="<?= $image ?>" class="d-block w-100">
                                    </div>

                                <?php endforeach ?>
                            </div>
                            <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <?php if (get_field('info-add')): ?>
                        <div class="col-10 offset-1 mt-4">
                            <div class="alert alert-light">
                                <?= get_field('info-add') ?>
                            </div>
                        </div>
                    <?php endif ?>

                </div>

            </section>
        </div>

        <?php if (get_field('location-toggle')): ?>

            <section>
                <div class="waves-top">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 84.94" preserveAspectRatio="none">
                        <path d="M0,0V72.94c14.46,5.89,32.38,10.5,54.52.26,110.25-51,120.51,23.71,192.6-4.3,144.73-56.23,154.37,49.44,246.71,4.64C637,4.05,622.19,124.16,757.29,66.21c93-39.91,108.38,54.92,242.71-8.25V0Z"
                              style="fill-rule:evenodd;opacity:0.33"></path>
                        <path d="M0,0V52.83c131.11,59.9,147-32.91,239.24,6.65,135.09,58,120.24-62.16,263.46,7.34,92.33,44.8,102-60.88,246.71-4.64,72.1,28,82.35-46.71,192.6,4.3,23.95,11.08,43,4.78,58-1.72V0Z"
                              style="fill-rule:evenodd;opacity:0.66"></path>
                        <path d="M0,0V24.26c15.6,6.95,35.77,15.41,61.78,3.38,110.25-51,120.51,23.71,192.6-4.3C399.11-32.89,408.75,72.79,501.08,28,644.3-41.51,629.45,78.6,764.54,20.65,855.87-18.53,872.34,72.12,1000,15.7V0Z"
                              style="fill-rule:evenodd"></path>
                    </svg>
                </div>
            </section>
            <section id="location">
                <h2><?= get_field('location-title') ?></h2>
                <div class="container">
                    <?= get_field('location-description') ?>

                    <div class="row">

                        <?php foreach (get_field('location-images') as $image): ?>

                            <div class="col-12 col-md-6 col-xl-3">
                                <img src="<?= $image ?>">
                            </div>

                        <?php endforeach ?>

                        <?php if (get_field('location-info')): ?>

                            <div class="col-10 offset-1 mt-4">
                                <div class="alert alert-light"><?= get_field('location-info') ?></div>
                            </div>

                        <?php endif ?>

                    </div>

                </div>
            </section>
            <section>
                <div class="waves-bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 84.94" preserveAspectRatio="none">
                        <path d="M0,0V72.94c14.46,5.89,32.38,10.5,54.52.26,110.25-51,120.51,23.71,192.6-4.3,144.73-56.23,154.37,49.44,246.71,4.64C637,4.05,622.19,124.16,757.29,66.21c93-39.91,108.38,54.92,242.71-8.25V0Z"
                              style="fill-rule:evenodd;opacity:0.33"></path>
                        <path d="M0,0V52.83c131.11,59.9,147-32.91,239.24,6.65,135.09,58,120.24-62.16,263.46,7.34,92.33,44.8,102-60.88,246.71-4.64,72.1,28,82.35-46.71,192.6,4.3,23.95,11.08,43,4.78,58-1.72V0Z"
                              style="fill-rule:evenodd;opacity:0.66"></path>
                        <path d="M0,0V24.26c15.6,6.95,35.77,15.41,61.78,3.38,110.25-51,120.51,23.71,192.6-4.3C399.11-32.89,408.75,72.79,501.08,28,644.3-41.51,629.45,78.6,764.54,20.65,855.87-18.53,872.34,72.12,1000,15.7V0Z"
                              style="fill-rule:evenodd"></path>
                    </svg>
                </div>
            </section>

        <?php endif ?>

        <div class="container text-center">

            <?php if (get_field('info2-toggle')): ?>


                <section id="more" class="mb-5">

                    <h2 class="section-title">
                        <?= get_field('info2-title') ?>
                    </h2>
                    <div class="row">
                        <div class="col-12 col-lg-7">
                            <?= get_field('info-content') ?>
                        </div>
                        <div class="col-5 d-none d-lg-block">
                            <img src="<?= get_field('info2-images')[0] ?>" id="kayaks">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-none d-lg-block">
                            <img src="<?= get_field('info2-images')[1] ?>" id="lasertag">
                        </div>
                        <div class="col d-none d-lg-block">
                            <img src="<?= get_field('info2-images')[2] ?>" id="paperwork">
                        </div>
                        <div class="col d-none d-lg-block">
                            <img src="<?= get_field('info2-images')[3] ?>" id="teacher">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-block d-lg-none">
                            <div id="carouselExampleControls" class="carousel slide px-3" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach (get_field('info2-images') as $key => $image): ?>

                                        <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                                            <img src="<?= $image ?>" class="d-block w-100">
                                        </div>

                                    <?php endforeach ?>
                                </div>
                                <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>

                        <?php if (get_field('info-add')): ?>
                            <div class="col-10 offset-1 mt-4">
                                <div class="alert alert-light">
                                    <?= get_field('info-add') ?>
                                </div>
                            </div>
                        <?php endif ?>

                    </div>

                </section>

            <?php endif ?>

            <section id="shifts" class="mb-5">

                <h2 class="section-title mb-4"><?= get_field('shifts-title') ?></h2>

                <div class="d-flex justify-content-center mb-2 subtitle"><?= get_field('shifts-subtitle') ?></div>

                <div class="d-flex justify-content-center flex-wrap">

                    <?php $index = 0;
                    while (have_rows('shifts-items')):
                        the_row();
                        $index++; ?>

                        <div class="shift d-flex flex-column" style="min-width: 250px;" data-bs-toggle="modal"
                             data-bs-target="#shiftModal<?= $index ?>">
                            <div class="shift-title flex-grow-1">
                                <?= get_sub_field('title') ?>
                            </div>
                            <div class="shift-days flex-grow-1">
                                <?= get_sub_field('start') ?> - <?= get_sub_field('end') ?>
                            </div>
                            <div class="shift-description">
                                <?= get_sub_field('description') ?>
                            </div>
                        </div>

                    <?php endwhile ?>

                </div>

                <div class="col-10 offset-1 mt-4 mb-3">
                    <div class="alert alert-light"><?= get_field('shifts-info') ?></div>
                </div>

            </section>

            <section id="features" class="mb-5">

                <h2 class="section-title"><?= get_field('footer-title') ?></h2>
                <div class="row">
                    <div class="col-12">
                        <?= get_field('footer-description') ?>
                    </div>
                    <?php if (get_field('footer-call')): ?>

                        <div class="col-10 offset-1">
                            <div class="alert alert-light">
                                <?= get_field('footer-call') ?>
                            </div>
                        </div>

                    <?php endif ?>

                    <div class="col-12 footer-price">
                        <style>
                            .footer-price * {
                                color: inherit !important;
                            }
                        </style>

                        <?= get_field('footer-price') ?>

                    </div>
                    <button class="btn btn-dark btn-lg footer-button" data-bs-toggle="modal"
                            data-bs-target="#bookModal"><?= get_field('footer-button') ?></button>



                    <div class="mt-5">
                        <?= get_field('footer-add') ?>
                    </div>

                </div>


            </section>

        </div>

        <?php $index = 0;
        while (have_rows('shifts-items')):
            the_row();
            $index++; ?>

            <div class="modal fade" id="shiftModal<?= $index ?>" tabindex="-1"
                 aria-labelledby="shiftModalLabel<?= $index ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" id="modal-data">
                        <div class="form-wrapper">
                            <div id="form<?= $index ?>-modal-call-wrapper">
                                <div class="modal-header" data-bs-theme="dark">
                                    <h5 class="modal-title" id="shiftModalLabel<?= $index ?>">Заполните заявку</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php if (get_sub_field('poster')): ?>

                                        <div id="poster">
                                            <img src="<?= get_sub_field('poster') ?>" style="width: 100%;" alt="">
                                        </div>

                                    <?php endif ?>

                                    <form onsubmit="return true;" id="form<?= $index ?>-modal-call"
                                          action="<?= get_template_directory_uri() ?>/handler.php" accept-charset="UTF-8"
                                          data-remote="true" method="post" data-reachGoal="true"
                                          data-reachGoal-id="93280561" data-reachGoal-name="uspeh">
                                        <div id="form<?= $index ?>-modal-call-error-wrapper" class="mb-3"></div>

                                        <input class="form-check-input" type="checkbox" name="smena[]" checked
                                               value="<?= get_sub_field('title') ?> (<?= get_sub_field('start') ?> - <?= get_sub_field('end') ?>)"
                                               id="shift<?= $index ?>" hidden>

                                        <div class="mb-3">
                                            <label for="fio" class="form-label">SUPER Родитель </label>
                                            <input type="text" name="fio" class="form-control" id="fio"
                                                   placeholder="Ваше ФИО">
                                        </div>
                                        <div>
                                            <label for="phone" class="form-label">SUPER Телефон </label>
                                            <input type="tel" name="phone" class="form-control" id="phone"
                                                   placeholder="Ваш замечательный телефон" required>
                                        </div>
                                        <div class="text-center mt-4">
                                            <div class="g-recaptcha"
                                                 data-sitekey="6LeOrJYpAAAAAOwAx2x1fmwMtAKCJEJDlS7DOyuC"></div>
                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="title" value="Выездной лагерь">
                                    <input type="hidden" name="status" value="9">
                                    <button type="submit" class="btn btn-dark"
                                            data-loading-text="Отправка данных...">Отправить</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endwhile ?>

        <div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" id="modal-data">
                    <div class="form-wrapper">
                        <div id="form-modal-call-wrapper">
                            <div class="modal-header" data-bs-theme="dark">
                                <h5 class="modal-title" id="exampleModalLabel">Заполните заявку</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="poster">
                                </div>
                                <form onsubmit="return true;" id="form-modal-call"
                                      action="<?= get_template_directory_uri() ?>/handler.php" accept-charset="UTF-8"
                                      data-remote="true" method="post" data-reachGoal="true"
                                      data-reachGoal-id="93280561" data-reachGoal-name="uspeh">
                                    <div id="form-modal-call-error-wrapper" class="mb-3"></div>

                                    <div class="mb-3">
                                        <label class="form-label">SUPER Смена</label>

                                        <?php
                                        $index = 0;
                                        while (have_rows('shifts-items')):
                                            the_row();
                                            $index++;
                                            ?>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="smena[]"
                                                       value="<?= get_sub_field('title') ?> (<?= get_sub_field('start') ?> - <?= get_sub_field('end') ?>)"
                                                       id="shift<?= $index ?>">
                                                <label class="form-check-label" for="shift<?= $index ?>">
                                                    <strong><?= get_sub_field('title') ?></strong>
                                                    <span>(<?= get_sub_field('start') ?> -
                                                        <?= get_sub_field('end') ?>)</span>
                                                </label>
                                            </div>

                                        <?php endwhile ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fio" class="form-label">SUPER Родитель </label>
                                        <input type="text" name="fio" class="form-control" id="fio"
                                               placeholder="Ваше ФИО">
                                    </div>
                                    <div>
                                        <label for="phone" class="form-label">SUPER Телефон </label>
                                        <input type="tel" name="phone" class="form-control" id="phone"
                                               placeholder="Ваш замечательный телефон" required>
                                    </div>
                                    <div class="text-center mt-4">
                                        <div class="g-recaptcha"
                                             data-sitekey="6LeOrJYpAAAAAOwAx2x1fmwMtAKCJEJDlS7DOyuC"></div>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="title" value="Выездной лагерь">
                                <input type="hidden" name="status" value="9">
                                <button type="submit" class="btn btn-dark"
                                        data-loading-text="Отправка данных...">Отправить</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
                crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="<?= get_template_directory_uri() ?>/js/jquery.mask.min.js"></script>
        <script src="<?= get_template_directory_uri() ?>/js/application.js?v=2"></script>
        <script>
            $(document).ready(function () {
                $('#phone').mask('+7(000)000-00-00', { clearIfNotMatch: true, placeholder: "+7(___)___-__-__" });
            });
        </script>
        <script
                type="text/javascript">(function (c, s, t, r, e, a, m) { c[e] = c[e] || function () { (c[e].q = c[e].q || []).push(arguments) }, c[e].p = r, a = s.createElement(t), m = s.getElementsByTagName(t)[0], a.async = 1, a.src = r, m.parentNode.insertBefore(a, m) })(window, document, 'script', 'https://c.sberlead.ru/clickstream.bundle.js', 'csa'); csa('init', { analyticsId: '58b7655d-5046-4c43-aeff-7538033add2c' }, true, true);</script>
        <a target="_blank" href="https://kidsincamp.ru/camp/supermom"
           style="display:flex;align-items: center;
    justify-content: center;text-decoration:none;color:#000;width:100%;height:66px;border-radius:10px;padding:1px;border:0px;letter-spacing:normal;"><img alt="kidsincamp.ru"
                 src="https://kidsincamp.ru/img/logo.jpeg" style="width:50px;height:48px;float:left;margin:8px;"><span
                  style="margin-left:6px;margin-top:12px;font-family:'Roboto',Arial,sans-serif;font-size:14px;line-height:1.5;text-align:left;">Наш
                лагерь на <br> портале лагерей</span></a>

    </body>

</html>
