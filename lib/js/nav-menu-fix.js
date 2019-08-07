document.addEventListener("DOMContentLoaded", function(event) {
	if (is_touch_device()) {
		document.querySelectorAll('.menu-header-right .menu-item-has-children>a').forEach(function(element){
			element.setAttribute('data-original-href', element.getAttribute('href'))
			element.setAttribute('href', '#')
			element.onclick = function(event){
				event.preventDefault()
					if (!element.classList.contains('expanded-parent-item')) {
						wipeExpandedClasses()
						element.classList.add('expanded-parent-item')
					} else {
						window.location = element.getAttribute('data-original-href')
					}
			}
		})
	}
});

function wipeExpandedClasses() {
		document.querySelectorAll('.expanded-parent-item').forEach(function(element){element.classList.remove('expanded-parent-item')});
}

// Function to test if device is touch or not using Modernizr's implementation:
// https://github.com/Modernizr/Modernizr/blob/master/feature-detects/touchevents.js
function is_touch_device() {
    var prefixes = ' -webkit- -moz- -o- -ms- '.split(' ');
    var mq = function(query) {
        return window.matchMedia(query).matches;
    }

	  if (('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch) {
		  return true;
		}
		
    // include the 'heartz' as a way to have a non matching MQ to help terminate the join
    // https://git.io/vznFH
    var query = ['(', prefixes.join('touch-enabled),('), 'heartz', ')'].join('');
    return mq(query);
}