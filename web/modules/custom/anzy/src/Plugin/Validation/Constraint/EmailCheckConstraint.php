<?php

namespace Drupal\anzy\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Constraint for validation field Email.
 *
 * @Constraint(
 *   id = "EmailCheck",
 *   label = @Translation("Email Check"),
 * )
 */
class EmailCheckConstraint extends Constraint {

  /**
   * Variable that containing a message.
   *
   * @var string
   */
  public $message = 'The email field should be valid format as example@gmail.com.';

}
