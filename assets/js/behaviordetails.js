$(document).ready(function() {
  // Behavior Details
  var BD = {
    init: function() {
      // First we well init the inpute rating
      BD.getMarkByBehaviorId(BD.initInputRating);      

      // Change value callback
      $(BD.inputRating).on("rating.change", function(event, value, caption) {
        $.get(
          "api/ratebehavior.php",
          {bid: BD.behaviorId, mark: value},
          function(data) {
            // Must update average as we rated the behavior
            BD.getMarkAvgByBehaviorId(BD.updateInputRating, true, false);
          },
          "json"
        );
      });
    },
    getMarkByBehaviorId: function(callback) {
       $.get(
        "api/getmarkbybehaviorid.php",
        {bid: BD.behaviorId},
        function(data) {
          callback(data);
        },
        "json"
      );
    },
    getMarkAvgByBehaviorId: function(callback, disableInput, initInput = true) {
       $.get(
        "api/getmarkavgbybehaviorid.php",
        {bid: BD.behaviorId},
        function(data) {
          callback(data, disableInput, initInput);
        },
        "json"
      );
    },
    initInputRating: function(data) {
      // Not already rated or not authenticated
      var disableInput = data.code === 0 || data.code === -1;
      BD.getMarkAvgByBehaviorId(BD.updateInputRating, disableInput);
    },
    updateInputRating: function(data, disableInput, initInput = true) {
      // Update input rating value with average
      if (data.code === 0) {
        // data.message = average
        $(BD.inputRating).val(data.message);
      }

      if (initInput) {
        // Init input rating
        $(BD.inputRating).rating({
          size: "xs",
          step: 1,
          showCaption: false,
          showClear: false,
          disabled: disableInput // Behavior already rated : we do not allow to rate
        });
      }
      else {
        // Update input rating
        $(BD.inputRating).rating("refresh", {
          disabled: disableInput
        });
      }
    },
    inputRating: $("#input-rating"),
    behaviorId: getUrlParameters("bid")
  };

  BD.init();
});