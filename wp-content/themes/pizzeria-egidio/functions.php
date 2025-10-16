<?php

/**
 * Theme Name: Pizzeria Egidio
 * Description: Tema personalizzato moderno per Pizzeria Egidio
 * Author: Mattia Filosa
 * Version: 1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Configurazione del tema
function pizzeria_egidio_setup()
{
    // Supporto per titolo del sito
    add_theme_support('title-tag');

    // Supporto per immagini in evidenza
    add_theme_support('post-thumbnails');

    // Supporto per HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Supporto per logo personalizzato
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Menu di navigazione
    register_nav_menus(array(
        'primary' => __('Menu Principale', 'pizzeria-egidio'),
        'footer'  => __('Menu Footer', 'pizzeria-egidio'),
    ));

    // Dimensioni immagini personalizzate
    add_image_size('hero-banner', 1920, 1080, true);
    add_image_size('pizza-special', 600, 400, true);
    add_image_size('menu-item', 300, 200, true);
    add_image_size('card-image', 400, 250, true);
}
add_action('after_setup_theme', 'pizzeria_egidio_setup');

function pizzeria_egidio_scripts()
{
    // Bebas Neue
    wp_enqueue_style(
        'pizzeria-egidio-bebas',
        'https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap',
        array(),
        null
    );

    // Altri font
    wp_enqueue_style(
        'pizzeria-egidio-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600;700&family=Dancing+Script:wght@400;700&family=Montserrat:wght@300;400;500;600;700&display=swap',
        array('pizzeria-egidio-bebas'),
        null
    );

    // Bootstrap Icons
    wp_enqueue_style(
        'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css',
        array(),
        null
    );

    // Bootstrap CSS (ultima versione via jsDelivr) 
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@latest/dist/css/bootstrap.min.css',
        array(),
        null
    );

    // Stile principale 
    wp_enqueue_style(
        'pizzeria-egidio-style',
        get_stylesheet_uri(),
        array('pizzeria-egidio-fonts', 'bootstrap-css', 'bootstrap-icons'),
        wp_get_theme()->get('Version')
    );

    // CSS responsive
    wp_enqueue_style(
        'pizzeria-egidio-responsive',
        get_template_directory_uri() . '/assets/css/responsive.css',
        array('pizzeria-egidio-style'),
        '1.0.0'
    );

    // CSS mobile menu 
    wp_enqueue_style(
        'pizzeria-egidio-mobile-menu',
        get_template_directory_uri() . '/assets/css/mobile-menu.css',
        array('pizzeria-egidio-style', 'pizzeria-egidio-responsive'),
        '1.0.0'
    );

    // Bootstrap JS (bundle include Popper) caricato in footer
wp_enqueue_script(
    'bootstrap-js',
    'https://cdn.jsdelivr.net/npm/bootstrap@latest/dist/js/bootstrap.bundle.min.js',
    array('jquery'),
    null,
    true
);

// JS principale - caricato DOPO Bootstrap per evitare conflitti
wp_enqueue_script(
    'pizzeria-egidio-script',
    get_template_directory_uri() . '/assets/js/main.js',
    array('jquery', 'bootstrap-js'),
    '1.0.2',
    true
);

    // Localizzazione AJAX
    wp_localize_script('pizzeria-egidio-script', 'pizzeria_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('pizzeria_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'pizzeria_egidio_scripts');


// Widget areas
function pizzeria_egidio_widgets_init()
{
    register_sidebar(array(
        'name'          => __('Footer Widget 1', 'pizzeria-egidio'),
        'id'            => 'footer-1',
        'description'   => __('Widget area per il footer', 'pizzeria-egidio'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget 2', 'pizzeria-egidio'),
        'id'            => 'footer-2',
        'description'   => __('Widget area per il footer', 'pizzeria-egidio'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget 3', 'pizzeria-egidio'),
        'id'            => 'footer-3',
        'description'   => __('Widget area per il footer', 'pizzeria-egidio'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'pizzeria_egidio_widgets_init');

// Custom Post Types
function pizzeria_egidio_custom_post_types()
{
    // Post Type per le Pizze
    register_post_type('pizza', array(
        'labels' => array(
            'name'          => __('Pizze', 'pizzeria-egidio'),
            'singular_name' => __('Pizza', 'pizzeria-egidio'),
            'add_new'       => __('Aggiungi Pizza', 'pizzeria-egidio'),
            'add_new_item'  => __('Aggiungi Nuova Pizza', 'pizzeria-egidio'),
            'edit_item'     => __('Modifica Pizza', 'pizzeria-egidio'),
            'new_item'      => __('Nuova Pizza', 'pizzeria-egidio'),
            'view_item'     => __('Visualizza Pizza', 'pizzeria-egidio'),
            'search_items'  => __('Cerca Pizze', 'pizzeria-egidio'),
        ),
        'public'        => true,
        'has_archive'   => false,
        'menu_icon'     => 'dashicons-food',
        'supports'      => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'  => true,
    ));

    // Tassonomia per Categorie Pizza
    register_taxonomy('pizza_category', 'pizza', array(
        'labels' => array(
            'name'          => __('Categorie Pizza', 'pizzeria-egidio'),
            'singular_name' => __('Categoria Pizza', 'pizzeria-egidio'),
        ),
        'public'       => true,
        'hierarchical' => true,
        'show_in_rest' => true,
    ));
}
add_action('init', 'pizzeria_egidio_custom_post_types');

// Metabox per dati aggiuntivi delle pizze
function pizzeria_egidio_add_pizza_metaboxes()
{
    add_meta_box(
        'pizza_details',
        __('Dettagli Pizza', 'pizzeria-egidio'),
        'pizzeria_egidio_pizza_details_callback',
        'pizza',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'pizzeria_egidio_add_pizza_metaboxes');

function pizzeria_egidio_pizza_details_callback($post)
{
    wp_nonce_field('pizzeria_egidio_save_pizza_details', 'pizzeria_egidio_pizza_nonce');

    $price = get_post_meta($post->ID, '_pizza_price', true);
    $ingredients = get_post_meta($post->ID, '_pizza_ingredients', true);
    $is_special = get_post_meta($post->ID, '_pizza_is_special', true);
?>
    <table class="form-table">
        <tr>
            <th><label for="pizza_price"><?php _e('Prezzo', 'pizzeria-egidio'); ?></label></th>
            <td><input type="text" id="pizza_price" name="pizza_price" value="<?php echo esc_attr($price); ?>" /> €</td>
        </tr>
        <tr>
            <th><label for="pizza_ingredients"><?php _e('Ingredienti', 'pizzeria-egidio'); ?></label></th>
            <td><textarea id="pizza_ingredients" name="pizza_ingredients" rows="3" cols="50"><?php echo esc_textarea($ingredients); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="pizza_is_special"><?php _e('Pizza Speciale', 'pizzeria-egidio'); ?></label></th>
            <td><input type="checkbox" id="pizza_is_special" name="pizza_is_special" value="1" <?php checked($is_special, 1); ?> /></td>
        </tr>
    </table>
<?php
}

function pizzeria_egidio_save_pizza_details($post_id)
{
    if (!isset($_POST['pizzeria_egidio_pizza_nonce']) || !wp_verify_nonce($_POST['pizzeria_egidio_pizza_nonce'], 'pizzeria_egidio_save_pizza_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['pizza_price'])) {
        update_post_meta($post_id, '_pizza_price', sanitize_text_field($_POST['pizza_price']));
    }

    if (isset($_POST['pizza_ingredients'])) {
        update_post_meta($post_id, '_pizza_ingredients', sanitize_textarea_field($_POST['pizza_ingredients']));
    }

    $is_special = isset($_POST['pizza_is_special']) ? 1 : 0;
    update_post_meta($post_id, '_pizza_is_special', $is_special);
}
add_action('save_post', 'pizzeria_egidio_save_pizza_details');

// Customizer
function pizzeria_egidio_customize_register($wp_customize)
{
    // Sezione Hero
    $wp_customize->add_section('hero_section', array(
        'title'    => __('Hero Banner', 'pizzeria-egidio'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('hero_title', array(
        'default'           => 'Pizzeria Egidio',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'   => __('Titolo Hero', 'pizzeria-egidio'),
        'section' => 'hero_section',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => 'Tradizione nel nome, innovazione nel piatto',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label'   => __('Sottotitolo Hero', 'pizzeria-egidio'),
        'section' => 'hero_section',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('hero_description', array(
        'default'           => 'Nel cuore di Piombino, dove la tradizione incontra l\'innovazione per offrirti la pizza più buona e digeribile della città.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('hero_description', array(
        'label'   => __('Descrizione Hero', 'pizzeria-egidio'),
        'section' => 'hero_section',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('hero_button_text', array(
        'default'           => 'Scopri il Menù',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_button_text', array(
        'label'   => __('Testo Pulsante Hero', 'pizzeria-egidio'),
        'section' => 'hero_section',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('hero_button_url', array(
        'default'           => '#menu',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('hero_button_url', array(
        'label'   => __('URL Pulsante Hero', 'pizzeria-egidio'),
        'section' => 'hero_section',
        'type'    => 'url',
    ));

    // Sezione Contatti
    $wp_customize->add_section('contact_section', array(
        'title'    => __('Informazioni Contatto', 'pizzeria-egidio'),
        'priority' => 40,
    ));

    $wp_customize->add_setting('contact_phone', array(
        'default'           => '+39 0565 123456',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_phone', array(
        'label'   => __('Telefono', 'pizzeria-egidio'),
        'section' => 'contact_section',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('contact_email', array(
        'default'           => 'info@pizzeriaegidio.it',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('contact_email', array(
        'label'   => __('Email', 'pizzeria-egidio'),
        'section' => 'contact_section',
        'type'    => 'email',
    ));

    $wp_customize->add_setting('contact_address', array(
        'default'           => 'Via Roma 123, 57025 Piombino (LI)',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_address', array(
        'label'   => __('Indirizzo', 'pizzeria-egidio'),
        'section' => 'contact_section',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('opening_hours', array(
        'default'           => "Martedì - Domenica: 19:00 - 24:00\nLunedì: Chiuso",
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('opening_hours', array(
        'label'   => __('Orari di Apertura', 'pizzeria-egidio'),
        'section' => 'contact_section',
        'type'    => 'textarea',
    ));
}
add_action('customize_register', 'pizzeria_egidio_customize_register');

// Funzioni helper
function pizzeria_egidio_get_pizzas($category = '', $limit = -1, $special_only = false)
{
    $args = array(
        'post_type'      => 'pizza',
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );

    if ($special_only) {
        $args['meta_query'] = array(
            array(
                'key'     => '_pizza_is_special',
                'value'   => '1',
                'compare' => '='
            )
        );
    }

    if (!empty($category)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'pizza_category',
                'field'    => 'slug',
                'terms'    => $category,
            )
        );
    }

    return new WP_Query($args);
}

function pizzeria_egidio_get_pizza_price($post_id)
{
    $price = get_post_meta($post_id, '_pizza_price', true);
    return $price ? $price . ' €' : '';
}

function pizzeria_egidio_get_pizza_ingredients($post_id)
{
    return get_post_meta($post_id, '_pizza_ingredients', true);
}

function pizzeria_egidio_is_special_pizza($post_id)
{
    return get_post_meta($post_id, '_pizza_is_special', true) == '1';
}

// Funzione per gestire immagini tema con fallback
function pizzeria_egidio_get_theme_image($image_name, $alt_text = '', $class = '')
{
    $image_path = get_template_directory_uri() . '/assets/images/' . $image_name;
    $image_file = get_template_directory() . '/assets/images/' . $image_name;

    // Controlla se l'immagine esiste
    if (file_exists($image_file)) {
        return '<img src="' . esc_url($image_path) . '" alt="' . esc_attr($alt_text) . '" class="' . esc_attr($class) . '" />';
    } else {
        // Ritorna placeholder
        $placeholder_class = $class . ' image-placeholder';
        return '<div class="' . esc_attr($placeholder_class) . '" style="width: 100%; height: 300px;" aria-label="' . esc_attr($alt_text) . '">
                    <div style="text-align: center; padding: 2rem;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🍕</div>
                        <div style="color: var(--gray-medium);">Immagine in arrivo...</div>
                        <small style="opacity: 0.7;">' . esc_html($alt_text) . '</small>
                    </div>
                </div>';
    }
}

// Breadcrumbs
function pizzeria_egidio_breadcrumbs()
{
    if (is_home() || is_front_page()) return;

    echo '<nav class="breadcrumbs" aria-label="breadcrumb">';
    echo '<div class="container">';
    echo '<a href="' . home_url('/') . '">Home</a>';

    if (is_page()) {
        $ancestors = get_post_ancestors(get_the_ID());
        $ancestors = array_reverse($ancestors);

        foreach ($ancestors as $ancestor) {
            echo ' <span class="separator">/</span> <a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a>';
        }
        echo ' <span class="separator">/</span> <span class="current">' . get_the_title() . '</span>';
    } elseif (is_single()) {
        $post_type = get_post_type();
        if ($post_type == 'pizza') {
            echo ' <span class="separator">/</span> <a href="' . home_url('/menu/') . '">Menu</a>';
        }
        echo ' <span class="separator">/</span> <span class="current">' . get_the_title() . '</span>';
    } elseif (is_category() || is_tag() || is_tax()) {
        echo ' <span class="separator">/</span> <span class="current">' . single_term_title('', false) . '</span>';
    }

    echo '</div>';
    echo '</nav>';
}
?>