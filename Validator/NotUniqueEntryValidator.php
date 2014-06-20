<?php
/**
 * NotUniqueEntryValidator
 *
 * @see NotUniqueEntry.php
 */
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotUniqueEntryValidator extends ConstraintValidator
{
  public function validate($value, Constraint $constraint)
  {
    $query = sprintf('SELECT %s FROM %s WHERE %s = ?',
      $constraint->field,
      $constraint->table,
      $constraint->field);

    $stmt = $constraint->dbal_connection->executeQuery($query, array($value));

    if (!$stmt->fetch())
      $this->context->addViolation($constraint->uniqueMessage);
  }
}