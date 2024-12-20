<?php

namespace Drupal\habeuk_utilitaire\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Template\Attribute;
use Drupal\layoutgenentitystyles\Services\LayoutgenentitystylesServices;

/**
 * Provides a sharerxs block.
 * Ce block recupe l'entite definie au niveau de la route et genere les boutons
 * pour les partages sur les reseaux sociaux.
 * L'entité doit etre selectionner.
 *
 * @Block(
 *   id = "habeuk_utilitaire_back_link",
 *   admin_label = @Translation("BackLink"),
 *   category = @Translation("Custom")
 * )
 */
class BackLink extends BlockBase {
  
  /**
   *
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'block_class' => 'btn btn-light text-decoration-none',
      'text_display' => 'Return',
      'icone' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="1.5rem" height="1.5rem" class="me-3" fill="currentColor"> <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>'
    ];
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['block_class'] = [
      '#type' => 'textfield',
      '#title' => $this->t("block_class"),
      '#default_value' => $this->configuration['block_class']
    ];
    $form['text_display'] = [
      '#type' => 'textfield',
      '#title' => $this->t("text_display"),
      '#default_value' => $this->configuration['text_display']
    ];
    
    $form['icone'] = [
      '#type' => 'textarea',
      '#title' => 'Icone',
      '#default_value' => $this->configuration['icone']
    ];
    return $form;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $this->configuration['block_class'] = $form_state->getValue('block_class');
    $this->configuration['text_display'] = $form_state->getValue('text_display');
    $this->configuration['icone'] = $form_state->getValue('icone');
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    if (!empty($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_HOST'])) {
      $refferer = $_SERVER['HTTP_REFERER'];
      $domain = $_SERVER['HTTP_HOST'];
      if (str_contains($refferer, $domain)) {
        $attributes = new Attribute();
        $attributes->addClass($this->configuration['block_class']);
        $attributes->setAttribute('href', $refferer);
        $build['content'] = [
          '#theme' => 'habeuk_utilitaire_backlink',
          '#link' => [
            'value' => $this->t($this->configuration['text_display']),
            'href' => $refferer
          ],
          '#icone' => $this->configuration['icone'],
          '#attributes' => $attributes
        ];
      }
    }
    return $build;
  }
}