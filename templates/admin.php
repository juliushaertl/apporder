<div class="section" id="apporder">
    <h2><?php p($l->t('App Order')) ?></h2>
    <p><?php p($l->t('Default order for all users')) ?></p>
    <ul id="appsorter">
    <?php foreach($_['nav'] as $entry) { ?>
        <li>
            <img class="app-icon svg" alt="" src="<?php print_unescaped($entry['icon']); ?>">
            <a href="<?php print_unescaped($entry['href']); ?>">
            <?php echo $entry['name']; ?>
            </a>
        </li>
    <?php } ?>
    </ul>
</div>
