<?php
/**
 * NotUniqueEntry
 *
 * Ensure a value is NOT unique in the database
 * Used like a regular Silex/Symfony Validator
 *
 * Example:
 *
 * <code>
 * new NotUniqueEntry(
 *    array(
 *      'dbal_connection' => $app['db'],
 *      'table' => 'account',
 *      'field' => 'username',
 *      'uniqueMessage' => 'Username not found'
 *    )
 *  )
 * </code>
 *
 * @author Thomas KELLER
 */

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\MissingOptionsException;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

/**
 * @Annotation
 */
class NotUniqueEntry extends Constraint {

  public $uniqueMessage = 'This value doesn\'t exist in the database';
  public $dbal_connection;
  public $table;
  public $field;

  public function __construct($options = null)
  {
    parent::__construct($options);

    if ($this->dbal_connection === null)
      throw new MissingOptionsException(sprintf('The option "dbal_connection" is mandatory for constraint %s', __CLASS__), array('dbal_connection'));

    if (!$this->dbal_connection instanceof \Doctrine\DBAL\Connection)
      throw new InvalidArgumentException(sprintf('The option "dbal_connection" must be an instance of Doctrine\DBAL\Connection for constraint %s', __CLASS__));

    if ($this->table === null)
      throw new MissingOptionsException(sprintf('The option "table" is mandatory for constraint %s', __CLASS__), array('table'));
    
    if (!is_string($this->table) OR $this->table == '')
      throw new InvalidArgumentException(sprintf('The option "table" must be a valid string for constraint %s', __CLASS__));

    if ($this->field === null)
      throw new MissingOptionsException(sprintf('The option "field" is mandatory for constraint %s', __CLASS__), array('field'));
    
    if (!is_string($this->field) OR $this->field == '')
      throw new InvalidArgumentException(sprintf('The option "field" must be a valid string for constraint %s', __CLASS__));
  }
}