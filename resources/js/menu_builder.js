import React from 'react';
import ReactDOM from 'react-dom';
import MenuBuilder from './components/MenuBuider';
let Id = 'react-menu_builder';

if (document.getElementById(Id)) {
    let elem = $('#' + Id);
    let getItems = elem.attr('data-items');
    ReactDOM.render(<MenuBuilder getItems={getItems} />, document.getElementById(Id));
}
// $( "#menu-builders" ).sortable();
// $( "#menu-builders" ).disableSelection();
