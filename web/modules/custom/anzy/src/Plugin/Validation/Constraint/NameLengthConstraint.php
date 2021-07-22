<?php

namespace Drupal\anzy\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Constraint for validation field Name.
 *
 * @Constraint(
 *   id = "NameLength",
 *   label = @Translation("Name Length"),
 * )
 */
class NameLengthConstraint extends Constraint {

  /**
   * Variable that containing a message.
   *
   * @var string
   */
  public $message = 'The name should contain more then 2 letters and less then 32.';

}
