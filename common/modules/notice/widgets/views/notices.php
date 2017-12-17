<?php

?>
<?php if ($model): ?>


    <a href="#" class="link-profile dropdown-toggle" data-toggle="dropdown" role="button">
        <span class="badge"><?= count($model) ?></span>
    </a>
    <ul class="dropdown-menu dropdown-notices">
        <?php foreach ($model as $key => $item): ?>
            <li class="has-stop-prepagation">
                <!--                <form>-->
                <a href="#"
                   class="bs-docs-popover popover-item"
                   role="button"
                   data-container="body"
                   data-placement="left"
                   data-toggle="popover"
                   data-trigger="hover focus"
                   title="<?= $item->subject ?>"

                   data-content='<?= $item->body ?>'
                ><?= $item->subject ?></a>
                <span class="actions-menu">

                </span>
                <!--                </form>-->
            </li>
        <?php endforeach; ?>

    </ul>
<?php endif; ?>

<script>
    window.onload = function () {
        $('.popover-item').each(function (idx, el) {
            $(el).popover({
                trigger: 'focus hover',
                content: $.parseHTML($(el).data('content')),
                html: true,
                delay: 200
            });
        })
    }
</script>
