<?php
/**
 * Field error partial override.
 *
 * @package Webmakerr
 */

defined('ABSPATH') || exit;
?>
<div
  v-cloak
  class="mt-2 rounded border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700"
  v-if="get_error('<?php echo esc_attr($field->id); ?>')"
  v-html="get_error('<?php echo esc_attr($field->id); ?>').message"
></div>
