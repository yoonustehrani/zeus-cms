import React, { Component } from 'react';

class Item extends Component {
    constructor(props) {
        super(props)
        let {title, url, route, target, icon_class, children} = this.props;
        this.state = {
            title: title,
            url: url,
            route: route,
            target: target,
            icon_class: icon_class,
            children: children
        }
    }
    componentDidMount() {
        let {id} = this.props;
        $('#' + `parent-with-child-${id}`).sortable();
    }
    render() {
        let {title, url, route, target, icon_class} = this.state;
        let {id} = this.props;
        return (
            <li id={`setorder_${id}`} data-identifier={id} data-parent={null} className="ui-state-default">
                <div className="item">
                    <span className="item-data">
                    <i className={`fas fa-${icon_class} mr-2`} />
                    { 
                        route ? `${title}(${route})` : <a target={target} href={url}>{title}</a>
                    }
                    </span>
                    <span className="item-action">
                        <button className="btn btn-sm btn-info rounded-circle mr-2">
                            <i className="fas fa-pencil-alt"></i>
                        </button>
                        <button className="btn btn-sm btn-danger rounded-circle">
                            <i className="fas fa-trash"></i>
                        </button>
                    </span>
                </div>
                {this.state.children.length > 0 &&
                    <div>
                        <ul id={`parent-with-child-${id}`} className="children-list">
                            {this.state.children.map((child, i) => {
                                return (<Item key={i} {...child}/>)
                            })}
                        </ul>
                    </div>
                }
            </li>
        );
    }
}

export default Item;