<?php
declare(strict_types = 1);

namespace Drupal\habeuk_utilitaire\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure habeuk utilitaire settings for this site.
 */
final class SubmitValidationForm extends ConfigFormBase {
  
  /**
   *
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'habeuk_utilitaire_submit_validation';
  }
  
  /**
   *
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return [
      'habeuk_utilitaire.submit_validation'
    ];
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('habeuk_utilitaire.submit_validation');
    $form['site_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Site key'),
      '#default_value' => $config->get('site_key'),
      '#maxlength' => 40,
      '#description' => $this->t('The site key given to you when you <a href=":url">register for reCAPTCHA</a>.', [
        ':url' => 'https://www.google.com/recaptcha/admin'
      ]),
      '#required' => TRUE
    ];
    $form['secret_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Secret key'),
      '#default_value' => $config->get('secret_key'),
      '#maxlength' => 40,
      '#description' => $this->t('The secret key given to you when you <a href=":url">register for reCAPTCHA</a>.', [
        ':url' => 'https://www.google.com/recaptcha/admin'
      ]),
      '#required' => TRUE
    ];
    $form['verify_hostname'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Local domain name validation'),
      '#default_value' => $config->get('verify_hostname'),
      '#description' => $this->t(
        'Checks the hostname on your server when verifying a solution. Enable this validation only, if <em>Verify the origin of reCAPTCHA solutions</em> is unchecked for your key pair. Provides crucial security by verifying requests come from one of your listed domains.')
    ];
    return parent::buildForm($form, $form_state);
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // @todo Validate the form here.
    // Example:
    // @code
    // if ($form_state->getValue('example') === 'wrong') {
    // $form_state->setErrorByName(
    // 'message',
    // $this->t('The value is not correct.'),
    // );
    // }
    // @endcode
    parent::validateForm($form, $form_state);
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $values = $form_state->getValues();
    $config = $this->config('habeuk_utilitaire.submit_validation');
    $config->set('site_key', $values['site_key']);
    $config->set('secret_key', $values['secret_key']);
    $config->set('verify_hostname', $values['verify_hostname']);
    $config->save();
    parent::submitForm($form, $form_state);
  }
}
