<?php

namespace Drupal\anzy\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Constraint for validation field Phone.
 *
 * @Constraint(
 *   id = "PhoneCheck",
 *   label = @Translation("Phone Check"),
 * )
 */
class TelCheckConstraint extends Constraint {

  /**
   * Variable that containing a message.
   *
   * @var string
   */
  public $message = 'The phone field should contain only numbers and valid numbers length size.';

}
