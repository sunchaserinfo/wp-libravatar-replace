<div class="wrap">
    <h2>Libravatar Replace Settings</h2>

    <p>
        <?php _e('You may set the default avatar on the', 'libravatar-replace') ?>
        <a href="options-discussion.php"><?php _e('Discussion Settings page', 'libravatar-replace') ?></a>
    </p>

    <form method="post" action="options.php">
        <?php settings_fields(LibravatarReplace::MODULE_NAME); ?>

        <p>
            <input type="checkbox" name="<?php echo LibravatarReplace::OPTION_LOCAL_CACHE_ENABLED ?>" id="cache-enabled" value="1"
                <?php if(get_option(LibravatarReplace::OPTION_LOCAL_CACHE_ENABLED, LibravatarReplace::OPTION_LOCAL_CACHE_ENABLED_DEFAULT)): ?>checked="checked"<?php endif ?>/>
            <label for="cache-enabled"><?php _e('Use local cache for images', 'libravatar-replace') ?> <?php _e('(experimental)', 'libravatar-replace') ?></label>
        </p>

        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'libravatar-replace') ?>" />
        </p>
    </form>
</div>
