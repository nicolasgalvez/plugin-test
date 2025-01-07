<?php
/**
 * Plugin Name:       Plugin Test
 * Description:       An example block from my heart to yours.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Procyon Creative - block builder
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       plugin-test
 *
 * @package           procyon
 */

namespace procyon;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once __DIR__ . '/vendor/autoload.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/nicolasgalvez/plugin-test/',
	__FILE__, //Full path to the main plugin file
	'plugin-test'
);

$myUpdateChecker->getVcsApi()->enableReleaseAssets();

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch( 'main' );

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function procyon_plugin_test_block_init() {
    $blocks = array_filter( scandir( __DIR__ . '/build' ), function( $file ) {
        return is_dir( __DIR__ . '/build/' . $file ) && ! in_array( $file, [ '.', '..' ] );
    } );
    foreach ( $blocks as $block ) {
        register_block_type_from_metadata( __DIR__ . '/build/' . $block );
    }
}
add_action( 'init', 'Procyon\procyon_plugin_test_block_init' );
