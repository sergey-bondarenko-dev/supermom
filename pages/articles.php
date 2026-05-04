<?php

// Template Name: Полезная информация

get_template_part('incs/header');

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$query = new WP_Query([
    'post_type' => 'article',
    'posts_per_page' => -1,
    'order' => 'asc'
]);

?>

<main class="contents">

    <section class="hero section">
        <div class="hero__inner container">
            <div class="hero__body">
                <div class="hero__title-wrapper">
                    <h1 class="hero__title h2">
                        <?= get_field('title') ?>
                    </h1>
                    <div class="hero__description hero__description--font-large">
                        <?= get_field('description') ?>
                    </div>
                    <button data-_modal="#order-_modal" type="button" class="hero__button-try button">
                        Пробное занятие
                    </button>
                </div>
                <div class="hero__image-wrapper">
                    <?= getImage(get_field('image'), [555, 506], 'hero__image') ?>
                </div>
            </div>
        </div>
    </section>

    <section class="articles section">
        <div class="articles__inner container">
            <h2 class="articles__title h1 section-title">Статьи</h2>
            <ul class="articles__list">

                <?php while ($query->have_posts()):
                    $query->the_post();
                    ?>

                    <li class="articles__list-item article-card">
                        <div class="article-card__preview">
                            <?php get_post_thumbnail_id() ?>
                            <?= getImage(get_post_thumbnail_id(), [292, 292], 'article-card__preview-image') ?>
                        </div>
                        <h3 class="article-card__title">
                            <?= get_the_title() ?>
                        </h3>
                        <div class="article-card__description">
                            <?= get_the_excerpt() ?: kama_excerpt(['maxchar' => 100]); ?>
                        </div>
                        <button data-article-id="/article/<?= get_the_ID() ?>"
                                class="article-card__button button button--flat">
                            Читать
                        </button>
                    </li>

                <?php endwhile;
                wp_reset_postdata(); ?>
            </ul>
        </div>
    </section>

</main>

<?php get_template_part('incs/footer', null, [
    '_modals' => ['article-_modal']
]); ?>

