<?php

namespace Drupal\anzy\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class provides validation filters for Name field.
 *
 * @package Drupal\anzy\Plugin\Validation\Constraint
 */
class NameLengthConstraintValidator extends ConstraintValidator {

  /**
   * Provides check for max amount of letters for Name field.
   */
  public function validate($value, Constraint $constraint) {
    if (strlen($value->value) < 2 || strlen($value->value) > 32) {
      $this->context->buildViolation($constraint->message)
        ->addViolation();
    }
  }

}
