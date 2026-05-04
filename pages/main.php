<?php

// Template Name: Главная

?>

<?php get_template_part('incs/header') ?>

<main class="contents">

    <section class="hero section">
        <div class="hero__inner container">
            <?php if (get_field('banner-on')):
                $banner = get_field('banner');
                $banner['link'] = '';
                ?>

                <a href="<?= $banner['link'] ?: '#' ?>" class="hero__banner" aria-label="<?= $banner['label'] ?>"
                   title="<?= $banner['label'] ?>">

                    <img src="<?= $banner['desktop'] ?>" alt=""
                         class="hero__banner-desktop <?= $banner['mobile'] ? 'hidden-mobile' : '' ?> ">

                    <?php if ($banner['mobile']): ?>
                        <img src="<?= $banner['mobile'] ?>" alt="" class="hero__banner-mobile visible-mobile">
                    <?php endif ?>

                </a>

            <?php endif ?>

            <div class="hero__body">
                <div class="hero__title-wrapper">
                    <div class="hero__subtitle h3">
                        <?= get_field('hero-subtitle') ?>
                    </div>
                    <h1 class="hero__title h2">
                        <?= get_field('hero-title') ?>
                    </h1>
                    <button data-_modal="#order-_modal" type="button" class="hero__button-try button">
                        Пробное занятие
                    </button>
                </div>
                <div class="hero__image-wrapper">
                    <?= getImage(get_field('hero-image'), [555, 506], 'hero__image') ?>
                </div>
            </div>
            <a href="/raspisanie" class="hero__order button button--rect">
                Записаться онлайн
            </a>
        </div>
    </section>

    <section class="why section">
        <div class="why__inner container">
            <div class="why__body">
                <div class="why__content">
                    <h2 class="why__title">
                        <?= get_field('why-title') ?>
                    </h2>
                    <div class="why__text">
                        <?= get_field('why-content') ?>
                    </div>
                </div>
                <div class="why__image-wrapper">
                    <img width="320" height="426" class="why__image" src="<?= assets('images/question.png') ?>" alt=""
                         decoding="async" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <section class="about section">
        <svg class="about__decor" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 1000 84.94"
             preserveaspectratio="none">
            <path fill="currentColor"
                  d="M0,0V72.94c14.46,5.89,32.38,10.5,54.52.26,110.25-51,120.51,23.71,192.6-4.3,144.73-56.23,154.37,49.44,246.71,4.64C637,4.05,622.19,124.16,757.29,66.21c93-39.91,108.38,54.92,242.71-8.25V0Z"
                  style="fill-rule:evenodd;opacity:0.33"></path>
            <path fill="currentColor"
                  d="M0,0V52.83c131.11,59.9,147-32.91,239.24,6.65,135.09,58,120.24-62.16,263.46,7.34,92.33,44.8,102-60.88,246.71-4.64,72.1,28,82.35-46.71,192.6,4.3,23.95,11.08,43,4.78,58-1.72V0Z"
                  style="fill-rule:evenodd;opacity:0.66"></path>
            <path fill="currentColor"
                  d="M0,0V24.26c15.6,6.95,35.77,15.41,61.78,3.38,110.25-51,120.51,23.71,192.6-4.3C399.11-32.89,408.75,72.79,501.08,28,644.3-41.51,629.45,78.6,764.54,20.65,855.87-18.53,872.34,72.12,1000,15.7V0Z"
                  style="fill-rule:evenodd"></path>
        </svg>
        <div class="about__inner">
            <div class="container">
                <h2 class="about__title h1 section-title">
                    <?= get_field('about-title') ?>
                </h2>
                <div class="about__body">
                    <div class="about__image-wrapper">
                        <img class="about__image" src="<?= assets('images/tv.png') ?>" width="250" alt=""
                             decoding="async" loading="lazy">
                        <button data-_modal="#yt-_modal" data-video-src="<?= htmlentities(get_field('about-video')) ?>"
                                title="Включить видео" aria-label="Включить видео" type="button"
                                class="about__play-button button button--icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 384 512" width="21px" height="21px">
                                <path fill="currentColor"
                                      d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z" />
                            </svg>
                        </button>
                    </div>
                    <div class="about__content">
                        <h3 class="about__content-title h2">
                            <?= get_field('about-subtitle') ?>
                        </h3>
                        <div class="about__content-text">
                            <?= get_field('about-content') ?>
                        </div>
                    </div>
                    <img class="about__body-decor scroll-translate" data-scroll-translate-weight="30"
                         src="<?= assets('images/megafone.png') ?>" width="214" height="214" alt="" decoding="async"
                         loading="lazy">
                    <img class="about__body-decor scroll-translate" data-scroll-translate-weight="20"
                         src="<?= assets('images/megafone.png') ?>" width="214" height="214" alt="" decoding="async"
                         loading="lazy">
                </div>
            </div>
        </div>
        <svg class="about__decor" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 1000 84.94"
             preserveaspectratio="none">
            <path fill="currentColor"
                  d="M0,0V72.94c14.46,5.89,32.38,10.5,54.52.26,110.25-51,120.51,23.71,192.6-4.3,144.73-56.23,154.37,49.44,246.71,4.64C637,4.05,622.19,124.16,757.29,66.21c93-39.91,108.38,54.92,242.71-8.25V0Z"
                  style="fill-rule:evenodd;opacity:0.33"></path>
            <path fill="currentColor"
                  d="M0,0V52.83c131.11,59.9,147-32.91,239.24,6.65,135.09,58,120.24-62.16,263.46,7.34,92.33,44.8,102-60.88,246.71-4.64,72.1,28,82.35-46.71,192.6,4.3,23.95,11.08,43,4.78,58-1.72V0Z"
                  style="fill-rule:evenodd;opacity:0.66"></path>
            <path fill="currentColor"
                  d="M0,0V24.26c15.6,6.95,35.77,15.41,61.78,3.38,110.25-51,120.51,23.71,192.6-4.3C399.11-32.89,408.75,72.79,501.08,28,644.3-41.51,629.45,78.6,764.54,20.65,855.87-18.53,872.34,72.12,1000,15.7V0Z"
                  style="fill-rule:evenodd"></path>
        </svg>
    </section>

    <section class="courses section">
        <div class="courses__inner container">
            <h2 class="courses__title h1 section-title">
                <?= get_field('courses-title') ?>
            </h2>
            <ul class="courses__list">

                <?php
                $index = 0;
                while (have_rows('courses-items')):
                    the_row();
                    $index++;

                    $modClass = '';
                    if ($index === 1) {
                        $modClass = 'courses__card--violet';
                    } elseif ($index === 2) {
                        $modClass = 'courses__card--blue';
                    } else {
                        $modClass = 'courses__card--orange';
                    }

                    $courseId = get_sub_field('course_id');

                    ?>

                    <li class="courses__card <?= $modClass ?>">
                        <div class="courses__card-tarifs">
                            <div class="courses__card-age h2">
                                <?= get_field('target', $courseId) ?>
                            </div>
                            <ul class="courses__card-tarifs-list">
                                <?php
                                $j = 0;
                                while (have_rows('tarifs', $courseId)):
                                    the_row();
                                    $j++;
                                    ?>

                                    <li class="courses__card-tarifs-item h5">
                                        <img width="128" height="143" class="courses__card-tarifs-icon"
                                             src="<?= assets("images/tarifs/$j.png") ?>">
                                        <span class="courses__card-tarifs-label">
                                            <?= get_the_title(get_sub_field('tarif_id')) ?>
                                        </span>
                                    </li>

                                <?php endwhile ?>
                            </ul>
                        </div>
                        <div class="courses__card-body">
                            <h3 class="courses__card-title h2">
                                <?= get_the_title($courseId) ?>
                            </h3>
                            <div class="courses__card-description h4">
                                <?= get_field('description', $courseId) ?>
                            </div>
                            <div class="courses__card-buttons">
                                <button data-_modal="#order-_modal" type="button" class="courses__card-button button">
                                    Оставить заявку
                                </button>
                                <a href="<?= get_permalink(get_field('page_id', $courseId)) ?>"
                                   class="courses__card-link button button--flat">
                                    О курсе
                                </a>
                            </div>
                        </div>
                        <img width="900" height="900" src="<?= assets('images/course-card-bg.png') ?>" alt=""
                             class="courses__card-image">

                        <?php if ($index === 1): ?>

                            <img src="<?= assets('images/letters/a.png') ?>" data-scroll-translate-weight="15" alt=""
                                 width="180" height="210" class="courses__card-decor scroll-translate">
                            <img src="<?= assets('images/letters/b.png') ?>" data-scroll-translate-weight="5" alt="" width="180"
                                 height="210" class="courses__card-decor scroll-translate">

                        <?php elseif ($index === 2): ?>

                            <img src="<?= assets('images/letters/c.png') ?>" data-scroll-translate-weight="15" alt=""
                                 width="180" height="210" class="courses__card-decor scroll-translate">
                            <img src="<?= assets('images/letters/d.png') ?>" data-scroll-translate-weight="5" alt="" width="180"
                                 height="210" class="courses__card-decor scroll-translate">

                        <?php else: ?>

                            <img src="<?= assets('images/letters/e.png') ?>" data-scroll-translate-weight="20" alt=""
                                 width="180" height="210" class="courses__card-decor scroll-translate">
                            <img src="<?= assets('images/letters/f.png') ?>" data-scroll-translate-weight="35" alt=""
                                 width="180" height="210" class="courses__card-decor scroll-translate">

                        <?php endif ?>
                    </li>

                <?php endwhile ?>
            </ul>
        </div>
    </section>

    <section class="successes section">
        <div class="successes__inner container">
            <h2 class="successes__title h1 section-title">
                <?= get_field('success-title') ?>
            </h2>
            <ul class="successes__list">
                <?php

                $successModificators = ['pink', 'lightgreen', 'orange', 'red'];
                $modCount = count($successModificators);

                $index = -1;
                while (have_rows('success-items')):
                    the_row();
                    $index++;

                    $modClass = '';
                    if ($index >= 1) {
                        $modClass = 'gradient-card--' . $successModificators[($index - 1) % $modCount];
                    }
                    ?>

                    <li
                        class="successes__item gradient-card <?= $index === 1 ? 'successes__item--down' : '' ?> <?= $modClass ?>">
                        <h3 class="gradient-card__title h2">
                            <?= get_sub_field('name') ?>
                        </h3>
                        <div class="gradient-card__image-wrapper">
                            <?= getImage(get_sub_field('photo'), [320, 320], 'gradient-card__image') ?>
                        </div>
                        <div class="gradient-card__label">
                            <?= get_sub_field(selector: 'age') ?>
                        </div>
                        <div class="gradient-card__description">
                            <?= get_sub_field('description') ?>
                        </div>
                        <?php if (get_sub_field('video')): ?>
                            <button data-_modal="#yt-_modal" data-video-src="<?= htmlentities(get_sub_field('video')) ?>"
                                    class="gradient-card__button button button--icon button--icon-small"
                                    aria-label="Включить видео" title="Включить видео">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21px" height="21px" viewbox="0 0 384 512">
                                    <path fill="currentColor"
                                          d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z" />
                                </svg>
                            </button>
                        <?php endif ?>
                    </li>

                <?php endwhile; ?>
            </ul>
        </div>
    </section>

    <section class="values section">
        <div class="values__inner container">
            <h2 class="values__title h1 section-title">
                <?= get_field('values-title') ?>
            </h2>
            <ul class="values__list">

                <?php
                $index = 0;
                while (have_rows('values-items')):
                    the_row();
                    $index++;
                    ?>

                    <li class="values__item <?= $index === 2 ? 'values__item--top' : '' ?>">
                        <div class="values__item-image-wrapper">
                            <span class="visually-hidden"><?= get_sub_field('value') ?></span>
                            <?php
                            $imageClassName = 'values__item-image';

                            if ($index % 3 === 1) {
                                $imageClassName = 'values__item-image values__item-image--long-duration';
                            } elseif ($index % 3 === 2) {
                                $imageClassName = 'values__item-image values__item-image--medium-duration';
                            }
                            ?>
                            <?= getImage(get_sub_field('image'), [677, 380], $imageClassName) ?>
                        </div>
                        <div class="values__item-title h2">
                            <?= get_sub_field('label') ?>
                        </div>
                        <div class="values__item-description">
                            <?= get_sub_field('description') ?>
                        </div>
                    </li>

                <?php endwhile ?>
            </ul>
        </div>
    </section>

    <section class="media-about section">
        <div class="media-about__inner container">
            <h2 class="media-about__title h1 section-title">
                <?= get_field('media-title') ?>
            </h2>
            <ul class="media-about__list">
                <?php while (have_rows('media-items')):
                    the_row() ?>

                    <li class="media-about__list-item video-card">
                        <div class="video-card__preview-wrapper">
                            <p class="visually-hidden">
                                <?= get_sub_field('description') ?>
                            </p>
                            <?= getImage(get_sub_field('thumbnail'), [320, 320], 'video-card__preview') ?>
                            <button data-_modal="#yt-_modal" data-video-src="<?= htmlentities(get_sub_field('video')) ?>"
                                    class="video-card__preview-button button button--icon button--icon-small"
                                    aria-label="Включить видео" title="Включить видео">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21px" height="21px" viewBox="0 0 384 512">
                                    <path fill="currentColor"
                                          d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z" />
                                </svg>
                            </button>
                        </div>
                    </li>

                <?php endwhile ?>
            </ul>
        </div>
    </section>

    <section class="reviews section">
        <div class="reviews__inner container">
            <h2 class="reviews__title h1 section-title">
                <?= get_field('reviews-title') ?>
            </h2>
            <ul class="reviews__list">
                <?php

                $modClasses = ['violet', 'yellow', 'blue'];
                $modCount = count($modClasses);
                $index = 0;

                while (have_rows('reviews-items')):
                    the_row();
                    $index++;

                    $modClass = '';
                    if ($index >= 1) {
                        $modClass = 'video-card--' . $modClasses[($index - 1) % $modCount];
                    }
                    ?>

                    <li class="reviews__list-item video-card <?= $modClass ?>">
                        <h3 class="video-card__title h2">
                            <?= get_sub_field('name') ?>
                        </h3>
                        <div class="video-card__preview-wrapper">
                            <?= getImage(get_sub_field('thumbnail'), [320, 320], 'video-card__preview') ?>
                            <button data-_modal="#yt-_modal" data-video-src="<?= htmlentities(get_sub_field('video')) ?>"
                                    class="video-card__preview-button button button--icon button--icon-small"
                                    aria-label="Включить видео" title="Включить видео">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21px" height="21px" viewBox="0 0 384 512">
                                    <path fill="currentColor"
                                          d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z" />
                                </svg>
                            </button>
                        </div>
                    </li>

                <?php endwhile ?>
            </ul>
        </div>
    </section>

</main>

<?php get_template_part('incs/footer', null, [
    '_modals' => [
        'yt-_modal'
    ]
]) ?>

