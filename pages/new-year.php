<?php

// Template Name: Новый год

get_template_part('incs/header');

?>

<main class="contents">

    <section class="new-year section">
        <div class="new-year__inner container">
            <h1 class="new-year__title h2">
                <?= get_field('title') ?>
            </h1>
            <div class="new-year__subtitle h3">
                <?= get_field('subtitle') ?>
            </div>
            <ul class="new-year__posters">

                <?php while (have_rows('items')):
                    the_row(); ?>

                    <li class="new-year__poster">
                        <div class="new-year__poster-image-wrapper">
                            <?= getImage(get_sub_field('image'), [630, 886], 'new-year__poster-image') ?>
                        </div>
                        <div class="new-year__poster-body">
                            <div class="new-year__poster-content raw-content">
                                <?= get_sub_field('content') ?>
                            </div>
                            <button data-_modal="#order-_modal" type="button" class="new-year__button button">
                                Записаться
                            </button>
                        </div>
                    </li>

                <?php endwhile ?>

            </ul>
            <div class="new-year__call h3">
                <?= get_field('call') ?>
            </div>
        </div>
    </section>

</main>

<?php get_template_part('incs/footer'); ?>

