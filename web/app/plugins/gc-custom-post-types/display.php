<?php

function gc_display_post_by_parent( $post_type, $parent_post ) {
    $displayed_posts = get_posts( array(
        'post_type' => $post_type,
        'post_parent' => $parent_post->ID
    )); ?>

    <button type='button' id='toggle-all-content' onclick='toggle_all_content()'>Toggle all <?=$post_type?></button>
    <ul>
        <?php foreach( $displayed_posts as $displayed_post ) { ?>
            <li>
                <h4>
                    <button type='button' class='toggle-button' onclick='toggle_content()'>&#x025BE;</button>
                    <a href="<?=get_edit_post_link( $displayed_post->ID )?>"><?=$displayed_post->post_title;?></a>
                </h4>
                <div class='content'>
                    <?php
                    $display_content = $post_type . '_display_content';
                    $display_content( $displayed_post );
                    ?>
                </div>
            </li>
        <?php } ?>
    </ul>
<?php }