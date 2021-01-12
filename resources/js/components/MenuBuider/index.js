import React, { Component } from 'react';
import Axios from 'axios';
import Item from './Item';

class MenuBuilder extends Component {
    constructor(props) {
        super(props)
        this.state = {
            items: this.props.Items ? this.props.Items : [],
            newChanges: []
        }
        if (this.props.getItems) {
            Axios.get(this.props.getItems).then(res => {
                let { parent_items } = res.data;
                this.setState(prevState => ({
                    items: parent_items.sort((a, b) => (a.order > b.order) ? 1 : -1),
                }));
            });
        }
        
    }
    injectJquery = () => {
        let state = this.state;
        let setState = this.setState.bind(this);
        let old_position = null;
        $("#menu_sortable").sortable({
            start: function(e, ui) {
                // puts the old positions into array before sorting
                old_position = ui.item.index();
            },
            update: function( event, ui ) {
                let { item } = ui;
                let identifier = Number(item.attr('data-identifier'));
                let parent   = Number(item.attr('data-parent'));
                let eParent  = item.parent()[0];
                let newPlace = $(' li', eParent).index(item)
                let newState = state.items.map(menuItem => {
                    if ((menuItem.id == identifier)) {
                        menuItem.order = newPlace
                    } else if (menuItem.order == newPlace) {
                        if (old_position > newPlace) {
                            menuItem.order = newPlace + 1
                        } else {
                            menuItem.order = newPlace - 1
                        }
                    } else if (menuItem.order == (old_position - 1)) {
                        menuItem.order = old_position
                    }
                    return menuItem;
                });
                setState(prevState => ({
                    items: newState
                }));
            },
        })
    }
    render() {
        return (
            <div className="menu-builder">
                <ul className="col-md-4 col-12" id="menu_sortable">
                    {
                        this.state.items.map((menuItem, i) => {
                            return (<Item key={i} {...menuItem}/>)
                        })
                    }
                    {this.injectJquery()}
                </ul>
            </div>
        );
    }
}

export default MenuBuilder;