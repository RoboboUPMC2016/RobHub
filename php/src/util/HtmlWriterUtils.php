<?php
class HtmlWriterUtils
{
  public static function createLabelInput($label, $inputType, $inputId, $inputValue, $errorMsg = null)
  {
    // Open div
    $labelInput = '<div class="col-md-11"><div class="form-group">';

    // Create label
    $labelInput .= '<label for="' . $inputId . '">' . $label . '</label>';

    // Create input
    $labelInput .= '<input class="form-control" type="' . $inputType .
                                             '" name="' . $inputId .
                                             '" id="' . $inputId . '"' .
                                             ($inputValue === null || empty($inputValue) ? '' : ' value="' . $inputValue . '"') .
                                             '>';
    // Create error message
    if ($errorMsg !== null)
    {
      $labelInput .= '<span class="errorMsg">' . $errorMsg . '</span>';
    }

    // Close div
    $labelInput .= '</div></div>';

    return $labelInput;
  }

  public static function createLabelInputFile($label, $acceptedFiles, $inputId, $inputValue, $errorMsg = null)
  {
    // Open div
    $labelInputFile = '<div class="col-md-11"><div class="form-group">';

    // Create label
    $labelInputFile .= '<label for="' . $inputId . '">' . $label . '</label>';

    // Create input
    $labelInputFile .= '<input type="file' .
                                   '" accept="' . $acceptedFiles .
                                   '" name="' . $inputId .
                                   '" id="' . $inputId . '"' .
                                   ($inputValue === null || empty($inputValue) ? '' : ' value="' . $inputValue . '"') .
                                   '>';
    // Create error message
    if ($errorMsg !== null)
    {
      $labelInputFile .= '<span class="errorMsg">' . $errorMsg . '</span>';
    }

    // Close div
    $labelInputFile .= '</div></div>';

    return $labelInputFile;
  }

  public static function createLabelTextArea($label, $textAreaId, $textAreaValue, $errorMsg = null, $rows = 4,  $cols = 50)
  {
    // Open div
    $labelTextArea = '<div class="col-md-11"><div class="form-group">';

    // Create label
    $labelTextArea .= '<label for="' . $textAreaId . '">' . $label . '</label>';

    // Create textarea
    $labelTextArea .= '<textarea class="form-control' .
                                   '" rows="' . $rows .
                                   '" cols="' . $cols .
                                   '" name="' . $textAreaId .
                                   '" id="' . $textAreaId . '">';

    $labelTextArea .= ($textAreaValue === null || empty($textAreaValue)) ? "" : $textAreaValue;

    $labelTextArea .= "</textarea>";

    // Create error message
    if ($errorMsg !== null)
    {
      $labelTextArea .= '<span class="errorMsg">' . $errorMsg . '</span>';
    }

    // Close div
    $labelTextArea .= '</div></div>';

    return $labelTextArea;
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