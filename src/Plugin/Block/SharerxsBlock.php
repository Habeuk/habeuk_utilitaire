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
 *   id = "habeuk_utilitaire_sharerxs",
 *   admin_label = @Translation("ShareRxs"),
 *   category = @Translation("Custom")
 * )
 */
class SharerxsBlock extends BlockBase implements ContainerFactoryPluginInterface {
  
  /**
   * The entity_type.manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;
  
  /**
   * The current_route_match service.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;
  
  /**
   *
   * @var \Drupal\layoutgenentitystyles\Services\LayoutgenentitystylesServices
   */
  protected $LayoutgenentitystylesServices;
  
  /**
   * Constructs a new SharerxsBlock instance.
   *
   * @param array $configuration
   *        The plugin configuration, i.e. an array with configuration values
   *        keyed
   *        by configuration option name. The special key 'context' may be used
   *        to
   *        initialize the defined contexts by setting it to an array of context
   *        values keyed by context names.
   * @param string $plugin_id
   *        The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *        The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManager $entity_manager
   *        The entity.manager service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManager $entity_type_manager, CurrentRouteMatch $currentRouteMatch, LayoutgenentitystylesServices $LayoutgenentitystylesServices) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->currentRouteMatch = $currentRouteMatch;
    $this->LayoutgenentitystylesServices = $LayoutgenentitystylesServices;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration, $plugin_id, $plugin_definition, $container->get('entity_type.manager'), $container->get('current_route_match'), $container->get('layoutgenentitystyles.add.style.theme'));
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'entity' => 'node',
      'layoutgenentitystyles_view_options' => [
        'habeuk_utilitaire/square_border' => 'Carré avec bordure'
      ],
      'layoutgenentitystyles_view' => 'habeuk_utilitaire/square_border',
      'block_class' => 'd-flex',
      'color_class' => 'block--square_border--primary',
      'display_label' => true,
      'display_icone' => true,
      'rxs' => [
        'facebook' => [
          'label' => 'facebook',
          'icone' => '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg>',
          'status' => true,
          'class' => 'habeukUtilitaireRxFacebook' // dont change or update class
        ],
        'twitter' => [
          'label' => 'twitter',
          'icone' => '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>',
          'status' => true,
          'class' => 'habeukUtilitaireRxTwitter' // dont change or update class
        ],
        'email' => [
          'label' => 'email',
          'icone' => '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"/></svg>',
          'status' => true,
          'class' => 'habeukUtilitaireRxEmail' // dont change or update class
        ],
        'print' => [
          'label' => 'print',
          'icone' => '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z"/></svg>',
          'status' => true,
          'class' => 'habeukUtilitaireRxPrint' // dont change or update class
        ]
      ]
    ];
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['entity'] = [
      '#type' => 'select',
      '#title' => $this->t('Entity to share'),
      '#default_value' => $this->configuration['entity'],
      '#options' => $this->getListEntities()
    ];
    $form['layoutgenentitystyles_view'] = [
      '#type' => 'select',
      '#title' => $this->t("Style d'affichage"),
      '#default_value' => $this->configuration['layoutgenentitystyles_view'],
      '#options' => $this->configuration['layoutgenentitystyles_view_options']
    ];
    $form['color_class'] = [
      '#type' => 'select',
      '#title' => $this->t('color hover'),
      '#default_value' => $this->configuration['color_class'],
      '#options' => [
        'block--square_border--primary' => 'hover primary',
        'block--square_border--background' => 'hover background'
      ]
    ];
    return $form;
  }
  
  /**
   * Recupere la liste des entites.
   */
  protected function getListEntities() {
    $entities = [];
    foreach ($this->entityTypeManager->getDefinitions() as $k => $entity) {
      /**
       *
       * @var \Drupal\Core\Config\Entity\ConfigEntityType $entity
       */
      if ($entity->getBaseTable()) {
        $entities[$k] = $entity->getLabel();
      }
    }
    return $entities;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $this->configuration['entity'] = $form_state->getValue('entity');
    $this->configuration['layoutgenentitystyles_view'] = $form_state->getValue('layoutgenentitystyles_view');
    $this->LayoutgenentitystylesServices->addStyleFromPluginBlock($this);
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    if ($entity = $this->currentRouteMatch->getParameter($this->configuration['entity'])) {
      // dump($this->configuration);
      $items = [];
      /**
       *
       * @var \Drupal\Core\Entity\ContentEntityInterface $entity
       */
      foreach ($this->configuration['rxs'] as $rx) {
        
        if ($rx['status']) {
          $Attribute = new Attribute();
          $Attribute->addClass($rx['class'], 'item');
          $items[] = [
            '#theme' => 'habeuk_utilitaire_render_rx',
            '#label' => $this->configuration['display_label'] ? $this->viewValue($rx['label']) : '',
            '#icone' => $this->configuration['display_icone'] ? $this->viewValue($rx['icone']) : '',
            '#attributes' => $Attribute,
            '#attributes_icone' => new Attribute([
              'class' => [
                'icone'
              ]
            ]),
            '#attributes_label' => new Attribute([
              'class' => [
                'label'
              ]
            ])
          ];
        }
      }
      $Attribute = new Attribute();
      $ar = explode("/", $this->configuration['layoutgenentitystyles_view']);
      $Attribute->addClass('block--' . $ar[1], $this->configuration['block_class'], $this->configuration['color_class']);
      $build['content'] = [
        '#theme' => 'habeuk_utilitaire_render_rxs',
        '#items' => $items,
        '#attributes' => $Attribute
      ];
    }
    return $build;
  }
  
  protected function viewValue($value) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    return [
      '#type' => 'inline_template',
      '#template' => '{{ value|raw }}',
      '#context' => [
        'value' => $value
      ]
    ];
  }
  
}
