import React from 'react';
import ReactDOM from 'react-dom';
import MenuBuilder from './components/MenuBuider';
let Id = 'react-menu_builder';

if (document.getElementById(Id)) {
    let elem = $('#' + Id);
    let getItems = elem.attr('data-items'),
    updateItems  = elem.attr('data-update'),
    storeItem    = elem.attr('data-store');
    ReactDOM.render(<MenuBuilder getItems={getItems} updateItems={updateItems} storeItem={storeItem}/>, document.getElementById(Id));
}
// $( "#menu-builders" ).sortable();
// $( "#menu-builders" ).disableSelection();
