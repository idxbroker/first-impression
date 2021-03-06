/* global jQuery */
/* eslint no-undef: "error" */

jQuery(document).foundation()

// Sets placeholder text to label text
function makeLabelsPlaceholders (labels) {
  labels.forEach(function (_, i) {
    var label = labels.item(i)
    var text = label.textContent
    label.parentNode.classList.contains('required') && (text += '*')
    if (label.nextElementSibling) {
      label.nextElementSibling.setAttribute('placeholder', text)
      label.remove()
    }
  })
}

jQuery(function ($) {
  // Enable responsive menu icon for mobile
  $('.nav-header-right').addClass('responsive-menu').before('<a href="" class="menu-toggle"><span class="screen-reader-text">Menu</span><i class="fas fa-bars"></i><span class="hide"><span class="screen-reader-text">Close</span><i class="fas fa-times"></i></span></a>')

  $('.menu-toggle').click(function (e) {
    e.preventDefault()
    $('.nav-header-right').slideToggle()
    $('.menu-toggle .fa-bars').toggle()
    $('.menu-toggle .hide').toggle()
  })

  // Add fullscreen to map widget section
  $('*[class^="home-middle"]').has('.impress-idx-dashboard-widget').addClass('first-impression-fullscreen impress-idx-dashboard-widget-section')

  // The Equity widget doesn't support placeholder text for a vertical property search, so let's add it via the label tag
  makeLabelsPlaceholders(document.querySelectorAll('.sidebar .equity-idx-search-widget label'))
  makeLabelsPlaceholders(document.querySelectorAll('.idx-omnibar-extra-form .idx-omnibar-extra label'))
})

// Fix default property carousel responsive break points
window.addEventListener('DOMContentLoaded', function () {
  if (jQuery('.owl-carousel').length) {
    jQuery('.owl-carousel').data()['owl.carousel'].options.responsive['550'] = jQuery('.owl-carousel').data()['owl.carousel'].options.responsive['450']
    delete jQuery('.owl-carousel').data()['owl.carousel'].options.responsive['450']
    jQuery('.owl-carousel').trigger('refresh.owl.carousel')
  }
})
