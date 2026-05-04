<?php

// Template Name: Расписание

get_template_part('incs/header');

?>

<main class="contents">

    <section class="section">
        <div class="container">
            <h1 class="section-title">
                <?= get_the_title() ?>
            </h1>
            <div class="schedule">
                <?= get_the_content() ?>
            </div>
        </div>
    </section>

</main>

<?php get_template_part('incs/footer'); ?>

