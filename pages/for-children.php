<?php

// Template Name: Детям

get_template_part('incs/header');

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$query = new WP_Query([
    'post_type' => 'course',
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
                        <?= get_field('hero-title') ?>
                    </h1>
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
                    <?= get_field('why-title') ?>
                </h2>
                <div class="successes__subtitle h3">
                    <?= get_field('why-subtitle') ?>
                </div>
                <ul class="successes__list">
                    <?php

                    $successModificators = ['pink', 'lightgreen', 'orange', 'red'];
                    $modCount = count($successModificators);

                    $index = -1;
                    while (have_rows('why-items')):
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
                                <?= get_sub_field('label') ?>
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

    <section class="articles section">
        <div class="articles__inner container">
            <h2 class="articles__title h1 section-title">НАШИ КУРСЫ</h2>
            <ul class="articles__list">

                <?php while ($query->have_posts()):
                    $query->the_post();
                    ?>

                    <li class="articles__list-item article-card">
                        <div class="article-card__preview">
                            <?php get_post_thumbnail_id() ?>
                            <?= getImage(get_post_thumbnail_id(), [292, 292], 'article-card__preview-image') ?>
                        </div>
                        <div class="article-card__subtitle h3">
                            <?= get_the_title() ?>
                        </div>
                        <h3 class="article-card__title">
                            <?= get_field('description', get_the_ID()) ?>
                        </h3>
                        <div class="article-card__buttons">
                            <button data-_modal="#order-_modal" type="button" class="article-card__button button">
                                Записаться
                            </button>
                            <button data-article-id="/course/<?= get_the_ID() ?>"
                                    class="article-card__button button button--flat">
                                О курсе
                            </button>
                        </div>
                        <?php if (get_field('document')): ?>
                            <a target="_blank" href="<?= get_field('document') ?>" class="article-card__file">
                                Программа курса
                            </a>
                        <?php endif ?>
                    </li>

                <?php endwhile;
                wp_reset_postdata(); ?>
            </ul>
        </div>
    </section>

    <section class="info section">
        <div class="container">
            <div class="info__inner">
                <h2 class="info__title section-title h1">
                    <?= get_field('who-title') ?>
                </h2>
                <div class="info__body h4">
                    <?= get_field('who-content') ?>
                </div>
            </div>
        </div>
    </section>

    <?= get_template_part('incs/price', null, ['postId' => get_field('price_id')]) ?>

</main>

<?php get_template_part('incs/footer', null, [
    '_modals' => ['article-_modal']
]); ?>

