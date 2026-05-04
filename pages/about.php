<?php

// Template Name: О нас

get_template_part('incs/header');

?>

<main class="contents">

    <section class="hero section">
        <div class="hero__inner container">
            <div class="hero__body">
                <div class="hero__title-wrapper">
                    <h1 class="hero__title h2">
                        <?= get_field('hero-title') ?>
                    </h1>
                    <div class="hero__description">
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

    <section class="director section">
        <div class="director__inner container">
            <div class="director__image-wrapper">
                <?= getImage(get_field('director-image'), [470, 802], 'director__image') ?>
            </div>
            <div class="director__body">
                <h2 class="director__title h1 section-title"><?= get_field('director-name') ?></h2>
                <div class="director__subtitle h2">
                    <?= get_field('director-post') ?>
                </div>
                <div class="director__description">
                    <?= get_field('director-content') ?>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_template_part('incs/footer'); ?>

