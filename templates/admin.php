<div class="section" id="apporder">
    <h2><?php p($l->t('App Order')) ?></h2>
    <?php if($_['type'] === 'admin') { ?>
    <p><?php p($l->t('Set a default order for all users. This will be ignored, if the user has setup a custom order.')); ?></p>
    <?php } ?>
    <p><em><?php p($l->t('Drag the app icons to change their order.')); ?></em></p>
    <ul id="appsorter" data-type="<?php p($_['type']); ?>">
    <?php foreach($_['nav'] as $entry) { ?>
        <li>
            <input class="apporderhidden" type="checkbox" <?php if(!in_array($entry['href'],$_['hidden'])) {print_unescaped("checked");}?> >
            <img class="app-icon svg" alt="" src="<?php print_unescaped($entry['icon']); ?>">
            <p data-url="<?php p($entry['href']); ?>">
            <?php echo $entry['name']; ?>
            </p>
        </li>
    <?php } ?>
    </ul>
</div>
