<?php

namespace Drupal\habeuk_utilitaire\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure habeuk utilitaire settings for this site.
 */
class SettingsForm extends ConfigFormBase {
  
  /**
   *
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'habeuk_utilitaire_settings';
  }
  
  /**
   *
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'habeuk_utilitaire.settings'
    ];
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['enable'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable'),
      '#default_value' => $this->config('habeuk_utilitaire.settings')->get('enable')
    ];
    $form['time_to_wait'] = [
      '#type' => 'number',
      '#title' => $this->t('Time to wait'),
      '#default_value' => $this->config('habeuk_utilitaire.settings')->get('time_to_wait')
    ];
    return parent::buildForm($form, $form_state);
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $config = $this->config('habeuk_utilitaire.settings');
    $config->set('enable', $values['enable']);
    $config->set('time_to_wait', intval($values['time_to_wait']));
    $config->save();
    parent::submitForm($form, $form_state);
  }
}
