<?php
class FormWritter
{
  public static function createLabelInput($label, $inputType, $inputId, $inputValue = NULL, $errorMsg = NULL)
  {
    html::add_attribute("class", "col-md-11");
    html::tag("div");
      html::add_attribute("class", "form-group");
      html::tag("div");
        // Label
        html::add_attribute("for", $inputId);
        html::tag("label", $label);

        // Input
        $attributes = ["class" => "form-control", "type" => $inputType, "name" => $inputId, "id" => $inputId];
        if ($inputValue !== NULL)
        {
          $attributes["value"] = $inputValue;
        }
        html::add_attributes($attributes);
        html::single_tag("input");

        // Error message
        if ($errorMsg !== NULL)
        {
          html::add_attribute("class", "invalidInput");
          html::tag("span", $errorMsg);
        }
      html::close();
    html::close();
  }

  public static function createSubmitBtn($name, $value)
  {
    html::add_attribute("class", "col-md-12");
    html::tag("div");
      html::add_attribute("class", "form-group");
      html::tag("div");
        html::add_attributes(["class" => "btn btn-primary", "type" => "submit", "name" => $name, "value" => $value]);
        html::single_tag("input");
      html::close();
    html::close();
  }
}
?>