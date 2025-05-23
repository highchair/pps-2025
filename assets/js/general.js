/* Check for mouse clicks, enter keypress (13), or spacebar keypress (32) */
/* https://karlgroves.com/2014/11/24/ridiculously-easy-trick-for-keyboard-accessibility */
function a11yClick(event){
  if(event.type === 'click') {
    return true;
  } else if(event.type === 'keypress') {
    var code = event.charCode || event.keyCode;
    if((code === 32)|| (code === 13)) {
      return true;
    }
  } else {
    return false;
  }
}


document.addEventListener("DOMContentLoaded", function() {
  document.body.classList.remove("no-js");
  document.body.classList.add("js");

  // Wordpress menu markup is not what we want. Adding aria attributes to work with our below JS
  var btns = document.querySelectorAll('.nav__list .menu-item-has-children > a');
  if (btns) {
    btns.forEach(function(btn) {
      btn.setAttribute('role', 'button');
      btn.setAttribute('aria-haspopup', 'true');
      btn.setAttribute('aria-expanded', 'false');

      btn.addEventListener('click', function (e) {
        var expanded = btn.getAttribute('aria-expanded');
        // Close all
        btns.forEach(function(btn) {
          btn.setAttribute('aria-expanded', 'false');
        });
        // Other the one that was clicked
        if (expanded == 'false') {
          btn.setAttribute('aria-expanded', 'true');
        }
      });
    });
  }

  // Expand / Collapse utility
  //
  // Minimum expected markup:
  // <div>
  //   <div>
  //     <button id="summaryId" class="js__toggle" aria-expanded="false" aria-controls="targetId">See More</button>
  //   </div>
  //   <div id="targetId" aria-labelledby="summaryId" class="aria-expand">Content to reveal here</div>
  // </div>
  //
  // This function ONLY toggles a show/hide class on the target and toggles aria-expanded
  // Any other functionality (like swapping the text content if true/false) needs to be in the component JS
  document.querySelectorAll(".js__toggle").forEach(function(toggle_element) {
    toggle_element.addEventListener('click', function(event) {
      event.preventDefault();
      if (a11yClick(event) === true) {
        var expanded = toggle_element.getAttribute('aria-expanded');
        var target_id = toggle_element.getAttribute('aria-controls');
        var target_element = document.getElementById(target_id);
  
        if (expanded == 'true') {
          toggle_element.setAttribute('aria-expanded', 'false');
          target_element.classList.remove('js__aria-expanded')
        } else {
          toggle_element.setAttribute('aria-expanded', 'true');
          target_element.classList.add('js__aria-expanded')
        }
      }
    })
  });

  // Using Intersection observer to check whether the page has been scrolled
  // Source: https://css-tricks.com/using-intersectionobserver-to-check-if-page-scrolled-past-certain-point/
  if (
    "IntersectionObserver" in window &&
    "IntersectionObserverEntry" in window &&
    "intersectionRatio" in window.IntersectionObserverEntry.prototype
  ) {
    let observer = new IntersectionObserver(entries => {
      if (entries[0].boundingClientRect.y < 0) {
        document.body.classList.remove("not-scrolled");
        document.body.classList.add("scrolled");
      } else {
        document.body.classList.add("not-scrolled");
        document.body.classList.remove("scrolled");
      }
    });
    observer.observe(document.querySelector("#header"));
  }

});
