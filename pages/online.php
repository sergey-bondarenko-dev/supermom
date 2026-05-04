<?php

// Template Name: Онлайн

get_template_part('incs/header');

?>

<main class="contents">

    <section class="hero section">
        <div class="hero__inner container">
            <div class="hero__body">
                <div class="hero__title-wrapper">
                    <h2 class="hero__title h2">
                        <?= get_field('hero-title') ?>
                    </h2>
                    <div class="hero__description hero__description--font-large">
                        <?= get_field('hero-description') ?>
                    </div>
                    <button data-_modal="#order-_modal" type="button" class="hero__button-try button">
                        Пробное занятие
                    </button>
                </div>
                <div class="hero__image-wrapper">
                    <?= getImage(get_field('hero-image'), [555, 506], 'hero__image') ?>
                </div>
            </div>
        </div>
    </section>

    <section class="successes section">
        <div class="successes__inner container">
            <div class="successes__body">
                <h2 class="successes__title h1 section-title">
                    <?= get_field('benefits-title') ?>
                </h2>
                <div class="successes__subtitle h3">
                    <?= get_field('benefits-subtitle') ?>
                </div>
                <ul class="successes__list">
                    <?php

                    $successModificators = ['pink', 'lightgreen', 'orange', 'red'];
                    $modCount = count($successModificators);

                    $index = -1;
                    while (have_rows('benefits-items')):
                        the_row();
                        $index++;

                        $modClass = '';
                        if ($index >= 1) {
                            $modClass = 'gradient-card--' . $successModificators[($index - 1) % $modCount];
                        }
                        ?>

                        <li
                            class="successes__item gradient-card <?= $index === 1 ? 'successes__item--down' : '' ?> <?= $modClass ?>">
                            <div class="gradient-card__image-wrapper">
                                <?= getImage(get_sub_field('image'), [320, 320], 'gradient-card__image') ?>
                            </div>
                            <h3 class="gradient-card__title h2">
                                <?= get_sub_field('title') ?>
                            </h3>
                            <div class="gradient-card__description">
                                <?= get_sub_field('description') ?>
                            </div>
                        </li>

                    <?php endwhile; ?>
                </ul>

                <img src="<?= assets('images/letters/c.png') ?>" data-scroll-translate-weight="35" alt="" width="180"
                     height="210" class="successes__decor scroll-translate">
                <img src="<?= assets('images/letters/d.png') ?>" data-scroll-translate-weight="20" alt="" width="180"
                     height="210" class="successes__decor scroll-translate">
            </div>
        </div>
    </section>

    <section class="info section">
        <div class="container">
            <div class="info__inner">
                <h2 class="info__title section-title h1">
                    <?= get_field('why-title') ?>
                </h2>
                <div class="info__body h4">
                    <?= get_field('why-content') ?>
                </div>
            </div>
        </div>
    </section>

    <section class="tarifs section">
        <div class="tarifs__inner container">
            <h2 class="tarifs__title h1 section-title">
                <?= get_field('tarifs-title') ?>
            </h2>
            <ul class="tarifs__list">

                <?php

                $successModificators = ['violet', 'green'];
                $modCount = count($successModificators);

                $index = -1;
                while (have_rows('tarifs')):
                    the_row();
                    $index++;

                    $modClass = '';
                    if ($index >= 1) {
                        $modClass = 'tarif-card--' . $successModificators[($index - 1) % $modCount];
                    }

                    $tarifId = get_sub_field('tarif_id');
                    ?>

                    <li class="tarifs__list-item tarif-card <?= $modClass ?> <?= $index == 1 ? 'tarifs__list-item--down' : '' ?>">
                        <h3 class="tarif-card__name h2">
                            <?= get_the_title($tarifId) ?>
                        </h3>
                        <div class="tarif-card__price">
                            <div class="tarif-card__price--discount">
                                <?= get_field('old-price', $tarifId) ?>
                            </div>
                            <div class="tarif-card__price-regular">
                                <?= get_field('new-price', $tarifId) ?>
                            </div>
                        </div>
                        <div class="tarif-card__body raw-content">
                            <?= get_field('excerpt', $tarifId) ?>
                        </div>
                        <div class="tarif-card__buttons">
                            <button data-_modal="#order-_modal" type="button" class="tarif-card__button button">
                                Записаться
                            </button>
                            <button type="button" data-article-id="/tarif/<?= $tarifId ?>"
                                    class="tarif-card__button button button--flat">
                                О курсе
                            </button>
                        </div>
                    </li>

                <?php endwhile ?>
            </ul>
            <div class="tarifs__info">
                <?= get_field('tarifs-info') ?>
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
                    <?= get_field('video-title') ?>
                </h2>
                <div class="about__body">
                    <div class="about__image-wrapper">
                        <img class="about__image" src="<?= assets('images/tv.png') ?>" width="250" alt=""
                             decoding="async" loading="lazy">
                        <button data-_modal="#yt-_modal" data-video-src="<?= htmlentities(get_field('video-source')) ?>"
                                title="Включить видео" aria-label="Включить видео" type="button"
                                class="about__play-button button button--icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 384 512" width="21px" height="21px">
                                <path fill="currentColor"
                                      d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z" />
                            </svg>
                        </button>
                    </div>
                    <div class="about__content">
                        <div class="about__content-text">
                            <?= get_field('video-content') ?>
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

    <?= get_template_part('incs/price', null, ['postId' => get_field('price_id')]) ?>

</main>

<?php get_template_part('incs/footer', null, [
    '_modals' => [
        'yt-_modal',
        'article-_modal'
    ]
]); ?>

