<?php

namespace Drupal\dolebas_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigForm.
 *
 * @package Drupal\dolebas_config\Form
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'dolebas_config.config',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'config';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('dolebas_config.config');
    $form['stripe_api_sk'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Stripe Api Secret Key'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('stripe_api_sk'),
    ];
    $form['stripe_api_pk'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Stripe Api Publishable Key'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('stripe_api_pk'),
    ];
    $form['cloudinary_cloud_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Cloudinary Cloud Name'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('cloudinary_cloud_name'),
    ];
    $form['cloudinary_auth_username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Cloudinary Auth Username (Api Key)'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('cloudinary_auth_username'),
    ];
    $form['cloudinary_auth_password'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Cloudinary Auth Password (Api Secret)'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('cloudinary_auth_password'),
    ];
    $form['wistia_auth_username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Wistia Auth Username'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('wistia_auth_username'),
    ];
    $form['wistia_auth_password'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Wistia Auth Password (Api Token)'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('wistia_auth_password'),
    ];

    $form['wistia_token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Wistia Token'),
      '#description' => $this->t('Get wistia token from your wistia account.'),
      '#maxlength' => 512,
      '#size' => 64,
      '#default_value' => $config->get('wistia_token'),
    ];
    $form['wistia_project_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Wistia Project Id'),
      '#description' => $this->t('Get wistia Project Id from your wistia account.'),
      '#maxlength' => 512,
      '#size' => 64,
      '#default_value' => $config->get('wistia_project_id'),
    ];
//    $form['cloudinary_cloud_name'] = [
//      '#type' => 'textfield',
//      '#title' => $this->t('Cloudinary Cloud Name'),
//      '#description' => $this->t('Enter cloud name from cloudinary account.'),
//      '#maxlength' => 64,
//      '#size' => 64,
//      '#default_value' => $config->get('cloudinary_cloud_name'),
//    ];
    $form['cloudinary_upload_preset'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Cloudinary Upload Preset'),
      '#description' => $this->t('Enter Upload preset from cloudinary.'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('cloudinary_upload_preset'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('dolebas_config.config')
      ->set('stripe_api_sk', $form_state->getValue('stripe_api_sk'))
      ->save();
    $this->config('dolebas_config.config')
      ->set('stripe_api_pk', $form_state->getValue('stripe_api_pk'))
      ->save();
    $this->config('dolebas_config.config')
      ->set('cloudinary_cloud_name', $form_state->getValue('cloudinary_cloud_name'))
      ->save();
    $this->config('dolebas_config.config')
      ->set('cloudinary_auth_username', $form_state->getValue('cloudinary_auth_username'))
      ->save();
    $this->config('dolebas_config.config')
      ->set('cloudinary_auth_password', $form_state->getValue('cloudinary_auth_password'))
      ->save();
    $this->config('dolebas_config.config')
      ->set('wistia_auth_username', $form_state->getValue('wistia_auth_username'))
      ->save();
    $this->config('dolebas_config.config')
      ->set('wistia_auth_password', $form_state->getValue('wistia_auth_password'))
      ->save();

    $this->config('dolebas_config.config')
      ->set('wistia_token', $form_state->getValue('wistia_token'))
      ->set('wistia_project_id', $form_state->getValue('wistia_project_id'))
      //->set('cloudinary_cloud_name', $form_state->getValue('cloudinary_cloud_name'))
      ->set('cloudinary_upload_preset', $form_state->getValue('cloudinary_upload_preset'))
      ->save();

  }

}
