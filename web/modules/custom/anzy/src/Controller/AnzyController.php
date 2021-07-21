<?php

namespace Drupal\anzy\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides route responses for the Anzy module.
 */
class AnzyController extends ControllerBase {

  /**
   * Form build interface.
   *
   * @var Drupal\Core\Form\FormBase
   */
  protected $formBuilder;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->formBuilder = $container->get('entity.form_builder');
    return $instance;
  }

  /**
   * Return form for review.
   */
  public function form() {
    $entity = $this->entityTypeManager()->getStorage('gbook')->create([
      'entity_type' => 'node',
      'entity_id' => 'gbook',
    ]);
    $form = $this->formBuilder->getForm($entity, 'add');
    return $form;
  }

  /**
   * Get all reviews for page.
   *
   * @return array
   *   A simple array.
   */
  public function load() {
    $connection = \Drupal::service('database');
    $query = $connection->select('anzy', 'a');
    $query->fields('a',
      ['name',
        'comment__value',
        'phone',
        'mail',
        'date',
        'image__target_id',
        'avatar__target_id',
        'id',
      ]
    );
    $result = $query->execute()->fetchAll();
    return $result;
  }

  /**
   * Render all reviews entries.
   */
  public function report() {
    $info = json_decode(json_encode($this->load()), TRUE);
    $info = array_reverse($info);
    $form = $this->form();
    $rows = [];
    $dest = $this->getDestinationArray();
    foreach ($info as &$value) {
      $fid = $value['image__target_id'];
      if (isset($fid)) {
        $file = File::load($fid);
        $value['image'] = !empty($file) ? file_url_transform_relative(file_create_url($file->getFileUri())) : '';
      }
      else {
        $value['image'] = '';
      }
      $avafid = $value['avatar__target_id'];
      if (isset($avafid)) {
        $avafile = File::load($avafid);
        $value['avatar'] = !empty($avafile) ? file_url_transform_relative(file_create_url($avafile->getFileUri())) : '';
      }
      else {
        $value['avatar'] = '';
      }
      $value['comment__value'] = [
        '#markup' => $value['comment__value'],
      ];
      $value['comment__value'] = \Drupal::service('renderer')->render($value['comment__value']);
      $value['date'] = strtotime($value['date']);
      $value['date'] = date('d/m/Y G:i:s', $value['date']);
      array_push($rows, $value);
    }
    $form['#attached']['library'][] = 'anzy/my-lib';
    return [
      '#theme' => 'Gbook_template',
      '#form' => $form,
      '#items' => $rows,
      '#dest' => $dest['destination'],
    ];
  }

}
