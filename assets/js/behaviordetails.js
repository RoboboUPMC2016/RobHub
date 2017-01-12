$(document).ready(function() {
  // BD = Behavior Details
  var BD = {
    init: function() {
      // First we well init the inputs
      BD.getMarkByBehaviorId(BD.initInputRating);
      BD.getMarkByBehaviorId(BD.initInputMyRating);      

      // Update average after rating
      $(BD.inputMyRating).on("rating.change", function(event, value, caption) {
        $.get(
          "api/ratebehavior.php",
          {bid: BD.behaviorId, mark: value},
          function(data) {
            // Must update average as we rated the behavior
            BD.getMarkAvgByBehaviorId(BD.updateInputRating, BD.inputRating, true, false);
          },
          "json"
        );
      });

      // Init gallery video
      $("#gallery-videos").lightGallery();
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
    getMarkAvgByBehaviorId: function(callback, input, disableInput, initInput = true) {
      $.get(
        "api/getmarkavgbybehaviorid.php",
        {bid: BD.behaviorId},
        function(data) {
          callback(data, input, disableInput, initInput);
        },
        "json"
      );
    },
    initInputRating: function(data) {
      BD.getMarkAvgByBehaviorId(BD.updateInputRating, BD.inputRating, true);
    },
    initInputMyRating: function(data) {
      // -1 => NOT_AUTHENTICATED
      var disableInput = data.code === -1;
      BD.updateInputRating(data, BD.inputMyRating, disableInput);
    },
    updateInputRating: function(data, input, disableInput, initInput = true) {
      // Update input rating value
      if (data.code === 0) {
        // data.message = value
        $(input).val(data.message);
      }

      if (initInput) {
        // Init input rating
        $(input).rating({
          size: "xs",
          step: 1,
          showCaption: false,
          showClear: false,
          disabled: disableInput // Behavior already rated : we do not allow to rate
        });
      }
      else {
        // Update input rating
        BD.disableInputRating(input);
      }
    },
    disableInputRating: function(input) {
      $(input).rating("refresh", {
        disabled: true
      });
    },
    inputRating: $("#input-rating"),
    inputMyRating: $("#input-my-rating"),
    behaviorId: getUrlParameters("bid")
  };

  BD.init();
});