<?php

/**
 * Papi Timber integration class.
 *
 * @package PapiTimber
 * @since 1.0.0
 */

class PapiTimber {

  /**
   * Add filter so we can change to output of `get_field` in Timber.
   *
   * @since 1.0.0
   */

  public function __construct() {
    add_filter( 'timber_post_get_meta_field', array( $this, 'post_get_meta_field' ), 10, 3 );
  }

  /**
   * Get post meta field using Papi's field function.
   *
   * @param mixed $old_value
   * @param int $post_id
   * @param string $field_name
   *
   * @return mixed
   */

  public function post_get_meta_field( $old_value, $post_id, $field_name ) {
    $value = papi_field( $post_id, $field_name );

    if ( empty( $value ) ) {
      return $old_value;
    }

    // Convert Papi images to TimberImage class right here so you don't
    // have to write {{ TimberImage(item.picture.id) }}
    if ( is_object( $value ) && isset( $value->is_image ) ) {
      return new TimberImage($value->id);
    }

    if ( ! is_array( $value ) ) {
      return $value;
    }

    foreach( $value as $i => $arr ) {
      if ( ! is_array( $arr ) ) {
        continue;
      }

      // Convert Papi images to TimberImage class right here so you don't
      // have to write {{ TimberImage(item.picture.id) }}
      foreach ( $arr as $key => $property ) {
        if ( is_object( $property ) && isset( $property->is_image ) ) {
          $value[$i][$key] = new TimberImage($property->id);
        }
      }
    }

    return $value;
  }

}

/**
 * Initiliaze the Papi Timber integration class.
 *
 * @since 1.0.0
 */

function _papi_timber_integration() {
  if ( class_exists( 'Papi_Loader' ) ) {
    new PapiTimber();
  }
}

add_action('init', '_papi_timber_integration');
