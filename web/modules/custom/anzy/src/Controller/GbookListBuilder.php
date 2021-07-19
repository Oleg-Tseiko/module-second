<?php

namespace Drupal\gbook\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Defines a generic implementation to build a listing of entities.
 *
 * @ingroup entity_api
 */
class GbookListBuilder extends EntityListBuilder {

  /**
   * {@inheritDoc}
   */
  public function buildHeader() {
    $header = [];
    $header['title'] = $this->t('Title');
    $header['date'] = $this->t('Date');
    $header['published'] = $this->t('Published');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritDoc}
   */
  public function buildRow(EntityInterface $event) {
    /** @var \Drupal\event\Entity\Event $event */
    $row = [];
    $row['title'] = $event->toLink();
    $row['date'] = $event->getDate()->format('m/d/y h:i:s a');
    $row['published'] = $event->isPublished() ? $this->t('Yes') : $this->t('No');
    return $row + parent::buildRow($event);
  }

}
