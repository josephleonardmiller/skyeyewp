<?php
/**
 * Featured post — admin star column + front-end exclusion from main query
 *
 * Stores the pinned post ID in _skyeye_featured_post option (single post only).
 * pre_get_posts excludes it from the main blog query so home.php can show it
 * separately at the top.
 */

defined( 'ABSPATH' ) || exit;

// ── Admin column ──────────────────────────────────────────────────────────────

add_filter( 'manage_post_posts_columns', function ( $columns ) {
    $new = [];
    foreach ( $columns as $key => $label ) {
        $new[ $key ] = $label;
        if ( $key === 'title' ) {
            $new['skyeye_featured'] = '<span title="Featured on blog listing">★</span>';
        }
    }
    return $new;
} );

add_action( 'manage_post_posts_custom_column', function ( $column, $post_id ) {
    if ( $column !== 'skyeye_featured' ) return;
    $featured_id = (int) get_option( '_skyeye_featured_post' );
    $active      = ( $featured_id === $post_id );
    printf(
        '<button class="skyeye-star-btn" data-post-id="%d" data-nonce="%s" title="%s" style="background:none;border:none;padding:2px;cursor:pointer;font-size:20px;line-height:1;color:%s;">★</button>',
        $post_id,
        wp_create_nonce( 'skyeye_feature_' . $post_id ),
        $active ? 'Remove from featured' : 'Set as featured post',
        $active ? '#bfab8b' : '#d0d0d0'
    );
}, 10, 2 );

add_action( 'admin_head', function () {
    global $typenow;
    if ( $typenow !== 'post' ) return;
    echo '<style>.column-skyeye_featured{width:44px;text-align:center!important;}</style>';
} );

// ── AJAX toggle ───────────────────────────────────────────────────────────────

add_action( 'wp_ajax_skyeye_feature_post', function () {
    $post_id = (int) ( $_POST['post_id'] ?? 0 );
    $nonce   = $_POST['nonce'] ?? '';

    if ( ! $post_id || ! wp_verify_nonce( $nonce, 'skyeye_feature_' . $post_id ) ) {
        wp_send_json_error( 'Invalid request' );
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        wp_send_json_error( 'Permission denied' );
    }

    $current = (int) get_option( '_skyeye_featured_post' );

    if ( $current === $post_id ) {
        update_option( '_skyeye_featured_post', 0 );
        wp_send_json_success( [
            'featured' => false,
            'nonce'    => wp_create_nonce( 'skyeye_feature_' . $post_id ),
        ] );
    }

    update_option( '_skyeye_featured_post', $post_id );
    wp_send_json_success( [
        'featured' => true,
        'old_id'   => $current,
        'nonce'    => wp_create_nonce( 'skyeye_feature_' . $post_id ),
    ] );
} );

add_action( 'admin_footer-edit.php', function () {
    global $typenow;
    if ( $typenow !== 'post' ) return;
    ?>
    <script>
    document.querySelectorAll('.skyeye-star-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var self   = this;
            var body   = new URLSearchParams({
                action:  'skyeye_feature_post',
                post_id: this.dataset.postId,
                nonce:   this.dataset.nonce,
            });
            fetch(ajaxurl, { method: 'POST', body: body })
                .then(function(r) { return r.json(); })
                .then(function(res) {
                    if (!res.success) return;
                    // Reset all stars first
                    document.querySelectorAll('.skyeye-star-btn').forEach(function(b) {
                        b.style.color = '#d0d0d0';
                        b.title = 'Set as featured post';
                    });
                    if (res.data.featured) {
                        self.style.color = '#bfab8b';
                        self.title = 'Remove from featured';
                    }
                    self.dataset.nonce = res.data.nonce;
                });
        });
    });
    </script>
    <?php
} );

// ── Front-end: exclude pinned post from main blog query ───────────────────────

add_action( 'pre_get_posts', function ( $query ) {
    if ( is_admin() || ! $query->is_main_query() || ! $query->is_home() ) return;

    $featured_id = (int) get_option( '_skyeye_featured_post' );
    if ( ! $featured_id ) return;

    $exclude = (array) ( $query->get( 'post__not_in' ) ?: [] );
    $query->set( 'post__not_in', array_merge( $exclude, [ $featured_id ] ) );
} );
