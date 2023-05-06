<?php

namespace Drupal\habeuk_utilitaire;

use Drupal\paragraphs\Entity\Paragraph;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

/**
 *
 * @author stephane
 *        
 */
class HabeukUtilitaire {
  
  static public function getRouteToedit(Paragraph $Paragraph) {
    $link = '';
    if ($Paragraph->hasField('layout_builder__layout')) {
      $entity_type_id = 'paragraph';
      /**
       *
       * @var \Drupal\Core\Render\Renderer $renderer
       */
      $renderer = \Drupal::service('renderer');
      if (!empty($Paragraph->id()))
        $link = [
          '#type' => 'link',
          '#title' => t('Config layout'),
          '#url' => Url::fromRoute("layout_builder.overrides.$entity_type_id.view", [
            'paragraph' => $Paragraph->id()
          ]),
          '#options' => [
            'attributes' => [
              'target' => '_blank',
              'class' => []
            ]
          ]
        ];
      // $link = $renderer->renderRoot($link);
    }
    return $link;
  }
  
  /**
   *
   * @param Node $node
   * @return string[]
   */
  static public function manageNode(Node $node) {
    $link = '';
    if (!empty($node->id()))
      $link = [
        '#type' => 'dropbutton',
        '#dropbutton_type' => 'small',
        '#links' => [
          'simple_form' => [
            'title' => t('Editer'),
            'url' => Url::fromRoute('entity.node.edit_form', [
              'node' => $node->id()
            ]),
            '#options' => [
              'attributes' => [
                'target' => '_blank',
                'class' => []
              ]
            ]
          ],
          'demo' => [
            'title' => t('Traduction'),
            'url' => Url::fromRoute('entity.node.content_translation_overview', [
              'node' => $node->id()
            ]),
            '#options' => [
              'attributes' => [
                'target' => '_blank',
                'class' => []
              ]
            ]
          ]
        ]
      ];
    return $link;
  }
  
}