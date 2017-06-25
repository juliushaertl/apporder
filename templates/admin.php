<div class="section" id="apporder">
    <h2><?php p($l->t('App Order')) ?></h2>
    <p><?php p($l->t('Set a default order for all users. This will be ignored, if the user has setup a custom order.')) ?></p>
    <p><em><?php p($l->t('Drag the app icons to change their order.')); ?></em></p>
    <ul id="appsorter" data-type="<?php p($_['type']); ?>">
    <?php foreach($_['nav'] as $entry) { ?>
        <li>
<input type="checkbox">
            <img class="app-icon svg" alt="" src="<?php print_unescaped($entry['icon']); ?>">
            <a href="<?php print_unescaped($entry['href']); ?>">
            <?php echo $entry['name']; ?>
            </a>
        </li>
    <?php } ?>
    </ul>
</div>
