<?php

namespace Drupal\anzy\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\file\Entity\File;

/**
 * Defines a generic implementation to build a listing of entities.
 *
 * @ingroup entity_api
 */
class GbookBuilder extends EntityListBuilder {

  /**
   * {@inheritDoc}
   */
  public function buildHeader() {
    $header = [];
    $header['Name'] = $this->t('Name');
    $header['date'] = $this->t('Date');
    $header['Phone'] = $this->t('Phone');
    $header['Mail'] = $this->t('Mail');
    $header['Avatar'] = $this->t('Avatar');
    $header['Image'] = $this->t('Image');
    $header['Review'] = $this->t('Review');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritDoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\event\Entity\Gbook $entity */
    $renderer = \Drupal::service('renderer');
    $imgfid = $entity->getImage();
    if (isset($imgfid) && $imgfid != 0) {
      $imgfile = File::load($imgfid);
      $imgfile = [
        '#type' => 'image',
        '#theme' => 'image_style',
        '#style_name' => 'thumbnail',
        '#uri' => !empty($imgfile) ? $imgfile->getFileUri() : '',
      ];
    }
    $avafid = $entity->getAvatar();
    if (isset($avafid) && $avafid != 0) {
      $avafile = File::load($avafid);
      $avafile = [
        '#type' => 'image',
        '#theme' => 'image_style',
        '#style_name' => 'thumbnail',
        '#uri' => !empty($avafile) ? $avafile->getFileUri() : '',
      ];
    }
    else {
      $avafile = [
        '#markup' => '<img class="max-image-size" src="/modules/custom/anzy/img/default-user-avatar-300x293.png"/>',
      ];
    }
    $row = [];
    $row['Name'] = $entity->getName();
    $row['date'] = date('d/m/Y G:i:s', $entity->getDate());
    $row['Phone'] = $entity->getPhone();
    $row['Mail'] = $entity->getMail();
    $row['Avatar'] = $renderer->render($avafile);
    $row['Image'] = $renderer->render($imgfile);
    $row['Review'] = $entity->getComment();
    return $row + parent::buildRow($entity);
  }

}
