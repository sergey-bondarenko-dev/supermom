<?php

// Template Name: Школьникам

get_template_part('incs/header', null, [
    'styles' => [
        assets('libs/swiper/swiper.css')
    ],
    'scripts' => [
        assets('libs/swiper/swiper.js')
    ]
]);

?>

<main class="contents">

    <section class="hero section">
        <div class="hero__inner container">
            <div class="hero__body">
                <div class="hero__title-wrapper">
                    <h1 class="hero__title h2">
                        <?= get_field('fun-title') ?>
                    </h1>
                    <div class="hero__description hero__description--font-large raw-content">
                        <?= get_field('fun-description') ?>
                    </div>
                    <button data-_modal="#order-_modal" type="button" class="hero__button-try button">
                        Пробное занятие
                    </button>
                </div>
                <div class="hero__image-wrapper">
                    <?= getImage(get_field('fun-image'), [600, 924], 'hero__image') ?>
                </div>
            </div>
        </div>
    </section>

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
                    <?= get_field('help-title') ?>
                </h2>
                <div class="successes__subtitle h3">
                    <?= get_field('help-subtitle') ?>
                </div>
                <ul class="successes__list">
                    <?php

                    $successModificators = ['pink', 'lightgreen', 'orange', 'red'];
                    $modCount = count($successModificators);

                    $index = -1;
                    while (have_rows('help-items')):
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

    <section class="section">
        <h2 class="section-title h1 container">
            <?= get_field('slider-title') ?>
        </h2>
        <div class="section-body">
            <div class="courses-slider container">
                <div class="courses-slider__swiper swiper">
                    <div class="swiper-wrapper">

                        <?php foreach (get_field('slider-slides') as $imageId): ?>

                            <div class="swiper-slide">
                                <?= getImage($imageId, [351, 531]) ?>
                            </div>

                        <?php endforeach ?>

                        <?php foreach (get_field('slider-slides') as $imageId): ?>

                            <div class="swiper-slide">
                                <?= getImage($imageId, [351, 531]) ?>
                            </div>

                        <?php endforeach ?>
                    </div>
                    <button class="courses-slider__nav courses-slider__nav--prev button button--icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" width="30px" viewBox="0 -960 960 960"
                             fill="currentColor">
                            <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z" />
                        </svg>
                    </button>
                    <button class="courses-slider__nav courses-slider__nav--next button button--icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" width="30px" viewBox="0 -960 960 960"
                             fill="currentColor">
                            <path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z" />
                        </svg>
                    </button>
                    <div class="swiper-pagination"></div>
                </div>
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

    <?= get_template_part('incs/price', null, ['postId' => get_field('price_id')]) ?>

    <section class="selt section">
        <div class="selt__inner container">
            <div class="selt__subtitle h1">
                <?= get_field('selt-call') ?>
            </div>
            <div class="selt__title section-title">
                <?= get_field('selt-title') ?>
            </div>
            <a href="<?= get_permalink(get_field('selt-link')) ?>" class="selt__link button">
                Подробнее
            </a>
        </div>
    </section>

</main>

<?php get_template_part('incs/footer'); ?>

