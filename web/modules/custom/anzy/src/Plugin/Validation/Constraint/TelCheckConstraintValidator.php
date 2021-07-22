<?php

namespace Drupal\anzy\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class provides validation filters for Name field.
 *
 * @package Drupal\anzy\Plugin\Validation\Constraint
 */
class TelCheckConstraintValidator extends ConstraintValidator {

  /**
   * Provides check for max amount of letters for Name field.
   */
  public function validate($value, Constraint $constraint) {
    if (strlen($value->value) < 9 || strlen($value->value) > 15 || !preg_match('/^[0-9\-\(\)\/\+\s]*$/', $value->value)) {
      $this->context->buildViolation($constraint->message)
        ->addViolation();
    }
  }

}
