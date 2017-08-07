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
      'smtp.settings'
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
    
    $form['onoff'] = array(
      '#type'  => 'details',
      '#title' => t('Install options'),
      '#open' => TRUE,
    );
    $form['onoff']['smtp_on'] = array(
      '#type' => 'radios',
      '#title' => t('Turn this module on or off'),
      '#default_value' => $config->get('smtp_on') ? 'on' : 'off',
      '#options' => array('on' => t('On'), 'off' => t('Off')),
      '#description' => t('To uninstall this module you must turn it off here first.'),
//      '#disabled' => $this->isOverridden('smtp_on'),
    );
    $form['server'] = array(
      '#type'  => 'details',
      '#title' => t('SMTP server settings'),
      '#open' => TRUE,
    );
    $form['server']['smtp_host'] = array(
      '#type' => 'textfield',
      '#title' => t('SMTP server'),
      '#default_value' => $config->get('smtp_host'),
      '#description' => t('The address of your outgoing SMTP server.'),
//      '#disabled' => $this->isOverridden('smtp_host'),
    );
    $form['server']['smtp_hostbackup'] = array(
      '#type' => 'textfield',
      '#title' => t('SMTP backup server'),
      '#default_value' => $config->get('smtp_hostbackup'),
      '#description' => t('The address of your outgoing SMTP backup server. If the primary server can\'t be found this one will be tried. This is optional.'),
//      '#disabled' => $this->isOverridden('smtp_hostbackup'),
    );
    $form['server']['smtp_port'] = array(
      '#type' => 'number',
      '#title' => t('SMTP port'),
      '#size' => 6,
      '#maxlength' => 6,
      '#default_value' => $config->get('smtp_port'),
      '#description' => t('The default SMTP port is 25, if that is being blocked try 80. Gmail uses 465. See :url for more information on configuring for use with Gmail.', array(':url' => 'http://gmail.google.com/support/bin/answer.py?answer=13287')),
//      '#disabled' => $this->isOverridden('smtp_port'),
    );
    // Only display the option if openssl is installed.
    if (function_exists('openssl_open')) {
      $encryption_options = array(
        'standard' => t('No'),
        'ssl' => t('Use SSL'),
        'tls' => t('Use TLS'),
      );
      $encryption_description = t('This allows connection to an SMTP server that requires SSL encryption such as Gmail.');
    }
    // If openssl is not installed, use normal protocol.
    else {
      $config->set('smtp_protocol', 'standard');
      $encryption_options = array('standard' => t('No'));
      $encryption_description = t('Your PHP installation does not have SSL enabled. See the :url page on php.net for more information. Gmail requires SSL.', array(':url' => 'http://php.net/openssl'));
    }
    $form['server']['smtp_protocol'] = array(
      '#type' => 'select',
      '#title' => t('Use encrypted protocol'),
      '#default_value' => $config->get('smtp_protocol'),
      '#options' => $encryption_options,
      '#description' => $encryption_description,
//      '#disabled' => $this->isOverridden('smtp_protocol'),
    );

    $form['auth'] = array(
      '#type' => 'details',
      '#title' => t('SMTP Authentication'),
      '#description' => t('Leave blank if your SMTP server does not require authentication.'),
      '#open' => TRUE,
    );
    $form['auth']['smtp_username'] = array(
      '#type' => 'textfield',
      '#title' => t('Username'),
      '#default_value' => $config->get('smtp_username'),
      '#description' => t('SMTP Username.'),
//      '#disabled' => $this->isOverridden('smtp_username'),
    );
    $form['auth']['smtp_password'] = array(
      '#type' => 'textfield',
      '#title' => t('Password'),
      '#default_value' => $config->get('smtp_password'),
      '#description' => t('SMTP password. If you have already entered your password before, you should leave this field blank, unless you want to change the stored password. Please note that this password will be stored as plain-text inside Drupal\'s core configuration variables.'),
//      '#disabled' => $this->isOverridden('smtp_password'),
    );

    $form['email_options'] = array(
      '#type'  => 'details',
      '#title' => t('E-mail options'),
      '#open' => TRUE,
    );
    $form['email_options']['smtp_from'] = array(
      '#type' => 'textfield',
      '#title' => t('E-mail from address'),
      '#default_value' => $config->get('smtp_from'),
      '#description' => t('The e-mail address that all e-mails will be from.'),
//      '#disabled' => $this->isOverridden('smtp_from'),
    );
    $form['email_options']['smtp_fromname'] = array(
      '#type' => 'textfield',
      '#title' => t('E-mail from name'),
      '#default_value' => $config->get('smtp_fromname'),
      '#description' => t('The name that all e-mails will be from. If left blank will use a default of: @name',
          ['@name' => $this->configFactory->get('system.site')->get('name')]),
//      '#disabled' => $this->isOverridden('smtp_fromname'),
    );
