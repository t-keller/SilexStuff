<?php
/**
 * TwigExtend
 *
 * This class extends Twig by adding filters...
 *
 * @author Thomas KELLER
 */
class TwigExtend {

  /**
   * Return a filter to obfusc the locat part of an email address
   * Example:
   * toto@tati.lu => t**o@tati.lu
   *
   * To register the filter:
   * <code>
   * $app['twig']->addFilter(TwigExtend::twig_filter_email_obfusc());
   * </code>
   *
   * And to use it in a template:
   * <code>
   * {{ "email@domain.tld"|email_obfusc(0.5)}}
   * {{ "email@domain.tld"|email_obfusc(0.5, '#')}}
   * </code>
   *
   * @param float Obfuscation percent (number between 0 and 1)
   * @param string Obfuscation letter (optional. Default is *)
   */
  public static function twig_filter_email_obfusc()
  {
    return new \Twig_SimpleFilter('email_obfusc', function ($email_raw, $obfusc_rate, $obfusc_letter = '*')
    {
      $email = explode('@', $email_raw);
      $local_part = $email[0];
      $local_part_len = strlen($local_part);

      $letter_to_replace = (int) round($local_part_len * $obfusc_rate);
      $begin_to = (int) (($local_part_len - $letter_to_replace) / 2);

      for ($i = $begin_to; $i - $begin_to < $letter_to_replace; $i++)
        $local_part[$i] = $obfusc_letter;

      return $local_part . '@' . $email[1];
    });
  }

}