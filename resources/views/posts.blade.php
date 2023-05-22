<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>☕️ Metal & Coffee Blog</title>
        <link rel="stylesheet" href="/app.css">
    </head>
    <body>
    <?php foreach( $posts as $post ) : ?>
        <article>
            <a href="/post/<?= $post->slug ?>">
                <h1><?= $post->title ?></h1>
            </a>
            <div><?= $post->excerpt ?></div>
        </article>
     <?php endforeach; ?>
    </body>
</html>
