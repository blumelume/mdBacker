$( document ).ready( function() {

  $( 'nav#main .accordion#sections .section li' ).each( function(i, el) {
    href = window.location.href;

    t = href.substring( href.indexOf('lectern') + 7 ); // removing everything before and including 'lectern'
    t = t.replace(/^\/|\/$/g, '')
    console.log(t);

    /* finding currently active element and highlighting it (adding class 'curr') */
    if (el.id == t) {
      $(el).addClass( 'curr' );
    }

    /* adding event listeners for naviagtion through left nav */
    $(el).click( (evt) => {
      evt.stopPropagation();

      s = href.substring(href.indexOf('lectern'), 0) + 'lectern/' + el.id;
      window.location.href = s;

    });
  });

  console.log( window.location.search );

});