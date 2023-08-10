<?php

$user_id = get_current_user_id();

$forums = get_posts([
    'post_type'     => bbp_get_forum_post_type(),
    'numberposts'   => 99,
    'post_status'   => 'publish',
    'meta_key'      => 'bbp_objective',
    'meta_value'    => '2'
]);

$opportunities = [];
foreach ( $forums as $forum ) {
    $topic_ids = bbp_get_all_child_ids( $forum->ID, bbp_get_topic_post_type() );
    foreach ( $topic_ids as $topic_id ) {
        $topic = get_post( $topic_id );
        if ( 'trash' === $topic->post_status ) {
            continue;
        }
        if ( current_user_can( 'moderate', $forum->ID ) || $topic->post_author == $user_id ) {
            $opportunities[$topic_id]['forum_id']       = $forum->ID;
            $opportunities[$topic_id]['forum_title']    = $forum->post_title;
            $opportunities[$topic_id]['topic_id']       = $topic->ID;
            $opportunities[$topic_id]['topic_title']    = $topic->post_title;
            $opportunities[$topic_id]['topic_status']   = $topic->post_status;
            $opportunities[$topic_id]['topic_link']     = $topic->guid;
        }
    }
}

?>
<div class="row mb-3">
    <div class="col-6"></div>
    <div class="col">
        <label class="modify" for="status-search"><?= __( 'Search', 'jpf4bbp' ) ?></label>
        <div class="input-group">
            <input
                id="status-search"
                class="form-control search"
                type="text"
                name="s"
            />
            <div class="input-group-append">
                <button class="btn btn-primary search" type="button">
                    <img src="<?= plugin_dir_url( __FILE__ ) . '../img/search.svg' ?>" alt="Save">
                </button>
            </div>
        </div>
    </div>
    <div class="col">
        <label class="modify" for="bbp_topic_status_select">
            <?= __( 'Status', 'jpf4bbp' ) ?>
        </label>
        <div class="input-group">
            <select id="status-select" class="custom-select">
            <?php
            $options = bbp_get_topic_statuses();
            $options['pending'] = __( 'Pending', 'jpf4bbp' );
            $options['all'] = __( 'All', 'jpf4bbp' );
            foreach ( $options as $option => $txt ) {
                $selected = 'all' === $option ? 'selected="selected"' : '';
                if ( 'trash' === $option ) {
                    continue;
                }
                echo '<option value="'.$option.'" '.$selected.'>'.$txt.'</option>';
            }
            ?>
            </select>
            <div class="input-group-append">
                <button class="btn btn-primary search" type="button">
                    <img src="<?= plugin_dir_url( __FILE__ ) . '../img/search.svg' ?>" alt="Save">
                </button>
            </div>
        </div>
    </div>
</div>
<div class="row g-0">
    <div class="col">
        <table id="oportunities" class="table table-striped caption-top">
            <thead>
                <tr>
                    <th scope="col"><?= __( 'Opportunity', 'jpf4bbp' ); ?></th>
                    <th scope="col" width="200"><?= __( 'Status', 'jpf4bbp' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ( $opportunities as $opportunity ) { ?>
                <tr>
                    <td>
                        <a href="<?= $opportunity['topic_link'] ?>">
                            <?= $opportunity['topic_title'] ?>
                        </a>
                        <br>
                        <?php
                        if ( current_user_can( 'moderate', $opportunity['forum_id'] ) ) {
                            ?>
                            <small>
                            <?php
                            printf( esc_html__( 'Started by: %1$s', 'bbpress' ), bbp_get_topic_author_link([
                                'post_id' => $opportunity['topic_id'],
                                'type'    => 'name'
                            ]));
                            ?>
                                <span class="bbp-topic-started-in">
                                    <?php printf( esc_html__( 'in: %1$s', 'bbpress' ), '<a href="' . bbp_get_forum_permalink( $opportunity['forum_id'] ) . '">' . bbp_get_forum_title( $opportunity['forum_id'] ) . '</a>' ); ?>
                                </span>
                            </small>
                            <?php
                        } else {
                            printf( esc_html__( 'Most recent answer: %1$s', 'jpf4bbp' ), bbp_get_topic_last_active_time( $opportunity['topic_id'] ));
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ( current_user_can( 'moderate', $opportunity['forum_id'] ) || 'publish' === $opportunity['topic_status'] ) { ?>
                        <label class="modify" for="<?= 'bbp_topic_' . $opportunity['topic_id'] . '_select' ?>">
                            <?= __( 'Current status', 'jpf4bbp' ) ?>
                        </label>
                        <span style="display: none;"><?= 'all ' . $opportunity['topic_status'] ?></span>
                        <div class="input-group">
                            <?php
                            bbp_form_topic_status_dropdown([
                                'topic_id'      => $opportunity['topic_id'],
                                'selected'      => $opportunity['topic_status'],
                                'select_id'     => 'bbp_topic_' . $opportunity['topic_id'],
                                'select_class'  => 'custom-select'
                            ]);
                            ?>
                            <input type="hidden" name="topic_id" value="<?= $opportunity['topic_id'] ?>" />
                            <div class="input-group-append">
                                <button class="btn btn-primary send-form" type="button">
                                    <img src="<?= plugin_dir_url( __FILE__ ) . '../img/save.svg' ?>" alt="Save">
                                </button>
                            </div>
                        </div>
                        <?php
                        } else {
                            ?>
                            <span style="display: none;"><?= 'all ' . $opportunity['topic_status'] ?></span>
                            <?php
                            echo 'pending' === $opportunity['topic_status'] || 'spam' === $opportunity['topic_status'] ? __( 'Pending', 'jpf4bbp' ) : bbp_get_topic_statuses()[$opportunity['topic_status']];
                        }
                        ?>
                    </td>
                </tr>
                <?php
                } ?>
            </tbody>
        </table>
    </div>
</div>
