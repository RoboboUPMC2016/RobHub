// Source : https://www.creativejuiz.fr/blog/javascript/recuperer-parametres-get-url-javascript
function getUrlParameters(param) {
  var vars = {};
  window.location.href.replace(location.hash, "").replace( 
      /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
      function(m, key, value) { // callback
          vars[key] = value !== undefined ? value : "";
      }
  );

  if (param) {
      return vars[param] ? vars[param] : null;    
  }
  return vars;
}