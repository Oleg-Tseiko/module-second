<?php

namespace Drupal\anzy\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class provides validation filters for Name field.
 *
 * @package Drupal\anzy\Plugin\Validation\Constraint
 */
class EmailCheckConstraintValidator extends ConstraintValidator {

  /**
   * Provides check for max amount of letters for Name field.
   */
  public function validate($value, Constraint $constraint) {
    if (!filter_var($value->value, FILTER_VALIDATE_EMAIL) || preg_match('/[#$%^&*()+=!\[\]\';,\/{}|":<>?~\\\\0-9]/', $value->value)) {
      $this->context->buildViolation($constraint->message)
        ->addViolation();
    }
  }

}
