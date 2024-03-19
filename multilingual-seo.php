<?php

/*
 * Plugin Name:       Multilingual SEO
 * Plugin URI:        https://web-nancy.fr
 * Description:       Translate SEO fields for free using TranslatePress.
 * Version:           1.0
 * Requires at least: 6.4
 * Requires PHP:      8.0
 * Author:            Charlie Etienne
 * Author URI:        https://web-nancy.fr
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// Fonction pour ajouter la metabox
function custom_meta_box() {
    add_meta_box(
        'custom-meta-box',
        __('Balises SEO Multilingues', 'textdomain'),
        'custom_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'custom_meta_box');

// Fonction de rappel pour afficher les champs de la metabox
function custom_meta_box_callback($post) {
    // Récupérer les valeurs actuelles des champs
    $fr_title = get_post_meta($post->ID, 'fr_title', true);
    $en_title = get_post_meta($post->ID, 'en_title', true);
    $fr_meta_description = get_post_meta($post->ID, 'fr_meta_description', true);
    $en_meta_description = get_post_meta($post->ID, 'en_meta_description', true);

    // Afficher les champs
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Fonction pour mettre à jour la barre de progression
        function updateProgressBar(inputId, progressBarId, progressFillId, progressTextId, maxLength) {
            var input = $('#' + inputId);
            var progressBar = $('#' + progressBarId);
            var progressFill = $('#' + progressFillId);
            var progressText = $('#' + progressTextId);
            var length = input.val().length;
            var percentage = (length / maxLength) * 100;
            progressFill.css('width', percentage + '%');
            
            // Changer la couleur de remplissage de la barre de progression
            if (length > maxLength) {
                progressFill.css('background-color', 'red');
            } else {
                progressFill.css('background-color', '#2271b1');
            }

            // Mettre à jour le texte de progression
            progressText.text(length + ' / ' + maxLength  + ' (limite maximale recommandée)');
        }

        // Mettre à jour la barre de progression lors de la saisie
        $('#fr_title, #en_title, #fr_meta_description, #en_meta_description').on('input', function() {
            var maxLength = 160; // Valeur maximale par défaut
            if ($(this).is('input')) {
                maxLength = 60; // Limite de caractères pour les champs de saisie
            }
            var progressBarId = $(this).attr('id') + '-progress-bar';
            var progressFillId = $(this).attr('id') + '-progress-fill';
            var progressTextId = $(this).attr('id') + '-progress-text';
            updateProgressBar($(this).attr('id'), progressBarId, progressFillId, progressTextId, maxLength);
        });

        // Mettre à jour la barre de progression au chargement de la page
        $('#fr_title, #en_title, #fr_meta_description, #en_meta_description').each(function() {
            var maxLength = 160; // Valeur maximale par défaut
            if ($(this).is('input')) {
                maxLength = 60; // Limite de caractères pour les champs de saisie
            }
            var progressBarId = $(this).attr('id') + '-progress-bar';
            var progressFillId = $(this).attr('id') + '-progress-fill';
            var progressTextId = $(this).attr('id') + '-progress-text';
            updateProgressBar($(this).attr('id'), progressBarId, progressFillId, progressTextId, maxLength);
        });
    });
    </script>

    <style>
        .multilingual_seo_field {
            width: 100%;
            max-width: 530px;
            margin-bottom: 15px;
        }
        .multilingual_seo_field input, .multilingual_seo_field textarea {
            width: 100%;
            margin-bottom: 0px;
            display: block;
        }
        .multilingual_seo_field .progress-bar-container {
            width: 100%;
            position: relative;
            height: 15px;
            margin-top: 2px;
            background-color: #e9ecef;
            border-radius: 0.25rem 0.25rem 0 0;
            overflow: hidden;
        }
        .multilingual_seo_field .progress-fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
        }
        .multilingual_seo_field .progress-text {
            padding: 2px 5px;
            height: 15px;
            line-height: 15px;
            text-align: right;
            color: #000;
            font-size: 12px;
            background-color: #e9ecef;
            border-radius: 0 0 0.25rem 0.25rem;
        }
    </style>

    <div class="multilingual_seo_field">
        <label for="fr_title"><?php _e('Titre (Français)', 'textdomain'); ?></label><br>
        <input type="text" id="fr_title" name="fr_title" value="<?php echo esc_attr($fr_title); ?>">
        <div class="progress-bar-container">
            <div class="progress-fill" id="fr_title-progress-fill"></div>
        </div>
        <div class="progress-text" id="fr_title-progress-text"></div>
    </div>
    <div class="multilingual_seo_field">
        <label for="en_title"><?php _e('Title (English)', 'textdomain'); ?></label><br>
        <input type="text" id="en_title" name="en_title" value="<?php echo esc_attr($en_title); ?>">
        <div class="progress-bar-container">
            <div class="progress-fill" id="en_title-progress-fill"></div>
        </div>
        <div class="progress-text" id="en_title-progress-text"></div>
    </div>
    <div class="multilingual_seo_field">
        <label for="fr_meta_description"><?php _e('Meta Description (Français)', 'textdomain'); ?></label><br>
        <textarea rows="3" id="fr_meta_description" name="fr_meta_description"><?php echo esc_textarea($fr_meta_description); ?></textarea>
        <div class="progress-bar-container">
            <div class="progress-fill" id="fr_meta_description-progress-fill"></div>
        </div>
        <div class="progress-text" id="fr_meta_description-progress-text"></div>
    </div>
    <div class="multilingual_seo_field">
        <label for="en_meta_description"><?php _e('Meta Description (English)', 'textdomain'); ?></label><br>
        <textarea rows="3" id="en_meta_description" name="en_meta_description"><?php echo esc_textarea($en_meta_description); ?></textarea>
        <div class="progress-bar-container">
            <div class="progress-fill" id="en_meta_description-progress-fill"></div>
        </div>
        <div class="progress-text" id="en_meta_description-progress-text"></div>
    </div>
    <?php
}


// Fonction pour sauvegarder les données de la metabox
function save_custom_meta_box_data($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Enregistrer les données
    if (isset($_POST['fr_title'])) {
        update_post_meta($post_id, 'fr_title', sanitize_text_field($_POST['fr_title']));
    }
    if (isset($_POST['en_title'])) {
        update_post_meta($post_id, 'en_title', sanitize_text_field($_POST['en_title']));
    }
    if (isset($_POST['fr_meta_description'])) {
        update_post_meta($post_id, 'fr_meta_description', sanitize_text_field($_POST['fr_meta_description']));
    }
    if (isset($_POST['en_meta_description'])) {
        update_post_meta($post_id, 'en_meta_description', sanitize_text_field($_POST['en_meta_description']));
    }
}
add_action('save_post', 'save_custom_meta_box_data');

function modify_page_title_based_on_language($title) {

    if ( !is_page() ){
        return $title;
    }

    // Récupérer la langue actuelle
    $current_language = get_locale();

    // Récupérer l'ID de la page actuelle
    $post_id = get_the_ID();

    // Définir le titre par défaut
    $modified_title = $title;

    // Récupérer les valeurs saisies dans la metabox pour le titre en fonction de la langue
    if ($current_language == 'en_US') {
        $en_title = get_post_meta($post_id, 'en_title', true);
        if (!empty($en_title)) {
            $modified_title = $en_title;
        }
    } elseif ($current_language == 'fr_FR') {
        $fr_title = get_post_meta($post_id, 'fr_title', true);
        if (!empty($fr_title)) {
            $modified_title = $fr_title;
        }
    }

    // Retourner le titre modifié
    return $modified_title;
}
add_filter('seopress_titles_title', 'modify_page_title_based_on_language', 999);

function modify_meta_description_based_on_language($meta_description) {
    
    if ( !is_page() ){
        return $meta_description;
    }

    // Récupérer la langue actuelle
    $current_language = get_locale();

    // Récupérer l'ID de la page actuelle
    $post_id = get_the_ID();

    // Définir la meta description par défaut
    $modified_meta_description = $meta_description;

    // Récupérer les valeurs saisies dans la metabox pour la meta description en fonction de la langue
    if ($current_language == 'en_US') {
        $en_meta_description = get_post_meta($post_id, 'en_meta_description', true);
        if (!empty($en_meta_description)) {
            $modified_meta_description = $en_meta_description;
        }
    } elseif ($current_language == 'fr_FR') {
        $fr_meta_description = get_post_meta($post_id, 'fr_meta_description', true);
        if (!empty($fr_meta_description)) {
            $modified_meta_description = $fr_meta_description;
        }
    }

    // Retourner la meta description modifiée
    return $modified_meta_description;
}
add_filter('seopress_titles_desc', 'modify_meta_description_based_on_language', 999);
