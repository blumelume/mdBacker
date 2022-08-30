$( document ).ready( function() {

  $( 'nav#main .accordion#sections .section li button' ).each( function(i, el) {
    href = window.location.href;

    t = href.substring( href.indexOf('lectern') + 7 ); // removing everything before and including 'lectern'
    t = t.replace(/^\/|\/$/g, '')

    /* finding currently active element and highlighting it (adding class 'curr') */
    if (el.parentNode.id == t) {
      $(el).addClass( 'curr' );
    }

    /* adding event listeners for naviagtion through left nav */
    $(el).click( (evt) => {
      evt.stopPropagation();

      s = href.substring(href.indexOf('lectern'), 0) + 'lectern/' + el.parentNode.id;
      window.location.href = s;

    });
  });

  $( '.content form.fields textarea' ).each( function(i, el) {
    el.simplemde = new SimpleMDE({
      element: el
    });
  });

});