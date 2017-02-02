<?php
/**
 * The class HtmlWriterUtils defines utily methods to
 * generate HTML contents.
 */
class HtmlWriterUtils
{
  /**
   * Create a label with an input.
   *
   * @param string $label The label of the label input..
   * @param string $inputType The type of the input.
   * @param string $inputId The Id of the input.
   * @param string $inputValue The value of the input.
   * @param string|default(null) $errorMsg The error message to show.
   * @return string The HTML contents of the label and the input.
   */
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

  /**
   * Create a label with an input file.
   *
   * @param string $label The label of the label input..
   * @param string $acceptedFiles The accepted files for the input.
   * @param string $inputId The Id of the input.
   * @param string $inputValue The value of the input.
   * @param string|default(null) $errorMsg The error message to show.
   * @return string The HTML contents of the label and the input file.
   */
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

  /**
   * Create a label with an text area.
   *
   * @param string $label The label of the label input..
   * @param string $textAreaId The Id of the text area.
   * @param string $textAreaValue The value of the text area.
   * @param string|default(null) $errorMsg The error message to show.
   * @param integer|default(4) $rows The number of rows.
   * @param integer|default(50) $cols The number of columns.
   * @return string The HTML contents of the label and the text area..
   */
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

  /**
   * Create a submit button.
   *
   * @param string $name The name of the button.
   * @param string $value The value of the button.
   */
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