<?php

namespace Drupal\habeuk_utilitaire\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for habeuk utilitaire routes.
 */
class HabeukUtilitaireController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
