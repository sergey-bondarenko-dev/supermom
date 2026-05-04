<?php

$postId = $args['postId'] ?? 0;

if (!$postId) {
    return '';
}

?>

<section class="price section">
    <div class="price__inner container">
        <h2 class="price__title h1 section-title">
            <?= get_the_title($postId) ?>
        </h2>
        <table class="price__table table">
            <thead>
                <tr>
                    <th class="table__header" colspan="12">
                        ПРАЙС
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php while (have_rows('rows', $postId)):
                    the_row() ?>

                    <tr class="table__row">
                        <td class="table__cell" data-th="ПРАЙС">
                            <?= get_sub_field('label') ?>
                        </td>
                        <td class="table__cell table__cell--text-center" data-th="ПРАЙС">
                            <strong><?= get_sub_field('price') ?></strong>
                        </td>
                    </tr>

                <?php endwhile ?>

                <?php if (get_field('info', $postId)): ?>
                    <tr class="table__row">
                        <td class="table__cell table__cell--text-center" colspan="12" data-th="ПРАЙС">
                            <?= get_field('info', $postId) ?>
                        </td>
                    </tr>
                <?php endif ?>

            </tbody>
        </table>
        <button data-modal="#order-modal" type="button" class="price__button button">
            Оставить заявку
        </button>

        <?php if (get_field('program', $postId)): ?>

            <a target="_blank" href="<?= get_field('program', $postId) ?>" class="price__file">
                Программа обучения
            </a>

        <?php endif ?>

    </div>
</section>
