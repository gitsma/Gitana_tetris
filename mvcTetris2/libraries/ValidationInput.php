<?php
class ValidationInput
{
  private $input;
  private $errors;

  public function __construct($input)
  {
    $this->input = $input;
    $this->errors = [];
  }

  public function empty()
  {
    if (empty($this->input)) array_push($this->errors, 'Input is empty');
    return $this;
  }

  public function length($from, $to = 'not set')
  {
    if ($to === 'not set') {
      if (strlen($this->input) != $from) array_push($this->errors, "Input must have $from symbols");
    } elseif ($from > strlen($this->input) || strlen($this->input) > $to)
      array_push($this->errors, "Must have $from to $to symbols");
    return $this;
  }

  public function minCapitals($number)
  {
    $capitals = 0;
    $input = $this->input;
    for ($i = 0; $i < strlen($input); $i++) if (ucfirst($input[$i]) === $input[$i]) $capitals++;
    if ($capitals < $number) array_push($this->errors, "Input must have at least $number capitals");
    return $this;
  }

  public function email()
  {
    $input = $this->input;
    $etaIndex = -1;
    $dotIndex = -1;
    for ($i = 0; $i < strlen($input); $i++) {
      if ($input[$i] === '@') $etaIndex = $i;
      if ($input[$i] === '.' && ($i - $etaIndex) > 2) $dotIndex = $i;
    }
    if (!($dotIndex > 0 && (strlen($input) - $dotIndex) > 1)) array_push($this->errors, 'Please submit correct email format');
    return $this;
  }

  public function number()
  {
    if (!is_numeric($this->input)) array_push($this->errors, 'Please submit only numbers');
    return $this;
  }

  public function containsNumbers($count)
  {
    $input = $this->input;
    $numberCount = 0;
    for ($i = 0; $i < strlen($input); $i++) if (is_numeric($input[$i])) $numberCount++;
    if ($numberCount < $count) array_push($this->errors, "Must have at least $count number");
    return $this;
  }

  public function equals($word)
  {
    if ($word !== $this->value()) array_push($this->errors, "Passwords do not match");
    return $this;
  }

  public function oneOf(array $options)
  {
    foreach ($options as $option) {
      if ($option === $this->value()) return $this;
    }
    array_push($this->errors, "There is no such option");
    return $this;
  }

  public function success()
  {
    return (count($this->errors) > 0) ? false : true;
  }

  public function getErrors()
  {
    return $this->errors;
  }

  public function value()
  {
    return $this->input;
  }
}