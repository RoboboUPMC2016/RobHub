<?php
class FormWritterUtils
{
  public static function createLabelInput($label, $inputType, $inputId, $inputValue, $errorMsg = NULL)
  {
    // Open div
    $labelInput = '<div class="col-md-11"><div class="form-group">';

    // Create label
    $labelInput .= '<label for="' . $inputId . '">' . $label . '</label>';

    // Create input
    $labelInput .= '<input class="form-control" type="' . $inputType .
                                             '" name="' . $inputId .
                                             '" id="' . $inputId . '"' .
                                             ($inputValue === NULL || empty($inputValue) ? '' : ' value="' . $inputValue . '"') .
                                             '>';
    // Create error message
    if ($errorMsg !== NULL)
    {
      $labelInput .= '<span class="invalidInput">' . $errorMsg . '</span>';
    }

    // Close div
    $labelInput .= '</div></div>';

    return $labelInput;
  }

  public static function createSubmitBtn($name, $value)
  {
    return '<div class="col-md-12">' .
              '<div class="form-group">' .
                  '<input class="btn btn-primary" type="submit" name="' . $name . '" value="' . $value . '">' .
              '</div>' .
            '</div>';
  }
}
?>