//     $form['email_options']['smtp_allowhtml'] = array(
//       '#type' => 'checkbox',
//       '#title' => t('Allow to send e-mails formatted as HTML'),
//       '#default_value' => $config->get('smtp_allowhtml'),
//       '#description' => t('Checking this box will allow HTML formatted e-mails to be sent with the SMTP protocol.'),
// //      '#disabled' => $this->isOverridden('smtp_allowhtml'),
//     );

//     $form['client'] = array(
//       '#type'  => 'details',
//       '#title' => t('SMTP client settings'),
//       '#open' => TRUE,
//     );
//     $form['client']['smtp_client_hostname'] = array(
//       '#type' => 'textfield',
//       '#title' => t('Hostname'),
//       '#default_value' => $config->get('smtp_client_hostname'),
//       '#description' => t('The hostname to use in the Message-Id and Received headers, and as the default HELO string. Leave blank for using %server_name.', array('%server_name' => isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost.localdomain')),
// //      '#disabled' => $this->isOverridden('smtp_client_hostname'),
//     );
//     $form['client']['smtp_client_helo'] = array(
//       '#type' => 'textfield',
//       '#title' => t('HELO'),
//       '#default_value' => $config->get('smtp_client_helo'),
//       '#description' => t('The SMTP HELO/EHLO of the message. Defaults to hostname (see above).'),
// //      '#disabled' => $this->isOverridden('smtp_client_helo'),
//     );


 
    
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
      ->set('stripe_api_pk', $form_state->getValue('stripe_api_pk'))
      ->set('cloudinary_cloud_name', $form_state->getValue('cloudinary_cloud_name'))
      ->set('cloudinary_auth_username', $form_state->getValue('cloudinary_auth_username'))
      ->set('cloudinary_auth_password', $form_state->getValue('cloudinary_auth_password'))
      ->set('wistia_auth_username', $form_state->getValue('wistia_auth_username'))
      ->set('wistia_auth_password', $form_state->getValue('wistia_auth_password'))
      ->set('wistia_token', $form_state->getValue('wistia_token'))
      ->set('wistia_project_id', $form_state->getValue('wistia_project_id'))
      //->set('cloudinary_cloud_name', $form_state->getValue('cloudinary_cloud_name'))
      ->set('cloudinary_upload_preset', $form_state->getValue('cloudinary_upload_preset'))
      ->save();
      
    // Set contrib module smtp.settings

    $values = $form_state->getValues();
    $config = $this->configFactory->getEditable('smtp.settings');
    $mail_config = $this->configFactory->getEditable('system.mail');
    $mail_system = $mail_config->get('interface.default');

    $config->set('smtp_password', $values['smtp_password']);
    $config->set('smtp_on', $values['smtp_on'] == 'on')->save();

    $config_keys = [
      'smtp_host',
      'smtp_hostbackup',
      'smtp_port',
      'smtp_protocol',
      'smtp_username',
      'smtp_from',
      'smtp_fromname',
      // 'smtp_client_hostname',
      // 'smtp_client_helo',
      // 'smtp_allowhtml',
      // 'smtp_debugging',
    ];
    foreach ($config_keys as $name) {
      $config->set($name, $values[$name])->save();
    }
    
    // Set as default mail system if module is enabled.
    if ($config->get('smtp_on')) {
      if ($mail_system != 'SMTPMailSystem') {
        $config->set('prev_mail_system', $mail_system);
      }
      $mail_system = 'SMTPMailSystem';
      $mail_config->set('interface.default', $mail_system)->save();
    }
    else {
      $default_system_mail = 'php_mail';
      $mail_config = $this->configFactory->getEditable('system.mail');
      $default_interface = ($mail_config->get('prev_mail_system')) ? $mail_config->get('prev_mail_system') : $default_system_mail;
      $mail_config->set('interface.default', $default_interface)
        ->save();
    }    

  }

}
