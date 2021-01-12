import React, { Component } from 'react';
import Axios from 'axios';
import Item from './Item';
import AddItem from './AddItem';

class MenuBuilder extends Component {
    constructor(props) {
        super(props)
        this.state = {
            items: this.props.Items ? this.props.Items : [],
            newChanges: [],
            createForm: true
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
    toggleCreateForm = () => {
        this.setState(prevState => ({
            createForm: ! prevState.createForm
        }))
    }
    onSubmitForm = () => {

    }
    injectJquery = () => {
        let state = this.state;
        let setState = this.setState.bind(this);
        let old_position = null;
        let {updateItems} = this.props;
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
                let newChanges = {};
                let newState = state.items.map(menuItem => {
                    if ((menuItem.id == identifier)) {
                        menuItem.order = newPlace;
                        newChanges[menuItem.id] = {order: newPlace};
                    } else if (menuItem.order == newPlace) {
                        let newOrder = old_position > newPlace ? newPlace + 1 : newPlace - 1
                        menuItem.order = newOrder;
                        newChanges[menuItem.id] = {order: newOrder};
                    } else {
                        if (menuItem.order < newPlace && menuItem.order > old_position) {
                            let newOrder = menuItem.order - 1;
                            menuItem.order = newOrder;
                            newChanges[menuItem.id] = {order: newOrder};
                        } else if(menuItem.order > newPlace && menuItem.order < old_position) {
                            let newOrder = menuItem.order + 1;
                            menuItem.order = newOrder;
                            newChanges[menuItem.id] = {order: newOrder};
                        }
                    }
                    return menuItem;
                });
                // console.log(newChanges);
                setState(prevState => ({
                    items: newState
                }), () => {
                    Axios.post(updateItems, {items: newChanges}).then(res => {
                        console.log(res.data);
                    })
                });
                
            },
        })
    }
    render() {
        return (
            <div className="menu-builder">
                <div className="col-12 float-left mb-3">
                    <button className="btn btn-warning" onClick={this.toggleCreateForm}>
                        <i className={`fas fa-${this.state.createForm ? 'minus' : 'plus'}`}></i>
                    </button>
                </div>
                <div className={`col-12 mb-4 pl-5 float-left ${this.state.createForm ? '' : 'd-none'}`}>
                    <AddItem onSubmit={this.onSubmitForm}/>
                </div>
                <ul className="col-md-4 col-12 float-left" id="menu_sortable">
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