<?php

namespace Drupal\anzy\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\user\EntityOwnerInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Contains \Drupal\anzy\Form\gbook.
 *
 * @file
 */

/**
 * Provides db table for entity type.
 *
 * @ContentEntityType(
 *   id = "gbook",
 *   label = @Translation("Gbook"),
 *   label_collection = @Translation("Reviews"),
 *   label_singular = @Translation("review"),
 *   label_plural = @Translation("reviews"),
 *   base_table = "anzy",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "published" = "published",
 *     "owner" = "author",
 *   },
 *   handlers = {
 *    "access" = "Drupal\Core\Entity\EntityAccessControlHandler",
 *    "form" = {
 *      "add" = "Drupal\anzy\Form\GbookForm",
 *      "edit" = "Drupal\anzy\Form\GbookForm",
 *      "delete" = "Drupal\anzy\Form\GbookDelete",
 *     },
 *    "permission_provider" = "Drupal\Core\Entity\EntityPermissionProvider",
 *    "route_provider" = {
 *       "default" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *     },
 *    "list_builder" = "Drupal\anzy\Controller\GbookBuilder",
 *    "local_action_provider" = {
 *      "collection" = "Drupal\Core\Entity\Menu\EntityCollectionLocalActionProvider",
 *      },
 *    "views_data" = "Drupal\views\EntityViewsData",
 *   },
 *   links = {
 *     "canonical" = "/gbook/{gbook}",
 *     "add-form" = "/content/gbook/add",
 *     "edit-form" = "/admin/content/gbook/manage/{gbook}",
 *     "delete-form" = "/admin/content/gbook/manage/{gbook}/delete",
 *     "collection" = "/admin/content/reviews",
 *   },
 *   admin_permission = "access content",
 * )
 */
class Gbook extends ContentEntityBase implements EntityOwnerInterface, EntityPublishedInterface {
  use EntityOwnerTrait, EntityPublishedTrait;

  /**
   * {@inheritDoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    // Get the field definitions for 'id' and 'uuid' from the parent.
    $fields = parent::baseFieldDefinitions($entity_type);
    $fields['Name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name:'))
      ->setRequired(TRUE)
      ->setDisplayOptions('form', ['weight' => 0])
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'weight' => 2,
      ]);

    $fields['date'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Submitted:'))
      ->setDefaultValue([
        'default_date_type' => 'unix',
        'default_date'      => 'now',
      ])
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'weight' => 3,
      ]);
    $fields['Phone'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Phone:'))
      ->setRequired(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'weight' => 8,
      ])
      ->setDisplayOptions('form', ['weight' => 6]);
    $fields['Mail'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Email:'))
      ->setRequired(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'weight' => 9,
      ])
      ->setDisplayOptions('form', ['weight' => 7]);
    $fields['Image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('image'))
      ->setSettings([
        'file_directory' => 'IMAGE_FOLDER',
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => '2097152',
        'max_resolution' => '1920x1200',
        'min_resolution' => '100x100',
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'image',
        'weight' => 10,
      ])
      ->setDisplayOptions('form', ['weight' => 9])
      ->setDisplayConfigurable('view', TRUE);
    $fields['Avatar'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Avatar'))
      ->setSettings([
        'file_directory' => 'IMAGE_FOLDER',
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => '2097152',
        'max_resolution' => '1920x1200',
        'min_resolution' => '100x100',
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'image',
        'weight' => 1,
      ])
      ->setDisplayOptions('form', ['weight' => 8])
      ->setDisplayConfigurable('view', TRUE);
    $fields['Comment'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Review:'))
      ->setRequired(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'weight' => 10,
      ])
      ->setDisplayOptions('form', ['weight' => 20]);
    // Get the field definitions for 'author' and 'published' from the trait.
    $fields += static::ownerBaseFieldDefinitions($entity_type);
    $fields += static::publishedBaseFieldDefinitions($entity_type);

    $fields['published']->setDisplayOptions('form', [
      'settings' => [
        'display_label' => TRUE,
      ],
      'weight' => 30,
    ]);

    return $fields;
  }

  /**
   * Retrieve Name from fields.
   */
  public function getName() {
    return $this->get('Name')->value;
  }

  /**
   * Retrieve date from fields.
   */
  public function getDate() {
    return $this->get('date')->value;
  }

  /**
   * Retrieve Phone from fields.
   */
  public function getPhone() {
    return $this->get('Phone')->value;
  }

  /**
   * Retrieve email from fields.
   */
  public function getMail() {
    return $this->get('Mail')->value;
  }

  /**
   * Retrieve image from fields.
   */
  public function getImage() {
    return $this->get('Image')->target_id;
  }

  /**
   * Retrieve avatar from fields.
   */
  public function getAvatar() {
    return $this->get('Avatar')->target_id;
  }

  /**
   * Retrieve comment from fields.
   */
  public function getComment() {
    return $this->get('Comment')->value;
  }

}
