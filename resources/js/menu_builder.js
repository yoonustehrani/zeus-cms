import React from 'react';
import ReactDOM from 'react-dom';
import MenuBuilder from './components/MenuBuider';

let Id = 'react-menu_builder';

if (document.getElementById(Id)) {
    let elem = $('#' + Id);
    let getItems = elem.attr('data-menu-show'),
    updateItems  = elem.attr('data-menu-update'),
    storeItem    = elem.attr('data-store'),
    destroyItem    = elem.attr('data-destroy'),
    updateItem    = elem.attr('data-update');
    ReactDOM.render(
        <MenuBuilder
            getItems={getItems}
            updateItems={updateItems}
            storeItem={storeItem}
            updateItem={updateItem}
            destroyItem={destroyItem}
        />,
        document.getElementById(Id)
    );
}
// $( "#menu-builders" ).sortable();
// $( "#menu-builders" ).disableSelection();
