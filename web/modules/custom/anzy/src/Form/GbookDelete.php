<?php

namespace Drupal\anzy\Form;

use Drupal\Core\Entity\ContentEntityDeleteForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a generic base class for an entity-based confirmation form.
 *
 * @ingroup entity_api
 */
class GbookDelete extends ContentEntityDeleteForm {

  /**
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    /** @var \Drupal\Core\Entity\ContentEntityInterface $entity */
    $entity = $this->getEntity();
    $message = $this->getDeletionMessage();

    // Make sure that deleting a translation does not delete the whole entity.
    if (!$entity->isDefaultTranslation()) {
      $untranslated_entity = $entity->getUntranslated();
      $untranslated_entity->removeTranslation($entity->language()->getId());
      $untranslated_entity->save();
      $form_state->setRedirectUrl($untranslated_entity->toUrl('add-form'));
    }
    else {
      $entity->delete();
      $form_state->setRedirectUrl($entity->toUrl('add-form'));
    }

    $this->messenger()->addStatus($message);
    $this->logDeletionMessage();
  }

}
