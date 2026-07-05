<?php
/**
 * One-time setup tool — accessible from WP Admin → Tools → Sky Eye Setup
 * DELETE this file and remove the require_once from functions.php after setup is complete.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', function () {
    add_management_page(
        'Sky Eye Setup',
        'Sky Eye Setup',
        'manage_options',
        'skyeye-setup',
        'skyeye_setup_tool_page'
    );
} );

function skyeye_setup_tool_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $action = $_POST['skyeye_action'] ?? '';
    $nonce  = $_POST['skyeye_nonce'] ?? '';
    $log    = [];

    if ( $action && wp_verify_nonce( $nonce, 'skyeye_setup' ) ) {
        if ( $action === 'fix_menus' ) {
            $log = skyeye_run_fix_menus();
        } elseif ( $action === 'import_gf' ) {
            $log = skyeye_run_import_gf();
        } elseif ( $action === 'create_blog' ) {
            $log = skyeye_run_create_blog();
        }
    }

    ?>
    <div class="wrap">
        <h1>Sky Eye Setup Tool</h1>
        <p style="color:#666;">Run each action once, then delete <code>inc/setup-tool.php</code> and remove it from <code>functions.php</code>.</p>

        <?php if ( $log ) : ?>
        <div class="notice notice-info" style="padding:12px 16px;">
            <?php foreach ( $log as $line ) : ?>
                <p style="margin:4px 0;font-family:monospace;"><?php echo esc_html( $line ); ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <hr>

        <h2>1. Fix Navigation Menus</h2>
        <p>Creates Primary and Footer navigation menus with Home, About, Portfolio, Contact links.</p>
        <form method="post">
            <?php wp_nonce_field( 'skyeye_setup', 'skyeye_nonce' ); ?>
            <input type="hidden" name="skyeye_action" value="fix_menus">
            <button class="button button-primary">Run: Fix Menus</button>
        </form>

        <hr>

        <h2>2. Import Gravity Form</h2>
        <p>Imports the "Get in touch" contact form and wires it to the home and contact pages.</p>
        <form method="post">
            <?php wp_nonce_field( 'skyeye_setup', 'skyeye_nonce' ); ?>
            <input type="hidden" name="skyeye_action" value="import_gf">
            <button class="button button-primary">Run: Import Form</button>
        </form>

        <hr>

        <h2>3. Create Blog &amp; Sample Posts</h2>
        <p>Creates a Blog page, sets it as the Posts Page in Settings → Reading, creates 3 post categories, and inserts 7 sample posts with lorem ipsum content. Run once — safe to re-run (skips posts that already exist).</p>
        <p><strong>After running:</strong> Go to Appearance → Menus and add the "Blog" page to your navigation.</p>
        <form method="post">
            <?php wp_nonce_field( 'skyeye_setup', 'skyeye_nonce' ); ?>
            <input type="hidden" name="skyeye_action" value="create_blog">
            <button class="button button-primary">Run: Create Blog &amp; Posts</button>
        </form>
    </div>
    <?php
}

function skyeye_run_fix_menus() {
    $log   = [];
    $pages = [
        'Home'      => get_page_by_path( 'home' ),
        'About'     => get_page_by_path( 'about' ),
        'Portfolio' => get_page_by_path( 'portfolio' ),
        'Contact'   => get_page_by_path( 'contact' ),
    ];

    foreach ( $pages as $label => $page ) {
        if ( ! $page ) {
            $log[] = "ERROR: Page not found: $label";
            return $log;
        }
        $log[] = "Found page: $label (ID {$page->ID})";
    }

    // Delete existing menus
    foreach ( wp_get_nav_menus() as $menu ) {
        wp_delete_nav_menu( $menu->term_id );
        $log[] = "Deleted existing menu: {$menu->name}";
    }

    // Primary Navigation
    $primary_id = wp_create_nav_menu( 'Primary Navigation' );
    $log[] = "Created Primary Navigation (ID $primary_id)";
    foreach ( $pages as $label => $page ) {
        wp_update_nav_menu_item( $primary_id, 0, [
            'menu-item-title'     => $label,
            'menu-item-object-id' => $page->ID,
            'menu-item-object'    => 'page',
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
        ] );
        $log[] = "  Added: $label";
    }

    // Footer Navigation
    $footer_id = wp_create_nav_menu( 'Footer Navigation' );
    $log[] = "Created Footer Navigation (ID $footer_id)";
    foreach ( $pages as $label => $page ) {
        wp_update_nav_menu_item( $footer_id, 0, [
            'menu-item-title'     => $label,
            'menu-item-object-id' => $page->ID,
            'menu-item-object'    => 'page',
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
        ] );
        $log[] = "  Added: $label";
    }

    // Assign locations
    $locations             = get_theme_mod( 'nav_menu_locations', [] );
    $locations['primary']  = $primary_id;
    $locations['footer']   = $footer_id;
    set_theme_mod( 'nav_menu_locations', $locations );
    $log[] = 'Assigned menus to theme locations.';
    $log[] = 'DONE: Navigation menus created successfully.';

    return $log;
}

function skyeye_run_import_gf() {
    $log = [];

    if ( ! class_exists( 'GFAPI' ) ) {
        $log[] = 'ERROR: Gravity Forms is not active.';
        return $log;
    }

    // Check if form already exists
    foreach ( GFAPI::get_forms() as $f ) {
        if ( $f['title'] === 'Get in touch' ) {
            $log[] = "Form already exists: 'Get in touch' (ID {$f['id']})";
            skyeye_wire_form_id( $f['id'], $log );
            return $log;
        }
    }

    $form = [
        'title'         => 'Get in touch',
        'description'   => '',
        'version'       => '2.9.5',
        'markupVersion' => 2,
        'button'        => [
            'type'     => 'text',
            'text'     => 'Submit enquiry',
            'imageUrl' => '',
            'width'    => 'auto',
            'location' => 'bottom',
            'layoutGridColumnSpan' => 12,
            'id'       => 'submit',
        ],
        'confirmations' => [
            '6a4149c6deed9' => [
                'id'        => '6a4149c6deed9',
                'name'      => 'Default Confirmation',
                'isDefault' => true,
                'type'      => 'message',
                'message'   => 'Thanks for contacting us! We will get in touch with you shortly.',
                'url'       => '',
                'pageId'    => '',
                'queryString' => '',
            ],
        ],
        'notifications' => [
            '6a4149c6de03b' => [
                'id'      => '6a4149c6de03b',
                'isActive' => true,
                'to'      => '{admin_email}',
                'name'    => 'Admin Notification',
                'event'   => 'form_submission',
                'toType'  => 'email',
                'subject' => 'New submission from {form_title}',
                'message' => '{all_fields}',
            ],
        ],
        'fields' => [
            [ 'type' => 'name',     'id' => 10, 'label' => 'First name',                       'isRequired' => false, 'size' => 'large', 'nameFormat' => 'advanced', 'cssClass' => 'gf-half', 'layoutGridColumnSpan' => 6,  'layoutGroupId' => '90389e7e', 'inputs' => [ ['id'=>'10.2','label'=>'Prefix','isHidden'=>true,'inputType'=>'radio'], ['id'=>'10.3','label'=>'First','customLabel'=>'First name'], ['id'=>'10.4','label'=>'Middle','isHidden'=>true], ['id'=>'10.6','label'=>'Last','isHidden'=>true], ['id'=>'10.8','label'=>'Suffix','isHidden'=>true] ], 'pageNumber' => 1 ],
            [ 'type' => 'name',     'id' => 1,  'label' => 'Last name',                        'isRequired' => true,  'size' => 'large', 'nameFormat' => 'advanced', 'cssClass' => 'gf-half', 'layoutGridColumnSpan' => 6,  'layoutGroupId' => '90389e7e', 'inputs' => [ ['id'=>'1.2','label'=>'Prefix','isHidden'=>true,'inputType'=>'radio'], ['id'=>'1.3','label'=>'First','isHidden'=>true], ['id'=>'1.4','label'=>'Middle','isHidden'=>true], ['id'=>'1.6','label'=>'Last','isHidden'=>false,'customLabel'=>'Last name'], ['id'=>'1.8','label'=>'Suffix','isHidden'=>true] ], 'pageNumber' => 1 ],
            [ 'type' => 'email',    'id' => 3,  'label' => 'Email',                            'isRequired' => true,  'size' => 'large', 'layoutGroupId' => 'df366be0', 'pageNumber' => 1 ],
            [ 'type' => 'phone',    'id' => 4,  'label' => 'Phone',                            'isRequired' => false, 'size' => 'large', 'phoneFormat' => 'international', 'layoutGridColumnSpan' => 12, 'layoutGroupId' => '3ff7fc12', 'pageNumber' => 1 ],
            [ 'type' => 'date',     'id' => 5,  'label' => 'Wedding date',                     'isRequired' => false, 'size' => 'large', 'dateType' => 'datepicker', 'dateFormat' => 'mdy', 'calendarIconType' => 'none', 'layoutGroupId' => 'af54d0df', 'pageNumber' => 1 ],
            [ 'type' => 'text',     'id' => 6,  'label' => 'Photographers name (if booked)',   'isRequired' => false, 'size' => 'large', 'layoutGroupId' => 'ea9409da', 'pageNumber' => 1 ],
            [ 'type' => 'text',     'id' => 8,  'label' => 'How did you hear about us?',       'isRequired' => false, 'size' => 'large', 'layoutGroupId' => '5d7a4a46', 'pageNumber' => 1 ],
            [ 'type' => 'textarea', 'id' => 9,  'label' => 'Tell us a little about your big day?', 'isRequired' => true, 'size' => 'large', 'layoutGroupId' => '3c4ccb0e', 'pageNumber' => 1 ],
        ],
        'is_active' => '1',
        'is_trash'  => '0',
    ];

    $form_id = GFAPI::add_form( $form );
    if ( is_wp_error( $form_id ) ) {
        $log[] = 'ERROR: ' . $form_id->get_error_message();
        return $log;
    }
    $log[] = "Created form 'Get in touch' (ID $form_id)";
    skyeye_wire_form_id( $form_id, $log );

    return $log;
}

function skyeye_run_create_blog() {
    $log = [];

    // ── 1. Create / find Blog page ──────────────────────────────────────
    $blog_page = get_page_by_path( 'blog' );
    if ( ! $blog_page ) {
        $blog_page_id = wp_insert_post( [
            'post_title'  => 'Blog',
            'post_name'   => 'blog',
            'post_status' => 'publish',
            'post_type'   => 'page',
        ] );
        if ( is_wp_error( $blog_page_id ) ) {
            $log[] = 'ERROR creating Blog page: ' . $blog_page_id->get_error_message();
            return $log;
        }
        $log[] = "Created Blog page (ID $blog_page_id)";
    } else {
        $blog_page_id = $blog_page->ID;
        $log[] = "Blog page already exists (ID $blog_page_id)";
    }

    // ── 2. Set as Posts Page ────────────────────────────────────────────
    update_option( 'show_on_front', 'page' );
    update_option( 'page_for_posts', $blog_page_id );
    $log[] = 'Set Blog page as Posts Page in Settings → Reading';

    // ── 3. Create categories ────────────────────────────────────────────
    $categories = [
        'Tips & Advice'    => 'tips-advice',
        'Behind the Scenes' => 'behind-the-scenes',
        'Inspiration'      => 'inspiration',
    ];
    $cat_ids = [];
    foreach ( $categories as $name => $slug ) {
        $existing = get_term_by( 'slug', $slug, 'category' );
        if ( $existing ) {
            $cat_ids[ $slug ] = $existing->term_id;
            $log[] = "Category already exists: $name";
        } else {
            $result = wp_insert_term( $name, 'category', [ 'slug' => $slug ] );
            if ( is_wp_error( $result ) ) {
                $log[] = "ERROR creating category $name: " . $result->get_error_message();
            } else {
                $cat_ids[ $slug ] = $result['term_id'];
                $log[] = "Created category: $name";
            }
        }
    }

    // ── 4. Sample posts ─────────────────────────────────────────────────
    $posts = [
        [
            'title'    => 'How to Choose the Right Wedding Videographer',
            'slug'     => 'how-to-choose-wedding-videographer',
            'cat'      => 'tips-advice',
            'date'     => '2026-06-15 10:00:00',
            'content'  => <<<'HTML'
<p>Choosing the right wedding videographer is one of the most important decisions you'll make for your big day. Unlike photographs, a wedding film captures the movement, laughter, and emotion of the day in a way that stills simply can't replicate — the nervous laugh before the ceremony, the way your partner's face changed when they saw you walk down the aisle, the sound of your guests erupting in applause.</p>

<p>Before beginning your search, take some time to think about the style of film you'd love. Do you prefer a natural, documentary approach that feels authentic and unposed? Or something more cinematic, with dramatic edits and sweeping drone shots? Spending an hour watching wedding films online will help you identify exactly what resonates with you.</p>

<blockquote><p>The best wedding videographers don't just record your day — they tell your love story in a way that will move you to tears every time you watch it.</p></blockquote>

<h3>Ask to see full films, not just highlights</h3>
<p>Most videographers showcase their very best work on social media — highlight reels set to beautiful music that make everything look incredible. Before you book anyone, always ask to see a full wedding film from start to finish. This will give you a true sense of how they structure a story, handle quieter moments, and edit the day as a whole.</p>

<h4>Key questions to ask at your consultation</h4>
<p>When you meet with a potential videographer, come prepared with questions. Ask how they work in different lighting conditions, how they handle unexpected moments, and what their backup plan is if equipment fails. A confident, well-prepared filmmaker will have clear answers to all of these.</p>

<p>Trust your instincts. Your videographer will be close to you for your entire wedding day — you need to feel genuinely comfortable in their presence. The most beautiful wedding films come from couples who forgot the camera was even there.</p>
HTML,
        ],
        [
            'title'    => 'Behind the Scenes: A Kerry Castle Wedding',
            'slug'     => 'behind-the-scenes-kerry-castle-wedding',
            'cat'      => 'behind-the-scenes',
            'date'     => '2026-05-28 10:00:00',
            'content'  => <<<'HTML'
<p>When Rachel and Ciarán got in touch about filming their wedding at a castle on the Ring of Kerry, we knew this was going to be a special one. The venue sits at the edge of a glacial lake, surrounded by ancient oak forests and the MacGillycuddy's Reeks rising behind — a backdrop that no set designer could ever manufacture.</p>

<p>We arrived the day before to scout the grounds. Stone corridors, arched windows, and a candlelit great hall offered incredible visual opportunities at every turn. We mapped the light through each room at different times of day so there would be no surprises on the morning of the wedding itself.</p>

<blockquote><p>There's something uniquely magical about filming in an Irish castle. Every frame carries centuries of history alongside a brand new love story.</p></blockquote>

<h3>The morning of the wedding</h3>
<p>Bridal preparations took place in a suite overlooking the lake. The morning light through those south-facing windows was extraordinary — soft, golden, and completely flattering. We spent two hours capturing the quiet moments: the dress hanging by the window, friends laughing over champagne, Rachel's mother fastening the last button on her gown.</p>

<h4>The ceremony</h4>
<p>The ceremony was held in the castle's private chapel, which seats just eighty guests. With limited space for movement, we worked with two cameras — one static on a tripod for the wide shot, one handheld for close moments. The echo of the vows in that stone chamber was extraordinary, and every word was captured perfectly.</p>

<p>The sunset reception on the castle terrace gave us the golden hour conditions that wedding filmmakers dream about. Looking back on Rachel and Ciarán's final film, it's one of those projects we'll be proud of for a very long time.</p>
HTML,
        ],
        [
            'title'    => 'Top 5 Wedding Film Styles Explained',
            'slug'     => 'top-5-wedding-film-styles-explained',
            'cat'      => 'tips-advice',
            'date'     => '2026-05-10 10:00:00',
            'content'  => <<<'HTML'
<p>When you start looking for a wedding videographer, you'll quickly notice that different filmmakers have very different visual styles. Understanding the key styles before you start your search will help you find a videographer who matches exactly what you're imagining for your wedding film.</p>

<h3>1. Cinematic</h3>
<p>The cinematic style treats your wedding like a short film. Expect carefully composed shots, dramatic lighting, and a highly edited sequence that prioritises visual beauty over a strict chronological account of the day. These films often feel epic and emotional, with sweeping music to match. They look extraordinary — but they require a videographer who truly thinks like a filmmaker.</p>

<h3>2. Documentary</h3>
<p>Documentary-style wedding films capture the day as it unfolds, with minimal intervention from the filmmaker. The result feels authentic and real — full of genuine laughter, candid moments, and the natural chaos of a wedding day. If you want to look back and feel like you're reliving the day exactly as it happened, this style might be for you.</p>

<h3>3. Aerial / Drone</h3>
<p>Many modern wedding films incorporate drone footage to establish a sense of place and scale. Whether it's sweeping over a clifftop ceremony or rising above a country house in the evening light, aerial footage adds a cinematic dimension that ground-level cameras simply can't achieve.</p>

<blockquote><p>The best wedding films combine visual beauty with genuine emotion — technique serves the story, never the other way around.</p></blockquote>

<h3>4. Same-day edit</h3>
<p>A same-day edit is a highlights film cut and presented at your evening reception. It requires a second editing team and a very fast turnaround, but watching a short film of your own wedding day while you're still there is an extraordinary experience for you and your guests.</p>

<h3>5. Raw or minimalist</h3>
<p>Some couples prefer a quieter, more minimal approach — long takes, natural sound, and restraint in the edit. These films have a slow, meditative quality that can be deeply moving. Think of them as the cinematic equivalent of black and white photography.</p>
HTML,
        ],
        [
            'title'    => 'Why Golden Hour Makes Wedding Films Magical',
            'slug'     => 'why-golden-hour-makes-wedding-films-magical',
            'cat'      => 'inspiration',
            'date'     => '2026-04-22 10:00:00',
            'content'  => <<<'HTML'
<p>If you ask any wedding filmmaker about their favourite moment to shoot, almost all of them will say the same thing: golden hour. That magical window of time shortly after sunrise or just before sunset, when the sun sits low on the horizon and bathes everything in warm, honey-coloured light.</p>

<p>Wedding days are long, and the light changes constantly. But for those twenty to forty minutes when the sun descends toward the horizon, something transforms. Skin glows. Shadows become soft and long. Colours deepen. And the whole world seems to slow down just a little.</p>

<blockquote><p>Golden hour doesn't just look beautiful on film — it feels beautiful. Couples who step outside for those few minutes almost always say it was the most peaceful moment of their entire wedding day.</p></blockquote>

<h3>Planning around the light</h3>
<p>We always check sunset times for your wedding date and location when we begin planning together. If your venue allows, we love to schedule a dedicated twenty-minute "golden hour escape" — just the two of you, away from your guests, in the best light of the day. These moments consistently produce some of the most beautiful footage of the entire film.</p>

<h4>What if there's no golden hour?</h4>
<p>Ireland's weather doesn't always cooperate, and that's completely fine. Overcast skies produce soft, even light that's actually very flattering on camera. Rain on a wedding day can create extraordinary atmospheric shots. We've filmed in every condition imaginable, and every Irish sky has its own kind of beauty.</p>

<p>Whatever the weather brings, the emotion of your day is what makes the film. Light is just one ingredient — and it's one we always make the most of, whatever we're given.</p>
HTML,
        ],
        [
            'title'    => 'A Destination Wedding on the Wild Atlantic Way',
            'slug'     => 'destination-wedding-wild-atlantic-way',
            'cat'      => 'behind-the-scenes',
            'date'     => '2026-04-05 10:00:00',
            'content'  => <<<'HTML'
<p>Some weddings feel like they were made to be filmed. Sarah and Eoin's wedding on the Wild Atlantic Way was one of those. With a ceremony on a cliff edge overlooking the Atlantic Ocean and a reception in a converted stone barn with views to the Aran Islands, every frame of their film felt like a landscape painting come to life.</p>

<p>Destination weddings on Ireland's west coast require a different kind of preparation. We researched the location extensively — studying the cliff access, identifying drone flight restrictions, and planning for the near-certainty of wind. When you're filming somewhere that dramatic, you need to be ready for absolutely anything.</p>

<h3>The ceremony</h3>
<p>The outdoor ceremony took place on a natural rock platform, with the Atlantic crashing against the cliffs fifty metres below. The wind made audio challenging, but we had prepared with a directional microphone positioned near the officiant and a backup lapel microphone on the groom. Not a single word of the ceremony was lost.</p>

<blockquote><p>When Sarah walked across that clifftop in her gown, with the ocean stretching to the horizon behind her, there was a collective intake of breath from every guest. And we had it all on film.</p></blockquote>

<h4>Aerial footage</h4>
<p>The drone footage from this wedding is some of the most spectacular we've ever captured. Rising above the clifftop ceremony, pulling back to reveal the full scale of the Atlantic, then sweeping along the coastline as the couple shared their first kiss. Nature provided a backdrop that no studio could ever recreate.</p>

<p>Sarah and Eoin's film is one that reminds us exactly why we love what we do. Ireland's west coast is one of the most cinematically extraordinary places in the world, and we feel incredibly lucky to document love stories here.</p>
HTML,
        ],
        [
            'title'    => 'What to Discuss with Your Videographer Before the Big Day',
            'slug'     => 'what-to-discuss-with-your-videographer',
            'cat'      => 'tips-advice',
            'date'     => '2026-03-18 10:00:00',
            'content'  => <<<'HTML'
<p>A great wedding film starts long before the camera rolls. The conversations you have with your videographer in the weeks leading up to your wedding can make the difference between a film that captures your day perfectly and one that misses the moments that matter most to you.</p>

<p>Every couple is different. Some want to be guided through the day with specific shot suggestions; others prefer a more invisible approach where the camera captures whatever unfolds naturally. Communicating your preferences clearly will help your videographer deliver exactly what you're imagining.</p>

<h3>Key things to cover</h3>
<p>Share your schedule in as much detail as possible — ceremony time, location, reception venue, and expected timings for speeches and first dance. The more your videographer knows about the structure of the day, the better they can plan their coverage and be in the right place at the right moment.</p>

<h4>Moments that matter most to you</h4>
<p>Think about the specific moments you absolutely don't want to miss. Is it your father's speech? A particular friend who's flown in from abroad? A family member who hasn't been well? These things matter deeply, and your videographer can only prioritise them if they know in advance.</p>

<blockquote><p>The best wedding films reflect the personalities of the couple. Tell your videographer who you are — your story, your humour, what makes you laugh. That's the film they'll make.</p></blockquote>

<h3>Music preferences</h3>
<p>Music shapes the emotional experience of a wedding film more than almost anything else. Share playlists, specific songs, or even genres that feel like "you" as a couple. Whether you want something sweeping and orchestral or something more indie and understated, your videographer needs to know before the edit begins.</p>

<p>Finally, exchange personal phone numbers and confirm the morning-of plan in detail. Know exactly where and when your videographer will arrive, and make sure your bridal party is aware too. The calmer and more organised the morning, the more space there is for beautiful, unhurried footage.</p>
HTML,
        ],
        [
            'title'    => 'Our Favourite Wedding Venues in Ireland for Film',
            'slug'     => 'favourite-wedding-venues-ireland-for-film',
            'cat'      => 'inspiration',
            'date'     => '2026-02-28 10:00:00',
            'content'  => <<<'HTML'
<p>After filming weddings across the island of Ireland, we've developed a deep appreciation for the venues that translate beautifully to film — places where every corner offers a new visual possibility, where light moves through rooms in interesting ways, and where the surrounding landscape adds depth and drama to every frame.</p>

<p>Here are some of our favourite types of Irish venues to film at, and what makes each of them special from a filmmaker's perspective.</p>

<h3>Lakeside castle hotels</h3>
<p>Kerry and the west of Ireland are home to some of Europe's most dramatic castle hotels. These venues offer centuries of architectural beauty — stone turrets, arched doorways, candlelit dining rooms, and grounds that change character completely with the seasons. The juxtaposition of ancient stone and a modern wedding is visually extraordinary, and the surrounding landscape provides natural backdrops at every turn.</p>

<h3>Country house estates</h3>
<p>Ireland's country house estates offer a more intimate scale than grand castles, often with formal walled gardens, glasshouses, and rolling parkland. The interiors — with their period furniture, fireplaces, and original artwork — are rich with visual detail that rewards a thoughtful camera. And the golden light through estate windows in the late afternoon is simply unforgettable.</p>

<blockquote><p>Some of our most beautiful footage has been captured not at famous venues, but at small family farms and restored barns where the surroundings feel genuinely personal to the couple.</p></blockquote>

<h3>Clifftop and coastal venues</h3>
<p>If you want drama in your wedding film, marry near the sea. Ireland's coastline — from the Causeway Coast in the north to the Dingle Peninsula in the south — offers scenery that is truly world-class. Drone footage above cliffs and over breaking waves gives a sense of scale and romance that no other setting can match.</p>

<h4>Restored barns and farm venues</h4>
<p>In recent years, restored barn venues have become some of the most popular and most photogenic wedding settings in Ireland. With their exposed timber beams, fairy lights, and connection to the working landscape around them, they feel both rustic and deeply romantic. The surrounding countryside almost always provides extraordinary light at golden hour.</p>

<p>Whatever venue you choose, the most important thing is that it feels genuinely like you. The best wedding films are made with love for the people in them — not just the places around them.</p>
HTML,
        ],
    ];

    foreach ( $posts as $p ) {
        if ( get_page_by_path( $p['slug'], OBJECT, 'post' ) ) {
            $log[] = "Post already exists, skipping: {$p['title']}";
            continue;
        }

        $cat_id = isset( $cat_ids[ $p['cat'] ] ) ? [ $cat_ids[ $p['cat'] ] ] : [];

        $post_id = wp_insert_post( [
            'post_title'    => $p['title'],
            'post_name'     => $p['slug'],
            'post_content'  => $p['content'],
            'post_status'   => 'publish',
            'post_type'     => 'post',
            'post_date'     => $p['date'],
            'post_date_gmt' => get_gmt_from_date( $p['date'] ),
            'post_category' => $cat_id,
        ] );

        if ( is_wp_error( $post_id ) ) {
            $log[] = "ERROR creating post '{$p['title']}': " . $post_id->get_error_message();
        } else {
            $log[] = "Created post: {$p['title']} (ID $post_id)";
        }
    }

    $log[] = 'DONE: Blog setup complete. Add the Blog page to your navigation via Appearance → Menus.';
    return $log;
}

function skyeye_wire_form_id( $form_id, &$log ) {
    $home_id    = (int) get_option( 'page_on_front' );
    $contact    = get_page_by_path( 'contact' );
    $contact_id = $contact ? $contact->ID : 0;

    // Find form_section row index in flexible content
    if ( $home_id && have_rows( 'page_builder', $home_id ) ) {
        $idx = 0;
        while ( have_rows( 'page_builder', $home_id ) ) {
            the_row();
            if ( get_row_layout() === 'form_section' ) {
                update_post_meta( $home_id, "page_builder_{$idx}_form_id", $form_id );
                update_post_meta( $home_id, "_page_builder_{$idx}_form_id", 'field_pb_form_id' );
                $log[] = "  Wired home page_builder_{$idx}_form_id → $form_id";
            }
            $idx++;
        }
    }

    if ( $contact_id ) {
        update_post_meta( $contact_id, 'form_id', $form_id );
        update_post_meta( $contact_id, '_form_id', 'field_cp_form_id' );
        $log[] = "  Wired contact page form_id → $form_id";
    }

    $log[] = 'DONE: Form wired to pages.';
}
